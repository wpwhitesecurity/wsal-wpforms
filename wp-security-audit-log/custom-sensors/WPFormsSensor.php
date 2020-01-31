<?php
/**
 * Custom Sensors for WPForms
 *
 * Class file for alert manager.
 *
 * @since 1.0.0
 * @package Wsal
 */

/**
 * Custom sensor class to process WPForms events.
 *
 * @since 1.0.0
 */
class WSAL_Sensors_WPFormsSensor extends WSAL_AbstractSensor {

	/**
	 * Hook events related to sensor.
	 *
	 * @since 1.0.0
	 */
	public function HookEvents() {
		add_action( 'pre_post_update', array( $this, 'get_before_post_edit_data' ), 10, 2 );

		add_action( 'wpforms_create_form', array( $this, 'event_form_created' ), 10, 4 );
		add_action( 'save_post', array( $this, 'event_form_renamed_duplicated_and_notifications' ), 10, 3 );
		add_action( 'wpforms_builder_save_form', array( $this, 'event_form_modified' ), 10, 4 );
		add_action( 'delete_post', array( $this, 'event_form_deleted' ), 10, 1 );
		add_action( 'admin_init', array( $this, 'event_entry_deleted' ) );
	}

	/**
	 * Get Post Data.
	 *
	 * Collect old post data before post update event.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id - Post ID.
	 */
	public function get_before_post_edit_data( $post_id ) {
		$post_id = absint( $post_id ); // Making sure that the post id is integer.
		$post    = get_post( $post_id ); // Get post.

		// If post exists.
		if ( ! empty( $post ) && $post instanceof WP_Post ) {
			$this->_old_post = $post;
		}
	}

	/**
	 * Form created event.
	 *
	 * Detect when a new form is created.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $form_id - Post ID.
	 * @param array $data - Form data.
	 */
	public function event_form_created( $form_id, $data ) {
		$alert_code  = 5500;
		$form_id = absint( $form_id ); // Making sure that the post id is integer.
		$editor_link = esc_url(
			add_query_arg(
				array(
					'view'    => 'fields',
					'form_id' => $form_id,
				),
				admin_url( 'admin.php?page=wpforms-builder' )
			)
		);

		$variables = array(
			'PostTitle'      => sanitize_text_field( $data['post_title'] ),
			'PostID'         => $form_id,
			'EditorLinkPost' => $editor_link,
		);

		$this->plugin->alerts->Trigger( $alert_code, $variables );
	}

	/**
	 * Form renamed event.
	 *
	 * Detect when forms title has been changed.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $post_id - Post ID.
	 * @param object $post - Post data.
	 * @param bool   $update - Whether this is an existing post being updated or not.
	 */
	public function event_form_renamed_duplicated_and_notifications( $post_id, $post, $update ) {
		$post_id = absint( $post_id ); // Making sure that the post id is integer.
		$form    = get_post( $post_id );

		// Handling form rename. Check if this is a form and if an old title is set.
		if ( isset( $this->_old_post->post_title ) && $this->_old_post->post_title !== $post->post_title && 'wpforms' === $post->post_type ) {
			// Checking to ensure this is not a draft or fresh form.
			if (isset($post->post_status) && 'auto-draft' !== $post->post_status) {
				$alert_code    = 5501;
				$post          = get_post( $post_id );
				$post_created  = new DateTime( $post->post_date_gmt );
				$post_modified = new DateTime( $post->post_modified_gmt );
				$editor_link   = esc_url(
					add_query_arg(
						array(
							'view'    => 'fields',
							'form_id' => $post_id,
						),
						admin_url( 'admin.php?page=wpforms-builder' )
					)
				);

				$variables = array(
					'OldPostTitle'   => sanitize_text_field( $this->_old_post->post_title ),
					'PostTitle'      => sanitize_text_field( $post->post_title ),
					'PostID'         => $post_id,
					'EditorLinkPost' => $editor_link,
				);

				$this->plugin->alerts->Trigger( $alert_code, $variables );
				remove_action( 'save_post', array( $this, 'event_form_renamed' ), 10, 3 );
			}
		}

		// Handling duplicated forms by checking to see if the post has ID # in the title.
		if ( preg_match( '/\s\(ID #[0-9].*?\)/', $form->post_title ) && 'wpforms' === $form->post_type ) {
			$alert_code  = 5505;
			$editor_link = esc_url(
				add_query_arg(
					array(
						'view'    => 'fields',
						'form_id' => $post_id,
					),
					admin_url( 'admin.php?page=wpforms-builder' )
				)
			);

			$variables = array(
				'OldPostTitle'   => sanitize_text_field( $this->_old_post->post_title ),
				'PostTitle'      => sanitize_text_field( $form->post_title ),
				'PostID'         => $post_id,
				'EditorLinkPost' => $editor_link,
			);
			$this->plugin->alerts->Trigger( $alert_code, $variables );
			remove_action( 'save_post', array( $this, 'event_form_duplicated' ), 10, 3 );
		}

		// Handling form notifications.
		if ( 'wpforms' === $form->post_type ) {
			// Checking to ensure this is not a draft or fresh form.
			if (isset($post->post_status) && 'auto-draft' !== $post->post_status) {
				$alert_code   = 5506;
				$form_content = json_decode( $form->post_content );
				$editor_link  = esc_url(
					add_query_arg(
						array(
							'view'    => 'fields',
							'form_id' => $post_id,
						),
						admin_url( 'admin.php?page=wpforms-builder' )
					)
				);

				// Check if notifications are enabled for this form.
				if ( '1' === $form_content->settings->notification_enable ) {
					// Loop through any notifications and trigger alert.
					foreach ( $form_content->settings->notifications as $notification ) {
						// Check if a notification name is provided, and if not display the default name.
						if ( $notification->notification_name ) {
							$notification_name = $notification->notification_name;
						} else {
							$notification_name = __( 'Default Notification', 'wp-security-audit-log' );
						}
						$variables = array(
							'notifiation_name' => sanitize_text_field( $notification_name ),
							'form_name'        => sanitize_text_field( $form->post_title ),
							'PostID'           => $post_id,
							'EditorLinkPost'   => $editor_link,
						);
						$this->plugin->alerts->Trigger( $alert_code, $variables );
					}
				}
			}
		}
	}

	/**
	 * Form modified event.
	 *
	 * Detect when forms content has been changed.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $form_id - Post ID.
	 * @param object $data - Post data.
	 */
	public function event_form_modified( $form_id, $data ) {
		$alert_code    = 5502;
		$form_id       = absint( $form_id ); // Making sure that the post id is integer.
		$post          = get_post( $form_id );
		$post_created  = new DateTime( $post->post_date_gmt );
		$post_modified = new DateTime( $post->post_modified_gmt );
		$editor_link   = esc_url(
			add_query_arg(
				array(
					'view'    => 'fields',
					'form_id' => $form_id,
				),
				admin_url( 'admin.php?page=wpforms-builder' )
			)
		);

		if ( abs( $post_created->diff( $post_modified )->s ) <= 1 ) {

			return;

		} else {

			$variables = array(
				'PostTitle'      => sanitize_text_field( $post->post_title ),
				'PostID'         => $form_id,
				'EditorLinkPost' => $editor_link,
			);

			$this->plugin->alerts->Trigger( $alert_code, $variables );

		}
	}

	/**
	 * Form deleted event.
	 *
	 * Detect when a form has been fully deleted.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id - Post ID.
	 */
	public function event_form_deleted( $post_id ) {
		$alert_code = 5503;
		$post_id    = absint( $post_id );
		$post       = get_post( $post_id );
		if ( 'wpforms' === $post->post_type ) {
			$variables = array(
				'PostTitle' => $post->post_title,
				'PostID'    => $post_id,
			);

			$this->plugin->alerts->Trigger( $alert_code, $variables );
		}
	}

	/**
	 * Delete entry event.
	 *
	 * Detect when an entry has been deleted.
	 *
	 * @since 1.0.0
	 */
	public function event_entry_deleted() {
		$alert_code  = 5507;
		global $pagenow;

		// Check current admin page and also that the delete key is present.
		if ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'wpforms-entries' === $_GET['page'] && isset( $_GET['form_id'] ) && isset( $_GET['deleted'] ) ) {
			$form_id = absint( $_GET['form_id'] );
			$form = get_post( $form_id );
			wp_verify_nonce( ( isset( $_REQUEST['_wpnonce'] ) ) ? sanitize_key( $_REQUEST['_wpnonce'] ) : '', 'bulk-entries-nonce' );
			$variables = array(
				'form_name' => sanitize_text_field( $form->post_title ),
				'PostID'    => $form_id,
			);
			$this->plugin->alerts->Trigger( $alert_code, $variables );
		}
	}
}
