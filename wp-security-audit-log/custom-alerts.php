<?php

$custom_alerts = array(
	__( 'WPForms', 'wp-security-audit-log' ) => array(
		__( 'Form Content', 'wp-security-audit-log' ) => array(

			array(
				5500,
				WSAL_LOW,
				__( 'A form created', 'wp-security-audit-log' ),
				__( 'Created the form %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'created',
			),

			array(
				5501,
				WSAL_LOW,
				__( 'A form was renamed', 'wp-security-audit-log' ),
				__( 'Form renamed %LineBreak% Old Name %OldPostTitle% %LineBreak% New Name %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'renamed',
			),

			array(
				5502,
				WSAL_MEDIUM,
				__( 'A form was modified', 'wp-security-audit-log' ),
				__( 'Form modified %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'modified',
			),

			array(
				5503,
				WSAL_MEDIUM,
				__( 'A form was deleted', 'wp-security-audit-log' ),
				__( 'Form Deleted %PostTitle% %LineBreak% ID: %PostID% %LineBreak%', 'wp-security-audit-log' ),
				'wpforms',
				'deleted',
			),

			array(
				5505,
				WSAL_MEDIUM,
				__( 'A form was duplicated', 'wp-security-audit-log' ),
				__( 'Form Duplicated. Source form %OldPostTitle% %LineBreak% New form name %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'duplicated',
			),

			array(
				5506,
				WSAL_LOW,
				__( 'A notification was added to a form', 'wp-security-audit-log' ),
				__( 'Notification name %notifiation_name% %LineBreak% Form name %form_name% %LineBreak% ID %PostID% %LineBreak% %EditorLinkForm%', 'wp-security-audit-log' ),
				'wpforms',
				'added',
			),

			array(
				5507,
				WSAL_MEDIUM,
				__( 'An entry was deleted', 'wp-security-audit-log' ),
				__( 'Form name %form_name% %LineBreak% Form ID %PostID%', 'wp-security-audit-log' ),
				'wpforms',
				'deleted',
			),

		),
	),
);
