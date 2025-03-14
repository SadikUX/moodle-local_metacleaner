# MetaCleaner - Moodle Plugin

MetaCleaner is a Moodle plugin designed to manage and clean up meta-enrollments for courses whose end date has passed. It allows for either disabling or deleting meta-enrollments and associated users based on a user-defined setting.

## Features

- **Disable Meta-Enrollments**: Disables meta-enrollments for expired courses without deleting them.
- **Delete Meta-Enrollments and Associated Users**: Deletes meta-enrollments for expired courses and removes all associated users.
- **Custom Configuration**: Administrators can choose whether to disable or delete meta-enrollments via plugin settings.
- **Scheduled Tasks**: The plugin automatically runs scheduled tasks to clean up expired meta-enrollments.

## Installation

1. Upload the plugin to the `local/metacleaner` folder in your Moodle installation.
2. Go to the [Moodle Admin Panel](http://yourmoodlesite/admin) and run the database update for the plugin.
3. Navigate to **Site Administration > Plugins > Local Plugins > MetaCleaner** and configure the settings.

## Configuration

After installation, you can configure the plugin settings in Moodle's admin interface:

1. **Enable Plugin Functionality**: You can enable or disable the plugin by checking the "Enable MetaCleaner functionality" checkbox.
2. **Action for Expired Meta-Enrollments**: Choose whether meta-enrollments should be disabled or deleted when the course's end date has passed.

## Usage

The plugin runs scheduled tasks that automatically manage meta-enrollments for expired courses. You can control the execution of these tasks via Moodle's cron jobs or manually via the admin interface.

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
