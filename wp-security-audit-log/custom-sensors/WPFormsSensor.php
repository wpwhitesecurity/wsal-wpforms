<?php
/**
 * Custom Sensors for WPForms
 *
 * Class file for alert manager.
 *
 * @since 1.0.0
 * @package Wsal
 */
class WSAL_Sensors_WPFormsSensor extends WSAL_AbstractSensor {

	/**
	 * Hook events related to sensor.
	 */
	public function HookEvents() {
		add_action( 'pre_post_update', array( $this, 'get_before_post_edit_data' ), 10, 2 );

		add_action( 'wpforms_create_form', array( $this, 'event_form_created' ), 10, 4 );
		add_action( 'save_post', array( $this, 'event_form_renamed' ), 10, 3 );
		add_action( 'wpforms_builder_save_form', array( $this, 'event_form_modified' ), 10, 4 );
		add_action( 'delete_post', array( $this, 'event_form_deleted' ), 10, 1 );
		add_action( 'save_post', array( $this, 'event_form_duplicated' ), 10, 3 );
		add_action( 'save_post', array( $this, 'event_form_notification' ), 10, 3 );
	}

	/**
	 * Get Post Data.
	 *
	 * Collect old post data before post update event.
	 *
	 * @param int $post_id - Post ID.
	 */
	public function get_before_post_edit_data( $post_id ) {
		$post_id = (int) $post_id; // Making sure that the post id is integer.
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
	 * @param int   $form_id - Post ID.
	 * @param array $data - Form data.
	 */
	public function event_form_created( $form_id, $data ) {
		$alert_code  = 5500;
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
			'PostTitle'      => $data['post_title'],
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
	 * @param int    $post_id - Post ID.
	 * @param object $post - Post data.
	 * @param bool   $update - Whether this is an existing post being updated or not.
	 */
	public function event_form_renamed( $post_id, $post, $update ) {
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

		if ( isset( $this->_old_post->post_title ) && $this->_old_post->post_title !== $post->post_title ) {
			$variables = array(
				'OldPostTitle'   => $this->_old_post->post_title,
				'PostTitle'      => $post->post_title,
				'PostID'         => $post_id,
				'EditorLinkPost' => $editor_link,
			);

			$this->plugin->alerts->Trigger( $alert_code, $variables );
		} else {
			return;
		}
	}

	/**
	 * Form modified event.
	 *
	 * Detect when forms content has been changed.
	 *
	 * @param int    $form_id - Post ID.
	 * @param object $data - Post data.
	 */
	public function event_form_modified( $form_id, $data ) {
		$alert_code    = 5502;
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
				'PostTitle'      => $post->post_title,
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
	 * @param int $post_id - Post ID.
	 */
	public function event_form_deleted( $post_id ) {
		$alert_code = 5503;
		$post       = get_post( $post_id );

		$variables = array(
			'PostTitle' => $post->post_title,
			'PostID'    => $post_id,
		);

		$this->plugin->alerts->Trigger( $alert_code, $variables );
	}

	/**
	 * Form duplicated event.
	 *
	 * Detect when form has been cloned.
	 *
	 * @param int    $post_id - Post ID.
	 * @param object $post - Post data.
	 * @param bool   $update - Whether this is an existing post being updated or not.
	 */
	public function event_form_duplicated( $post_id, $post, $update ) {
		$alert_code  = 5505;
		$form        = get_post( $post_id );
		$editor_link = esc_url(
			add_query_arg(
				array(
					'view'    => 'fields',
					'form_id' => $post_id,
				),
				admin_url( 'admin.php?page=wpforms-builder' )
			)
		);

		if ( preg_match( '/\s\(ID #[0-9].*?\)/', $form->post_title ) ) {
			$variables = array(
				'OldPostTitle'   => $this->_old_post->post_title,
				'PostTitle'      => $form->post_title,
				'PostID'         => $post_id,
				'EditorLinkPost' => $editor_link,
			);
			$this->plugin->alerts->Trigger( $alert_code, $variables );
		} else {
			return;
		}

	}

	/**
	 * Form notification event.
	 *
	 * Detect when form has a notification enabled or disabled.
	 *
	 * @param int    $post_id - Post ID.
	 * @param object $post - Post data.
	 * @param bool   $update - Whether this is an existing post being updated or not.
	 */
	public function event_form_notification( $post_id, $post, $update ) {
		$alert_code   = 5506;
		$form         = get_post( $post_id );
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
					'notifiation_name' => $notification_name,
					'form_name'        => $form->post_title,
					'PostID'           => $post_id,
					'EditorLinkPost'   => $editor_link,
				);
				$this->plugin->alerts->Trigger( $alert_code, $variables );
			}
		}

	}
}
