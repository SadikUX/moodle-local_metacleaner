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
 * Preview page for the MetaCleaner local plugin.
 *
 * @package     local_metacleaner
 * @copyright   2025 Sadik Mert
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php'); // Include Moodle's main configuration file.
require_once($CFG->libdir . '/adminlib.php'); // Include Moodle's admin library for admin page setup.

// Restrict access to administrators only.
admin_externalpage_setup('local_metacleaner_preview');

// Check if the plugin is enabled in the settings.
if (!get_config('local_metacleaner', 'enable')) {
    // If the plugin is disabled, display a notification and exit.
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('pluginnotenabled', 'local_metacleaner'), 'notifyproblem');
    echo $OUTPUT->footer();
    exit;
}

global $DB, $OUTPUT; // Access global database and output objects.

// Retrieve courses whose end date has passed.
$expiredcourses = $DB->get_records_select('course', 'enddate > 0 AND enddate < ?', [time()]);

// Start rendering the page.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('previewheading', 'local_metacleaner'));

// Check if there are no expired courses.
if (empty($expiredcourses)) {
    // Display a message if no courses are affected.
    echo $OUTPUT->notification(get_string('nocourses', 'local_metacleaner'), 'notifymessage');
} else {
    // Create a table to display affected courses.
    $table = new html_table();
    $table->head = [
        get_string('coursename', 'local_metacleaner'), // Column for course name.
        get_string('courseid', 'local_metacleaner'),  // Column for course ID.
        get_string('metaenrolments', 'local_metacleaner'), // Column for meta enrolments count.
    ];

    // Loop through each expired course.
    foreach ($expiredcourses as $course) {
        // Count the number of meta enrolments for the course.
        $metaenrolments = $DB->count_records('enrol', ['enrol' => 'meta', 'customint1' => $course->id]);
        // Add a row to the table with course details.
        $table->data[] = [
            format_string($course->fullname), // Format and display the course name.
            $course->id,                      // Display the course ID.
            $metaenrolments,                  // Display the count of meta enrolments.
        ];
    }

    // Render the table on the page.
    echo html_writer::table($table);
}

// Finish rendering the page.
echo $OUTPUT->footer();
