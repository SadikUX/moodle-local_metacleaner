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

// Check if user has capability.
require_capability('local/metacleaner:manage', context_system::instance());

// Set up the page as an external admin page and check access based on the 'local/metacleaner:manage' capability.
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

// Get plugin settings.
$categoryfilter = get_config('local_metacleaner', 'category');
$maxusers = get_config('local_metacleaner', 'maxusers');
$mindays = get_config('local_metacleaner', 'mindays');
$action = get_config('local_metacleaner', 'action'); // 1 = deactivate, 2 = delete.

// Retrieve courses whose end date has passed.
$expiredcourses = $DB->get_records_select('course', 'enddate > 0 AND enddate < ?', [time()]);

// Apply filters based on plugin settings.
$filteredcourses = [];
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

    // Add the course to the filtered list.
    $filteredcourses[] = (object)[
        'course' => $course,
        'metaenrolments' => count($metaenrolments),
        'affectedusers' => $totalusers,
    ];
}

// Handle CSV export.
if (optional_param('export', false, PARAM_BOOL)) {
    export_preview_to_csv($filteredcourses, $action);
    exit;
}

// Start rendering the page.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('previewheading', 'local_metacleaner'));

// Check if there are no filtered courses.
if (empty($filteredcourses)) {
    // Display a message if no courses are affected.
    echo $OUTPUT->notification(get_string('nocourses', 'local_metacleaner'), 'notifymessage');
} else {
    // Create a table to display filtered courses.
    $table = new html_table();
    $table->head = [
        get_string('coursename', 'local_metacleaner'), // Column for course name.
        get_string('courseid', 'local_metacleaner'),  // Column for course ID.
        get_string('metaenrolments', 'local_metacleaner'), // Column for meta enrolments count.
        get_string('affectedusers', 'local_metacleaner'), // Column for affected users count.
        get_string('action', 'local_metacleaner'), // Column for action.
    ];

    // Loop through each filtered course.
    foreach ($filteredcourses as $filteredcourse) {
        $actiontext = ($action == 1) ? get_string('deactivate', 'local_metacleaner') : get_string('delete', 'local_metacleaner');

        // Add a row to the table with course details.
        $table->data[] = [
            format_string($filteredcourse->course->fullname), // Format and display the course name.
            $filteredcourse->course->id,                      // Display the course ID.
            $filteredcourse->metaenrolments,                  // Display the count of meta enrolments.
            $filteredcourse->affectedusers,                   // Display the count of affected users.
            $actiontext,                                      // Display the action.
        ];
    }

    // Render the table on the page.
    echo html_writer::table($table);

    // Add an export button.
    $exporturl = new moodle_url('/local/metacleaner/preview.php', ['export' => 1]);
    echo $OUTPUT->single_button($exporturl, get_string('exportcsv', 'local_metacleaner'));
}

// Finish rendering the page.
echo $OUTPUT->footer();

/**
 * Export the preview data to a CSV file.
 *
 * @param array $filteredcourses List of filtered courses.
 * @param int $action The action to be performed (1 = deactivate, 2 = delete).
 */
function export_preview_to_csv($filteredcourses, $action) {
    global $DB;

    // Set CSV headers.
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="metacleaner_preview.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Course Name', 'Course ID', 'Meta Enrolments', 'Affected Users', 'Action']);

    foreach ($filteredcourses as $filteredcourse) {
        $actiontext = ($action == 1) ? 'Deactivate' : 'Delete';

        fputcsv($output, [
            format_string($filteredcourse->course->fullname),
            $filteredcourse->course->id,
            $filteredcourse->metaenrolments,
            $filteredcourse->affectedusers,
            $actiontext,
        ]);
    }

    fclose($output);
}
