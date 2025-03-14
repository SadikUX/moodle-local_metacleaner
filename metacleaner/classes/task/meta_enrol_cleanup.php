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
 * Scheduled task for cleaning up meta enrolments for expired courses.
 *
 * @package     local_metacleaner
 * @copyright   2025 Sadik Mert
 * @category    task
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_metacleaner\task;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/local/metacleaner/lib.php');

/**
 * Task to clean up meta enrolments for courses that have expired.
 *
 * @package     local_metacleaner
 * @category    task
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class meta_enrol_cleanup extends \core\task\scheduled_task {

    /**
     * Get the name of the scheduled task.
     *
     * @return string The name of the scheduled task.
     */
    public function get_name() {
        return get_string('metaenrolcleanup', 'local_metacleaner');
    }

    /**
     * Execute the task to clean up expired meta enrolments.
     *
     * This method calls the cron function to handle the clean-up process.
     */
    public function execute() {
        local_metacleaner_cron();
    }
}
