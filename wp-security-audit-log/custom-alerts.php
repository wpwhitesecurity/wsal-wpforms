<?php

$custom_alerts = array(
	__( 'WPForms', 'wp-security-audit-log' ) => array(
		__( 'Form Content', 'wp-security-audit-log' ) => array(

			array(
				5500,
				WSAL_LOW,
				__( 'A form was created, renamed, modified or deleted', 'wp-security-audit-log' ),
				__( 'Form name %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'created',
			),

			array(
				5501,
				WSAL_MEDIUM,
				__( 'A field was created, deleted or modified', 'wp-security-audit-log' ),
				__( 'Field name %field_name% %LineBreak% Form name %form_name% %LineBreak% Form ID: %PostID% %LineBreak%', 'wp-security-audit-log' ),
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
				__( 'Entry deleted %LineBreak% Form name %form_name% %LineBreak% Form ID %PostID%', 'wp-security-audit-log' ),
				'wpforms_entries',
				'deleted',
			),

			array(
				5505,
				WSAL_LOW,
				__( 'Notifications were disabled for a form', 'wp-security-audit-log' ),
				__( 'All the notifications in the form. %LineBreak% Form name %form_name% %LineBreak% ID %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms_notifications',
				'deleted',
			),

		),
	),
);
