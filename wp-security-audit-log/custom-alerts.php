<?php
/**
 * Our list of events.
 *
 * @package WSAL_GravityForms
 */

// phpcs:disable WordPress.WP.I18n.UnorderedPlaceholdersText 
// phpcs:disable WordPress.WP.I18n.MissingTranslatorsComment

$custom_alerts = array(
	esc_html__( 'WPForms', 'wsal-wpforms' ) => array(
		esc_html__( 'Form Content', 'wsal-wpforms' ) => array(

			array(
				5500,
				WSAL_LOW,
				esc_html__( 'A form was created, modified or deleted', 'wsal-wpforms' ),
				esc_html__( 'The Form called %PostTitle%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_forms',
				'created',
			),

			array(
				5501,
				WSAL_MEDIUM,
				esc_html__( 'A field was created, modified or deleted from a form.', 'wsal-wpforms' ),
				esc_html__( 'The Field called %field_name% in the form %form_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_fields',
				'deleted',
			),

			array(
				5502,
				WSAL_MEDIUM,
				esc_html__( 'A form was duplicated', 'wsal-wpforms' ),
				esc_html__( 'Duplicated the form %OldPostTitle%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Source form ID', 'wsal-wpforms' ) => '%SourceID%',
					esc_html__( 'New form ID', 'wsal-wpforms' )    => '%PostID%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkFormDuplicated%',
				),
				'wpforms_forms',
				'duplicated',
			),

			array(
				5503,
				WSAL_LOW,
				esc_html__( 'A notification was added to a form, enabled or modified', 'wsal-wpforms' ),
				esc_html__( 'The Notification called %notifiation_name% in the form %form_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_notifications',
				'added',
			),

			array(
				5504,
				WSAL_MEDIUM,
				esc_html__( 'An entry was deleted', 'wsal-wpforms' ),
				esc_html__( 'Deleted the Entry with the email address %entry_email%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Entry ID', 'wsal-wpforms' )  => '%entry_id%',
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_entries',
				'deleted',
			),

			array(
				5505,
				WSAL_LOW,
				esc_html__( 'Notifications were enabled or disabled in a form', 'wsal-wpforms' ),
				esc_html__( 'Changed the status of all the notifications in the form %form_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_notifications',
				'deleted',
			),

			array(
				5506,
				WSAL_LOW,
				esc_html__( 'A form was renamed', 'wsal-wpforms' ),
				esc_html__( 'Renamed the form %old_form_name% to %new_form_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					esc_html__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_forms',
				'renamed',
			),

			array(
				5507,
				WSAL_MEDIUM,
				esc_html__( 'An entry was modified', 'wsal-wpforms' ),
				esc_html__( 'Modified the Entry with ID %entry_id%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'From form', 'wsal-wpforms' )      => '%form_name%',
					esc_html__( 'Modified field name', 'wsal-wpforms' ) => '%field_name%',
					esc_html__( 'Previous value', 'wsal-wpforms' ) => '%old_value%',
					esc_html__( 'New Value', 'wsal-wpforms' )      => '%new_value%',
				),
				array(
					esc_html__( 'View entry in the editor', 'wsal-wpforms' ) => '%EditorLinkEntry%',
				),
				'wpforms_entries',
				'modified',
			),

			array(
				5523,
				WSAL_MEDIUM,
				esc_html__( 'An Entry was created', 'wsal-wpforms' ),
				esc_html__( 'An Entry was created with the ID %entry_id%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Entry email', 'wsal-wpforms' )  => '%entry_email%',
					esc_html__( 'From form', 'wsal-wpforms' )  => '%form_name%',
				),
				array(
					esc_html__( 'View entry in the editor', 'wsal-wpforms' ) => '%EditorLinkEntry%',
				),
				'wpforms_entries',
				'created',
			),

			array(
				5508,
				WSAL_HIGH,
				esc_html__( 'Plugin access settings were changed', 'wsal-wpforms' ),
				esc_html__( 'Changed the WPForms access setting %setting_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Type', 'wsal-wpforms' ) => '%setting_type%',
					esc_html__( 'Previous privileges', 'wsal-wpforms' ) => '%old_value%',
					esc_html__( 'New privileges', 'wsal-wpforms' ) => '%new_value%',
				),
				array(),
				'wpforms',
				'modified',
			),

			array(
				5509,
				WSAL_HIGH,
				esc_html__( 'Currency settings were changed', 'wsal-wpforms' ),
				__( 'Changed the <strong>currency</strong> to %new_value%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Previous currency', 'wsal-wpforms' ) => '%old_value%',
				),
				array(),
				'wpforms',
				'modified',
			),

			array(
				5510,
				WSAL_HIGH,
				esc_html__( 'A service integration was added or deleted', 'wsal-wpforms' ),
				esc_html__( 'A service integration with %service_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Connection name', 'wsal-wpforms' ) => '%connection_name%',
					esc_html__( 'Service', 'wsal-wpforms' ) => '%service_name%',
				),
				array(),
				'wpforms',
				'added',
			),

			array(
				5511,
				WSAL_HIGH,
				esc_html__( 'An addon was installed, activated or deactivated.', 'wsal-wpforms' ),
				esc_html__( 'The addon %addon_name%.', 'wsal-wpforms' ),
				array(),
				array(),
				'wpforms',
				'activated',
			),

			array(
				5513,
				WSAL_HIGH,
				esc_html__( 'Changed the status of the setting Enable anti-spam protection', 'wsal-wpforms' ),
				__( 'Changed the status of the setting <strong>Enable anti-spam protection.</strong>', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_forms',
				'enabled',
			),

			array(
				5514,
				WSAL_MEDIUM,
				esc_html__( 'Changed the status of the setting Enable dynamic fields population', 'wsal-wpforms' ),
				__( 'Changed the status of the setting <strong>Enable dynamic fields population.</strong>', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_forms',
				'enabled',
			),

			array(
				5515,
				WSAL_MEDIUM,
				esc_html__( 'Changed the status of the setting Enable AJAX form submission.', 'wsal-wpforms' ),
				__( 'Changed the status of the setting <strong>Enable AJAX form submission.</strong>', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_forms',
				'enabled',
			),

			array(
				5516,
				WSAL_MEDIUM,
				esc_html__( 'A notification name was renamed', 'wsal-wpforms' ),
				esc_html__( 'Renamed the notification %old_name% to %new_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_notifications',
				'renamed',
			),

			array(
				5517,
				WSAL_MEDIUM,
				esc_html__( 'A notifications metadata was modified', 'wsal-wpforms' ),
				esc_html__( 'Changed the %metadata_name% to %new_value% in %notification_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Previous value', 'wsal-wpforms' ) => '%old_value%',
					esc_html__( 'Form name', 'wsal-wpforms' )      => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )        => '%form_id%',
				),
				array(),
				'wpforms_notifications',
				'modified',
			),

			array(
				5518,
				WSAL_MEDIUM,
				esc_html__( 'A confirmation was added / removed', 'wsal-wpforms' ),
				esc_html__( 'The confirmation %confirmation_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'added',
			),

			array(
				5519,
				WSAL_MEDIUM,
				esc_html__( 'A Confirmation Type type was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Type</strong> of the confirmation %confirmation_name%.', 'wsal-wpforms' ),
				array(
					esc_html__( 'New Confirmation Type', 'wsal-wpforms' ) => '%new_value%',
					esc_html__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%%',
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),

			array(
				5520,
				WSAL_MEDIUM,
				esc_html__( 'A Confirmation Page type was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Page</strong> to %new_value%', 'wsal-wpforms' ),
				array(
					esc_html__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%%',
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),

			array(
				5521,
				WSAL_MEDIUM,
				esc_html__( 'A Confirmation Redirecttype was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Redirect URL</strong> to %new_value%', 'wsal-wpforms' ),
				array(
					esc_html__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%%',
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),

			array(
				5522,
				WSAL_MEDIUM,
				esc_html__( 'A Confirmation Message type was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Message</strong> to %new_value%', 'wsal-wpforms' ),
				array(
					esc_html__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%',
					esc_html__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					esc_html__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),
		),
	),
);
