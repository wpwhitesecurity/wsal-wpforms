=== WP Activity Log for WPForms ===
Contributors: WPWhiteSecurity
Plugin URI: https://wpactivitylog.com
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.html
Tags: activity log for WPForms, WP Activity Log extension, activity logs
Requires at least: 5.0
Tested up to: 6.1.1
Stable tag: 1.2.3
Requires PHP: 7.2

Keep a log of changes that happen in the WPForms plugin, forms, entries (leads) & more.

== Description ==

Website forms allow your prospects to contact you, make a purchase, subscribe to a service, submit a support request, and do much more. Therefore it is vital to keep a log of the changes that you and your team do to website forms and the WPForms plugin. This eliminates guesswork when there are problems and you need to troubleshoot, and also improves user accountability.

Keep a record of the changes that happen on your WPForms plugin, when someone creates, modifies or deletes a form, deletes an entry and much more by installing this extension alongside the WP Activity Log plugin.

Refer to [activity log for WPForms](https://wpactivitylog.com/extensions/wpforms-activity-log/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) for more detailed information on this integration.

#### About WP Activity Log
[WP Activity Log](https://wpactivitylog.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) is the most comprehensive real time activity log plugin for WordPress. It helps thousands administrators and security professionals keep an eye on what is happening on their websites and multisite networks.

WP Activity Log is also the most highly rated WordPress activity log plugin and have been featured on popular sites such as GoDaddy, ManageWP, Pagely, Shout Me Loud and WPKube.

### Getting started: activity logs for WPForms

To keep a log of the changes that happen on your WPForms plugin, forms, entries and other plugin components simply:

1. Install the [WP Activity Log plugin](https://wpactivitylog.com/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description)
1. Install this extension from the section <i>Enable/disable events</i> > <i>Third party extensions</i>.

### With this extension you can keep a log of:

Below are some of the user and plugin changes you can keep a log of when you install this extension with the WP Activity Log plugin:

* Adds a new form
* Modifies, duplicates, renames or deletes a form
* Adds a new field in a form
* Modifies, or deletes a field from a form
* Deletes or modifies an entry (lead)
* Adds, enables, modifies or disable notifications in forms
* Changes in the access plugin's control settings

Refer to the [activity logs event IDs for WPForms](https://wpactivitylog.com/support/kb/list-wordpress-activity-log-event-ids/#wpforms?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description)) for a complete list of the changes the plugin can keep a log of.

== Installation ==

=== Install this extension for WPForms from within WP Activity Log (easiest method) ===

1. Navigate to the section <i>Enable/disable events</i> > <i>Third party extensions</i>.
1. Click <i>Install extension</i> under the WPForms logo and extension description.

=== Install this extension from within WordPress ===

1. Ensure WP Activity Log is already installed.
1. Visit 'Plugins > Add New'.
1. Search for 'WP Activity Log extension for WPForms'.
1. Install and activate the extension.

=== Install this extension manually ===

1. Ensure WP Activity Log is already installed.
1. Download the plugin and extract the files.
1. Upload the `wsal-wpforms` folder to the `/wp-content/plugins/` folder on your website.
1. Activate the WP Activity Log extension for WPForms plugin from the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Support and Documentation =
Please refer to our [Support & Documentation pages](https://wpactivitylog.com/support/kb/?utm_source=wordpress.org&utm_medium=referral&utm_campaign=WSAL&utm_content=plugin+repos+description) for all the technical information and support documentation on the WP Activity Log plugin.

== Screenshots ==

1. The easiest way to install the extension is from within the WP Activity Log plugin.
1. Forms, entries, notifications and other WPForms plugin changes reported in the WordPress activity log.

== Changelog ==

= 1.2.3 (2023-03-23) =

* **Plugin improvements**
	* Support for WP Activity Log 4.5 (upcoming update).

= 1.2.2 (2022-11-17) =

* **Improvements**
	* Updated plugin inline with recent [WP Activity Log](https://wpactivitylog.com) plugin changes.

* **Bug fixes**
	* Fixed PHP error when creating confirmations in forms.
	* Fixed PHP error reported in some cases when creating new forms.
  
= 1.2.1 (2022-06-14) =

* **Improvements**
	* Updated plugin inline with recent WP Activity Log Changes.
	* Improved coding standards.

= 1.2.0 (2022-03-24) =

Extensions: Release notes: [Yoast SEO, WPForms & Gravity Forms activity log extension updates](https://wpactivitylog.com/extensions-march-2022-update/)

* **New event IDs:**
	* 5513: Enabled / disabled anti-spam protection on a form.
	* 5514: Enabled / disabled dynamic fields population setting on a form.
	* 5515: Enabled / disabled dynamic fields population setting on a form.
	* 5516: Renamed a notification.
	* 5517: Changed a property of a notification.
	* 5518: Added / enabled / deleted a confirmation from a form.
	* 5519: Changed the confirmation type of a form confirmation.
	* 5520: Changed the confirmation page in a form confirmation.
	* 5521: Changed the redirect URL in a form confirmation.
	* 5522: Changed the message in a form confirmation.
	* 5523: User / website visitor submitted a form on the website.
	
* **Improvements:**
	* Updated code - now using the WordPress coding standard.
	* Refactored some of the code / reduced duplicate code for some of the event IDs.

= 1.1.2 (2021-09-01) =

Release notes: [Activity log extensions for Yoast SEO, WooCommerce & WPForms get a maintenance update](https://wpactivitylog.com/extensions-september-2021-update/)

* **Improvement**
	* Updated extension with latest core update (more efficient way of how sensors are loaded).
	
* **Bug fixes**
	* Fixed: Extension logs multiple non-relevant events in the log when a new form is created.
	* Fixed: "View form" link in event ID 5502 (when a form is duplicated) is malformed.
  
= 1.1.1 (2021-04-27) =

Release notes: [Major update of all the activity log extensions](https://wpactivitylog.com/core-update-extensions-2-0/)

* **Improvement**
	* Events now use the latest event format used in [WP Activity Log](https://wpactivitylog.com).
	* Updated the core to the latest improved core (better performance and more efficient).
	* Extension can now be activated only at network level.
	* Extension name added to plugin's admin notices.
	
* **Bug fixes**
	* Several errors reported upon deleting a form.
	* Fixed broken backward compatability issue.
	* Fixed broken backward compatability issue.

= 1.1 (2020-09-22) =

Release notes: [Logs for integration of third party services & more!](https://wpactivitylog.com/wpforms-1-1/)

* **New event IDs in activity log**
	* ID 5509: the currency configured in the plugin has changed.
	* ID 5510: a third party service was integrated / an integration was removed.
	* ID 5511: an addon was installed / activated / deactivated.
	
* **Improvements**
	* Updated core extension code to the most recent version.
	
= 1.0.3 (2020-06-30) =

Release notes: [Logs for changes in WPForms entries & access control settings](https://wpactivitylog.com/wpforms-1-0-3/)

* **New features**
	* Improved activity log coverage.
	* Logs for when user modifies an entry. Plugim also reports what was changed in the entry (Event ID: 5507).
	* Plugin keeps a log of access control settings changes (Event ID: 5508) in the activity log.
	
* **Bug fixes**
	* "Unknown object" reported in event ID 5501 instead of "Fields in WPForms"
	* "Unknown object" reported in event ID 5505 instead of "Notifications in WPForms"
	
= 1.0.2 (2020-05-20) =

* **Main plugin rename update**
	*[WP Security Audit Log has been renamed to WP Activity Log](https://wpactivitylog.com/wp-security-audit-log-renamed-wp-activity-log/).

= 1.0.1 (2020-03-06) =

* **New event ID**
	*Event ID 5504: user deleted a lead / entry (refer to the [complete list of activity log event IDs](https://wpactivitylog.com/support/kb/list-wordpress-activity-log-event-ids/#wpforms) for more info).

* **Improvements**
	* Plugin now keeps a log of multiple changes done together in one form save / change.
	* Plugin notifications only shown to super administrators on multisite network.
	* Extension specific [activity log objects](https://wpactivitylog.com/support/kb/objects-event-types-wordpress-activity-log/) can now be declared in the main plugin, WP Activity Log.

= 1.0.0 (2020-02-13) =

	*Initial release.
