<?php

$custom_alerts = array(
    __('WPForms', 'wp-security-audit-log') => array(
        __('Form Content', 'wp-security-audit-log') => array(

            array( 
                5500, 
                WSAL_LOW, 
                __('WPForms form created', 'wp-security-audit-log'), 
                __( 'Created the form %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkPost%', 'wp-security-audit-log' ), 
                'wpforms', 
                'created'
            ),

            array( 
                5501, 
                WSAL_LOW, 
                __('WPForms form renamed', 'wp-security-audit-log'), 
                __( 'Form renamed %LineBreak% Old Name %OldPostTitle% %LineBreak% New Name %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkPost%', 'wp-security-audit-log' ), 
                'wpforms', 
                'renamed'
            ),

            array(
                5502, 
                WSAL_MEDIUM,
                 __('WPForms form modified', 'wp-security-audit-log'), 
                __( 'Form modified %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkPost%', 'wp-security-audit-log' ), 
                'wpforms', 
                'modified'
            ),

            array(
                5503, 
                WSAL_MEDIUM,
                 __('WPForms form deleted', 'wp-security-audit-log'), 
                __( 'Form Deleted %PostTitle% %LineBreak% ID: %PostID% %LineBreak%', 'wp-security-audit-log' ), 
                'wpforms', 
                'deleted'
            ),

            array(
                5505, 
                WSAL_MEDIUM,
                 __('WPForms form duplicated', 'wp-security-audit-log'), 
                __( 'Form Duplicated. Source form %OldPostTitle% %LineBreak% New form name %PostTitle% %LineBreak% ID: %PostID% %LineBreak% %EditorLinkPost%', 'wp-security-audit-log' ), 
                'wpforms', 
                'duplicated'
            ),
            
        )
    )
);
