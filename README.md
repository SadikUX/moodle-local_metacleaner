# MetaCleaner - Moodle Plugin

MetaCleaner is a Moodle plugin designed to manage and clean up **Meta Link enrollments** for courses whose end date has passed. It allows administrators to disable, delete, or automatically reactivate Meta Link enrollments and associated users based on configurable settings.

## Features

- **Disable Meta Link Enrollments**: Disables Meta Link enrollments for expired courses without deleting them.
- **Delete Meta Link Enrollments and Associated Users**: Deletes Meta Link enrollments for expired courses and removes all associated users.
- **Reactivate Meta Link Enrollments**: Automatically reactivates disabled Meta Link enrollments if the main course's end date is removed or extended.
- **Custom Configuration**: Administrators can choose whether to disable, delete, or reactivate Meta Link enrollments via plugin settings.
- **Scheduled Tasks**: The plugin automatically runs scheduled tasks to manage Meta Link enrollments for expired courses.

## Installation

1. Upload the plugin to the `local/metacleaner` folder in your Moodle installation.
2. Go to the [Moodle Admin Panel](http://yourmoodlesite/admin) and run the database update for the plugin.
3. Navigate to **Site Administration > Plugins > Local Plugins > MetaCleaner** and configure the settings.

## Configuration

After installation, you can configure the plugin settings in Moodle's admin interface:

1. **Enable Plugin Functionality**: You can enable or disable the plugin by checking the "Enable MetaCleaner functionality" checkbox.
2. **Action for Meta Link Enrollments**: Choose whether Meta Link enrollments should be disabled, deleted, or reactivated when the course's end date has passed.

## Usage

The plugin runs scheduled tasks that automatically manage Meta Link enrollments for expired courses. You can control the execution of these tasks via Moodle's cron jobs or manually via the admin interface.

## Language Files

The plugin currently supports English. Support for additional languages, including German, is planned for future updates. All messages are pulled from the language file configured for your Moodle installation.

## Developer

**Sadik Mert** - Developer and maintainer of the plugin.  
Email: [sadikmert@hotmail.de](mailto:sadikmert@hotmail.de)  
GitHub: [https://github.com/SadikUX](https://github.com/SadikUX)

## License

MetaCleaner is an open-source plugin released under the [GNU General Public License v3](https://www.gnu.org/licenses/gpl-3.0.html).

## Contributing

Contributions are welcome! Fork the repository, create a branch, and submit a pull request. Please make sure to test your changes thoroughly and include relevant tests.

## Changelog

### Version 1.0.0 (2025-03-14)
- Initial release of the plugin.
- Added functionality to disable, delete, or reactivate Meta Link enrollments.
