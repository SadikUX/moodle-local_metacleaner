<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Library functions for the MetaCleaner local plugin.
 *
 * @package     local_metacleaner
 * @copyright   2025 Sadik Mert
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Cron function to clean up expired meta enrollments.
 *
 * This function is responsible for cleaning up meta-enrollments linked to expired courses.
 * The action to be performed (deactivate or delete) is determined by the plugin setting.
 */
function local_metacleaner_cron() {
    global $DB;

    // Check if the plugin is enabled.
    if (!get_config('local_metacleaner', 'enable')) {
        mtrace(get_string('plugin_disabled', 'local_metacleaner'));
        return;
    }

    // Get plugin settings.
    $action = get_config('local_metacleaner', 'action');
    $categoryfilter = get_config('local_metacleaner', 'category');
    $maxusers = get_config('local_metacleaner', 'maxusers');
    $mindays = get_config('local_metacleaner', 'mindays');

    if (!isset($action) || !in_array($action, [1, 2])) {
        mtrace(get_string('invalid_action', 'local_metacleaner'));
        return;
    }
    if ($maxusers < 0 || $mindays < 0) {
        mtrace(get_string('invalid_config', 'local_metacleaner'));
        return;
    }

    // Get all courses whose end date has passed.
    $expiredcourses = $DB->get_records_select('course', 'enddate > 0 AND enddate < ?', [time()]);

    if (!$expiredcourses) {
        mtrace(get_string('no_expired_courses', 'local_metacleaner'));
        return;
    }

    foreach ($expiredcourses as $course) {
        if (empty($course->enddate) || empty($course->category)) {
            mtrace(get_string('missing_course_data', 'local_metacleaner', $course->id));
            continue;
        }

        // Apply category filter.
        if ($categoryfilter && $course->category != $categoryfilter) {
            continue;
        }

        // Calculate days since course end.
        $dayssinceend = (time() - $course->enddate) / DAYSECS;
        if ($dayssinceend < $mindays) {
            continue;
        }

        // Count the number of users in meta enrolments.
        $metaenrolments = $DB->get_records('enrol', ['enrol' => 'meta', 'customint1' => $course->id]);
        $totalusers = 0;
        foreach ($metaenrolments as $enrol) {
            $totalusers += $DB->count_records('user_enrolments', ['enrolid' => $enrol->id]);
        }

        if ($totalusers < 0) {
            mtrace(get_string('invalid_user_count', 'local_metacleaner', $course->id));
            continue;
        }

        // Apply max users filter.
        if ($totalusers > $maxusers) {
            continue;
        }

        if (empty($metaenrolments)) {
            mtrace(get_string('no_meta_enrolments', 'local_metacleaner', $course->id));
            continue; // Skip courses without meta enrolments.
        }

        foreach ($metaenrolments as $enrol) {
            if (empty($enrol->customint1)) {
                mtrace(get_string('missing_customint1', 'local_metacleaner', $enrol->id));
                continue;
            }
        }

        mtrace(get_string('processing_course', 'local_metacleaner', [
            'id' => $course->id,
            'fullname' => $course->fullname,
            'users' => $totalusers,
        ]));

        // Perform the action (deactivate or delete).
        $transaction = $DB->start_delegated_transaction();
        try {
            foreach ($metaenrolments as $enrol) {
                if ($action == 1) {
                    // Deactivate the meta enrolment.
                    $DB->set_field('enrol', 'status', 1, ['id' => $enrol->id]);
                } else if ($action == 2) {
                    // Delete all users in this meta enrolment.
                    $DB->delete_records('user_enrolments', ['enrolid' => $enrol->id]);
                    // Delete the meta enrolment itself.
                    $DB->delete_records('enrol', ['id' => $enrol->id]);
                }
            }
            $transaction->allow_commit();
        } catch (Exception $e) {
            $transaction->rollback($e);
            mtrace(get_string('error_processing_course', 'local_metacleaner', [
                'id' => $course->id,
                'message' => $e->getMessage(),
            ]));
            continue;
        }
    }
}
