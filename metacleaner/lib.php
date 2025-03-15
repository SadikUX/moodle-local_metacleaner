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
        return;
    }

    // Get plugin settings.
    $action = get_config('local_metacleaner', 'action');
    $categoryfilter = get_config('local_metacleaner', 'category');
    $maxusers = get_config('local_metacleaner', 'maxusers');
    $mindays = get_config('local_metacleaner', 'mindays');

    // Get all courses whose end date has passed.
    $expiredcourses = $DB->get_records_select('course', 'enddate > 0 AND enddate < ?', [time()]);

    foreach ($expiredcourses as $course) {
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

        // Apply max users filter.
        if ($totalusers > $maxusers) {
            continue;
        }

        // Perform the action (deactivate or delete).
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
    }
}
