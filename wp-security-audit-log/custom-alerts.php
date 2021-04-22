<?php

$custom_alerts = [
    __( 'WPForms', 'wsal-wpforms' ) => [
        __( 'Form Content', 'wsal-wpforms' ) => [

            [
                5500,
                WSAL_LOW,
                __( 'A form was created, modified or deleted', 'wsal-wpforms' ),
                __( 'The Form called %PostTitle%.', 'wsal-wpforms' ),
                [
                    __( 'Form ID', 'wsal-wpforms' )   => '%PostID%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
                ],
                'wpforms_forms',
                'created',
            ],

            [
                5501,
                WSAL_MEDIUM,
                __( 'A field was created, modified or deleted from a form.', 'wsal-wpforms' ),
                __( 'The Field called %field_name% in the form %form_name%.', 'wsal-wpforms' ),
                [
                    __( 'Form ID', 'wsal-wpforms' )    => '%PostID%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
                ],
                'wpforms_fields',
                'deleted',
            ],

            [
                5502,
                WSAL_MEDIUM,
                __( 'A form was duplicated', 'wsal-wpforms' ),
                __( 'Duplicated the form %OldPostTitle%.', 'wsal-wpforms' ),
                [
                    __( 'Source form ID', 'wsal-wpforms' ) => '%SourceID%',
                    __( 'New form ID', 'wsal-wpforms' )    => '%PostID%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkFormDuplicated%',
                ],
                'wpforms_forms',
                'duplicated',
            ],

            [
                5503,
                WSAL_LOW,
                __( 'A notification was added to a form, enabled or modified', 'wsal-wpforms' ),
                __( 'The Notification called %notifiation_name% in the form %form_name%.', 'wsal-wpforms' ),
                [
                    __( 'Form ID', 'wsal-wpforms' )   => '%PostID%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
                ],
                'wpforms_notifications',
                'added',
            ],

            [
                5504,
                WSAL_MEDIUM,
                __( 'An entry was deleted', 'wsal-wpforms' ),
                __( 'Deleted the Entry with the email address %entry_email%.', 'wsal-wpforms' ),
                [
                    __( 'Entry ID', 'wsal-wpforms' )  => '%entry_id%',
                    __( 'Form name', 'wsal-wpforms' ) => '%form_name%',
                    __( 'Form ID', 'wsal-wpforms' )   => '%form_id%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
                ],
                'wpforms_entries',
                'deleted',
            ],

            [
                5505,
                WSAL_LOW,
                __( 'Notifications were enabled or disabled in a form', 'wsal-wpforms' ),
                __( 'Changed the status of all the notifications in the form %form_name%.', 'wsal-wpforms' ),
                [
                    __( 'Form ID', 'wsal-wpforms' ) => '%PostID%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
                ],
                'wpforms_notifications',
                'deleted',
            ],

            [
                5506,
                WSAL_LOW,
                __( 'A form was renamed', 'wsal-wpforms' ),
                __( 'Renamed the form %old_form_name% to %new_form_name%.', 'wsal-wpforms' ),
                [
                    __( 'Form ID', 'wsal-wpforms' )       => '%PostID%',
                ],
                [
                    __( 'View form in the editor', 'wsal-wpforms' ) => '%EditorLinkForm%',
                ],
                'wpforms_forms',
                'renamed',
            ],

            [
                5507,
                WSAL_MEDIUM,
                __( 'An entry was modified', 'wsal-wpforms' ),
                __( 'Modified the Entry with ID %entry_id%.', 'wsal-wpforms' ),
                [
                    __( 'From form', 'wsal-wpforms' )      => '%form_name%',
                    __( 'Modified field name', 'wsal-wpforms' ) => '%field_name%',
                    __( 'Previous value', 'wsal-wpforms' ) => '%old_value%',
                    __( 'New Value', 'wsal-wpforms' )      => '%new_value%',
                ],
                [
                    __( 'View entry in the editor', 'wsal-wpforms' ) => '%EditorLinkEntry%',
                ],
                'wpforms_entries',
                'modified',
            ],

            [
                5508,
                WSAL_HIGH,
                __( 'Plugin access settings were changed', 'wsal-wpforms' ),
                __( 'Changed the WPForms access setting %setting_name%.', 'wsal-wpforms' ),
                [
                    __( 'Type', 'wsal-wpforms' )           => '%setting_type%',
                    __( 'Previous privileges', 'wsal-wpforms' ) => '%old_value%',
                    __( 'New privileges', 'wsal-wpforms' ) => '%new_value%',
                ],
                [],
                'wpforms',
                'modified',
            ],

            [
                5509,
                WSAL_HIGH,
                __( 'Currency settings were changed', 'wsal-wpforms' ),
                __( 'Changed the <strong>currency</strong> to %new_value%.', 'wsal-wpforms' ),
                [
                    __( 'Previous currency', 'wsal-wpforms' ) => '%old_value%',
                ],
                [],
                'wpforms',
                'modified',
            ],

            [
                5510,
                WSAL_HIGH,
                __( 'A service integration was added or deleted', 'wsal-wpforms' ),
                __( 'A service integration with %service_name%.', 'wsal-wpforms' ),
                [
                    __( 'Connection name', 'wsal-wpforms' ) => '%connection_name%',
					__( 'Service', 'wsal-wpforms' ) => '%service_name%',
                ],
                [],
                'wpforms',
                'added',
            ],

            [
                5511,
                WSAL_HIGH,
                __( 'An addon was installed, activated or deactivated.', 'wsal-wpforms' ),
                __( 'The addon %addon_name%.', 'wsal-wpforms' ),
                [],
                [],
                'wpforms',
                'activated',
            ],
        ],
    ],
];
