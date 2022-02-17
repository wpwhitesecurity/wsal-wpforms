<?php

$custom_alerts = array(
	__( 'WPForms', 'wsal-wpforms' ) => array(
		__( 'Form Content', 'wsal-wpforms' ) => array(

			array(
				5500,
				WSAL_LOW,
				__( 'A form was created, modified or deleted', 'wsal-wpforms' ),
				__( 'The Form called %PostTitle%.', 'wsal-wpforms' ),
				array(
					__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_forms',
				'created',
			),

			array(
				5501,
				WSAL_MEDIUM,
				__( 'A field was created, modified or deleted from a form.', 'wsal-wpforms' ),
				__( 'The Field called %1$field_name% in the form %2$form_name%.', 'wsal-wpforms' ),
				array(
					__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_fields',
				'deleted',
			),

			array(
				5502,
				WSAL_MEDIUM,
				__( 'A form was duplicated', 'wsal-wpforms' ),
				__( 'Duplicated the form %OldPostTitle%.', 'wsal-wpforms' ),
				array(
					__( 'Source form ID', 'wsal-wpforms' ) => '%SourceID%',
					__( 'New form ID', 'wsal-wpforms' )    => '%PostID%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkFormDuplicated%',
				),
				'wpforms_forms',
				'duplicated',
			),

			array(
				5503,
				WSAL_LOW,
				__( 'A notification was added to a form, enabled or modified', 'wsal-wpforms' ),
				__( 'The Notification called %notifiation_name% in the form %form_name%.', 'wsal-wpforms' ),
				array(
					__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_notifications',
				'added',
			),

			array(
				5504,
				WSAL_MEDIUM,
				__( 'An entry was deleted', 'wsal-wpforms' ),
				__( 'Deleted the Entry with the email address %entry_email%.', 'wsal-wpforms' ),
				array(
					__( 'Entry ID', 'wsal-wpforms' )  => '%entry_id%',
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_entries',
				'deleted',
			),

			array(
				5505,
				WSAL_LOW,
				__( 'Notifications were enabled or disabled in a form', 'wsal-wpforms' ),
				__( 'Changed the status of all the notifications in the form %form_name%.', 'wsal-wpforms' ),
				array(
					__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_notifications',
				'deleted',
			),

			array(
				5506,
				WSAL_LOW,
				__( 'A form was renamed', 'wsal-wpforms' ),
				__( 'Renamed the form %old_form_name% to %new_form_name%.', 'wsal-wpforms' ),
				array(
					__( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
				),
				array(
					__( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
				),
				'wpforms_forms',
				'renamed',
			),

			array(
				5507,
				WSAL_MEDIUM,
				__( 'An entry was modified', 'wsal-wpforms' ),
				__( 'Modified the Entry with ID %entry_id%.', 'wsal-wpforms' ),
				array(
					__( 'From form', 'wsal-wpforms' )      => '%form_name%',
					__( 'Modified field name', 'wsal-wpforms' ) => '%field_name%',
					__( 'Previous value', 'wsal-wpforms' ) => '%old_value%',
					__( 'New Value', 'wsal-wpforms' )      => '%new_value%',
				),
				array(
					__( 'View entry in the editor', 'wsal-wpforms' ) => '%EditorLinkEntry%',
				),
				'wpforms_entries',
				'modified',
			),

			array(
				5508,
				WSAL_HIGH,
				__( 'Plugin access settings were changed', 'wsal-wpforms' ),
				__( 'Changed the WPForms access setting %setting_name%.', 'wsal-wpforms' ),
				array(
					__( 'Type', 'wsal-wpforms' )           => '%setting_type%',
					__( 'Previous privileges', 'wsal-wpforms' ) => '%old_value%',
					__( 'New privileges', 'wsal-wpforms' ) => '%new_value%',
				),
				array(),
				'wpforms',
				'modified',
			),

			array(
				5509,
				WSAL_HIGH,
				__( 'Currency settings were changed', 'wsal-wpforms' ),
				__( 'Changed the <strong>currency</strong> to %new_value%.', 'wsal-wpforms' ),
				array(
					__( 'Previous currency', 'wsal-wpforms' ) => '%old_value%',
				),
				array(),
				'wpforms',
				'modified',
			),

			array(
				5510,
				WSAL_HIGH,
				__( 'A service integration was added or deleted', 'wsal-wpforms' ),
				__( 'A service integration with %service_name%.', 'wsal-wpforms' ),
				array(
					__( 'Connection name', 'wsal-wpforms' ) => '%connection_name%',
					__( 'Service', 'wsal-wpforms' ) => '%service_name%',
				),
				array(),
				'wpforms',
				'added',
			),

			array(
				5511,
				WSAL_HIGH,
				__( 'An addon was installed, activated or deactivated.', 'wsal-wpforms' ),
				__( 'The addon %addon_name%.', 'wsal-wpforms' ),
				array(),
				array(),
				'wpforms',
				'activated',
			),

			array(
				5513,
				WSAL_HIGH,
				__( 'Changed the status of the setting Enable anti-spam protection', 'wsal-wpforms' ),
				__( 'Changed the status of the setting <strong>Enable anti-spam protection.</strong>', 'wsal-wpforms' ),
				array(
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_forms',
				'enabled',
			),

			array(
				5514,
				WSAL_MEDIUM,
				__( 'Changed the status of the setting Enable dynamic fields population', 'wsal-wpforms' ),
				__( 'Changed the status of the setting <strong>Enable dynamic fields population.</strong>', 'wsal-wpforms' ),
				array(
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_forms',
				'enabled',
			),

			array(
				5515,
				WSAL_MEDIUM,
				__( 'Changed the status of the setting Enable AJAX form submission.', 'wsal-wpforms' ),
				__( 'Changed the status of the setting <strong>Enable AJAX form submission.</strong>', 'wsal-wpforms' ),
				array(
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_forms',
				'enabled',
			),

			array(
				5516,
				WSAL_MEDIUM,
				__( 'A notification name was renamed', 'wsal-wpforms' ),
				__( 'Renamed the notification %old_name% to %new_name%.', 'wsal-wpforms' ),
				array(
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_notifications',
				'renamed',
			),

			array(
				5517,
				WSAL_MEDIUM,
				__( 'A notifications metadata was modified', 'wsal-wpforms' ),
				__( 'Changed the %metadata_name% to %new_value% in %notification_name%.', 'wsal-wpforms' ),
				array(
					__( 'Previous value', 'wsal-wpforms' ) => '%old_value%',
					__( 'Form name', 'wsal-wpforms' )      => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )        => '%form_id%',
				),
				array(),
				'wpforms_notifications',
				'modified',
			),

			array(
				5518,
				WSAL_MEDIUM,
				__( 'A confirmation was added / removed', 'wsal-wpforms' ),
				__( 'The confirmation %confirmation_name%.', 'wsal-wpforms' ),
				array(
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'added',
			),

			array(
				5519,
				WSAL_MEDIUM,
				__( 'A Confirmation Type type was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Type</strong> of the confirmation %confirmation_name%.', 'wsal-wpforms' ),
				array(
					__( 'New Confirmation Type', 'wsal-wpforms' ) => '%new_value%',
					__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%%',
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),

			array(
				5520,
				WSAL_MEDIUM,
				__( 'A Confirmation Page type was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Page</strong> to %new_value%', 'wsal-wpforms' ),
				array(
					__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%%',
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),

			array(
				5521,
				WSAL_MEDIUM,
				__( 'A Confirmation Redirecttype was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Redirect URL</strong> to %new_value%', 'wsal-wpforms' ),
				array(
					__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%%',
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),

			array(
				5522,
				WSAL_MEDIUM,
				__( 'A Confirmation Message type was modified', 'wsal-wpforms' ),
				__( 'Changed the <strong>Confirmation Message</strong> to %new_value%', 'wsal-wpforms' ),
				array(
					__( 'Previous Confirmation Type', 'wsal-wpforms' ) => '%old_value%',
					__( 'Form name', 'wsal-wpforms' ) => '%form_name%',
					__( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
				),
				array(),
				'wpforms_confirmations',
				'modified',
			),
		),
	),
);
