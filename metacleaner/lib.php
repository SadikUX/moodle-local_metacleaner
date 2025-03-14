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
        // If the plugin is disabled, exit the function.
        return;
    }

    // Get all courses whose end date has passed.
    $expiredcourses = $DB->get_records_select('course', 'enddate > 0 AND enddate < ?', [time()]);
    // Get the user's preference from the settings (1 = deactivate, 2 = delete).
    $action = get_config('local_metacleaner', 'action');

    foreach ($expiredcourses as $course) {
        // Get all meta enrollments for this expired course.
        $metaenrolments = $DB->get_records('enrol', ['enrol' => 'meta', 'customint1' => $course->id]);

        foreach ($metaenrolments as $enrol) {
            if ($action == 1) {
                // Deactivate the meta enrollment instead of deleting it.
                $DB->set_field('enrol', 'status', 1, ['id' => $enrol->id]);
            } else if ($action == 2) {
                // Delete all users who are in this meta enrollment.
                $DB->delete_records('user_enrolments', ['enrolid' => $enrol->id]);
                // Delete the meta enrollment itself.
                $DB->delete_records('enrol', ['id' => $enrol->id]);
            } else {
                return false;
            }
        }
    }
}
