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
 * Settings for the MetaCleaner local plugin.
 *
 * @package     local_metacleaner
 * @copyright   2025 Sadik Mert
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig && has_capability('local/metacleaner:manage', context_system::instance())) {
    // Create a new settings page for the plugin.
    $settings = new admin_settingpage('local_metacleaner', get_string('pluginname', 'local_metacleaner'));

    // Add a checkbox setting to enable/disable the plugin functionality.
    $settings->add(new admin_setting_configcheckbox(
        'local_metacleaner/enable',
        get_string('enable', 'local_metacleaner'),
        get_string('enable_help', 'local_metacleaner'),
        1
    ));

    // Add a setting to allow users to choose between deactivating or deleting meta enrolments.
    $settings->add(new admin_setting_configselect(
        'local_metacleaner/action',
        get_string('enrolaction', 'local_metacleaner'),
        get_string('enrolaction_help', 'local_metacleaner') . '<br>' . get_string('meta_enrolment_note', 'local_metacleaner'),
        1, // Default value: 1 = deactivate, 2 = delete.
        [
            1 => get_string('deactivate', 'local_metacleaner'), // Deactivate option.
            2 => get_string('delete', 'local_metacleaner'),     // Delete option.
        ]
    ));

    // Add a setting to filter by course category.
    $settings->add(new admin_setting_configselect(
        'local_metacleaner/category',
        get_string('filterbycategory', 'local_metacleaner'),
        get_string('filterbycategory_help', 'local_metacleaner'),
        0,
        [0 => get_string('allcategories', 'local_metacleaner')] + core_course_category::make_categories_list()
    ));

    // Add a setting to filter by maximum number of users.
    $settings->add(new admin_setting_configtext(
        'local_metacleaner/maxusers',
        get_string('maxusers', 'local_metacleaner'),
        get_string('maxusers_help', 'local_metacleaner'),
        100,
        PARAM_INT
    ));

    // Add a setting to filter by minimum days since course end.
    $settings->add(new admin_setting_configtext(
        'local_metacleaner/mindays',
        get_string('mindays', 'local_metacleaner'),
        get_string('mindays_help', 'local_metacleaner'),
        30,
        PARAM_INT
    ));

    // Register the settings page under 'localplugins'.
    $ADMIN->add('localplugins', $settings);

    // Add an external page for the preview functionality.
    $ADMIN->add('localplugins', new admin_externalpage(
        'local_metacleaner_preview',
        get_string('previewheading', 'local_metacleaner'),
        new moodle_url('/local/metacleaner/preview.php')
    ));
}
