<?php

$custom_alerts = array(
	__( 'WPForms', 'wp-security-audit-log' ) => array(
		__( 'Form Content', 'wp-security-audit-log' ) => array(

			array(
				5500,
				WSAL_LOW,
				__( 'A form was created, modified or deleted', 'wp-security-audit-log' ),
				__( 'Form name %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'created',
			),

			array(
				5501,
				WSAL_MEDIUM,
				__( 'A field was created, deleted or modified', 'wp-security-audit-log' ),
				__( 'Field name %field_name% %LineBreak% Form name %form_name% %LineBreak% Form ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms_fields',
				'deleted',
			),

			array(
				5502,
				WSAL_MEDIUM,
				__( 'A form was duplicated', 'wp-security-audit-log' ),
				__( 'Source form %OldPostTitle% %LineBreak% New form name %PostTitle% %LineBreak% Source form ID %SourceID% %LineBreak% New form ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'duplicated',
			),

			array(
				5503,
				WSAL_LOW,
				__( 'A notification was added to a form, enabled or modified', 'wp-security-audit-log' ),
				__( 'Notification name %notifiation_name% %LineBreak% Form name %form_name% %LineBreak% Form ID %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms_notifications',
				'added',
			),

			array(
				5504,
				WSAL_MEDIUM,
				__( 'An entry was deleted', 'wp-security-audit-log' ),
				__( 'Entry email address: %entry_email% %LineBreak% Entry ID: %entry_id% %LineBreak% Form name: %form_name% %LineBreak% Form ID: %form_id% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms_entries',
				'deleted',
			),

			array(
				5505,
				WSAL_LOW,
				__( 'Notifications were enabled or disabled in a form', 'wp-security-audit-log' ),
				__( 'All the notifications in the form. %LineBreak% Form name %form_name% %LineBreak% Form ID %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms_notifications',
				'deleted',
			),

			array(
				5506,
				WSAL_LOW,
				__( 'A form was renamed', 'wp-security-audit-log' ),
				__( 'New form name %new_form_name% %LineBreak% Old form name %old_form_name% %LineBreak% Form ID %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'renamed',
			),

			array(
				5507,
				WSAL_LOW,
				__( 'An entry was modified', 'wp-security-audit-log' ),
				__( 'Entry ID: %entry_id% %LineBreak% From form: %form_name% %LineBreak% Modified field name: %field_name% %LineBreak% Old value: %old_value% %LineBreak% New Value: %new_value% %LineBreak% %EditorLinkEntry%', 'wp-security-audit-log' ),
				'wpforms_entries',
				'modified',
			),

			array(
				5508,
				WSAL_LOW,
				__( 'Plugin access settings were changed', 'wp-security-audit-log' ),
				__( 'Access setting: %setting_name% %LineBreak% Type: %setting_type% %LineBreak% Old privileges: %old_value% %LineBreak% New privileges: %new_value%', 'wp-security-audit-log' ),
				'wpforms',
				'modified',
			),

		),
	),
);
