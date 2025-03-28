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
 * Language strings for the MetaCleaner local plugin.
 *
 * @package     local_metacleaner
 * @copyright   2025 Sadik Mert
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


$string['action'] = 'Action';
$string['affectedusers'] = 'Affected users';
$string['allcategories'] = 'All categories';


$string['courseid'] = 'Course ID';
$string['coursename'] = 'Course name';


$string['deactivate'] = 'Deactivate';
$string['delete'] = 'Delete';


$string['enable'] = 'Enable Meta Cleaner';
$string['enable_help'] = 'Enable the Meta Cleaner functionality, which will clean up expired meta enrolments.';
$string['enrolaction'] = 'Action for expired meta enrolments';
$string['enrolaction_help'] = 'Select the action to be performed on expired meta enrolments. You can either deactivate them (keep them inactive) or delete them entirely.';
$string['error_processing_course'] = 'Error processing course {$a->id}: {$a->message}';
$string['exportcsv'] = 'Export as CSV';


$string['filterbycategory'] = 'Filter by category';
$string['filterbycategory_help'] = 'Only clean up courses in the selected category.';


$string['invalid_action'] = 'Invalid action configuration. Skipping cleanup.';
$string['invalid_config'] = 'Invalid maxusers or mindays configuration. Skipping cleanup.';
$string['invalid_user_count'] = 'Skipping course {$a} due to invalid user count.';


$string['maxusers'] = 'Maximum number of users';
$string['maxusers_help'] = 'Only clean up courses with fewer than this number of users.';
$string['meta_enrolment_note'] = '<span style="color: red;">If a course end date is extended or removed, the deactivated meta enrolments will be automatically reactivated by this plugin.</span>';
$string['metacleaner:manage'] = 'Manage the MetaCleaner plugin';
$string['metaenrolcleanup'] = 'Meta-Enrolment Cleanup';
$string['metaenrolments'] = 'Meta enrolments';
$string['mindays'] = 'Minimum days since course end';
$string['mindays_help'] = 'Only clean up courses that ended at least this many days ago.';
$string['missing_course_data'] = 'Skipping course {$a} due to missing end date or category.';
$string['missing_customint1'] = 'Skipping enrolment {$a} due to missing customint1 value.';


$string['no_expired_courses'] = 'No expired courses found. Exiting.';
$string['no_meta_enrolments'] = 'No meta enrolments found for course {$a}. Skipping.';
$string['nocourses'] = 'No courses match the selected criteria.';


$string['plugin_disabled'] = 'MetaCleaner is disabled. Exiting.';
$string['pluginname'] = 'Meta Cleaner';
$string['pluginnotenabled'] = 'Meta Cleaner not enabled.';
$string['previewheading'] = 'Meta Cleaner: Preview affected courses';
$string['previewlimit'] = 'Preview Limit per Page';
$string['previewlimit_help'] = 'The number of courses to display per page on the preview page.';
$string['privacy:metadata'] = 'The MetaCleaner plugin does not store any personal data.';
$string['processing_course'] = 'Processing course {$a->id} ({$a->fullname}) with {$a->users} users.';


$string['reactivated_meta_enrolment'] = 'Reactivated meta enrolment with ID {$a}.';
