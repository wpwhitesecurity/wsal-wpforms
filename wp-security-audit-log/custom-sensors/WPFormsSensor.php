<?php
/**
 * Custom Sensors for WPForms
 *
 * Class file for alert manager.
 *
 * @since   1.0.0
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
	 * Form renamed event.
	 *
	 * Detect when forms title has been changed.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $post_id - Post ID.
	 * @param object $post    - Post data.
	 * @param bool   $update  - Whether this is an existing post being updated or not.
	 */
	public function event_form_renamed_duplicated_and_notifications( $post_id, $post, $update ) {
		$post_id = absint( $post_id ); // Making sure that the post id is integer.
		$form    = get_post( $post_id );

		// Handling form creation. First lets check an old post was set and its not flagged as an update, then finally check its not a duplicate.
		if ( ! isset( $this->_old_post->post_title ) && ! $update && ! preg_match( '/\s\(ID #[0-9].*?\)/', $form->post_title ) && 'wpforms' === $post->post_type ) {
			$alert_code  = 5500;
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
				'PostTitle'      => sanitize_text_field( $post->post_title ),
				'PostID'         => $post_id,
				'EditorLinkForm' => $editor_link,
			);

			$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'check_if_duplicate' ) );
		}

		// Handling form rename. Check if this is a form and if an old title is set.
		if ( isset( $this->_old_post->post_title ) && $this->_old_post->post_title !== $post->post_title && 'wpforms' === $post->post_type && $update ) {

			// Checking to ensure this is not a draft or fresh form.
			if ( isset( $post->post_status ) && 'auto-draft' !== $post->post_status ) {
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
					'EditorLinkForm' => $editor_link,
				);

				$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'must_not_new_form' ) );
			}
		}

		// Handling duplicated forms by checking to see if the post has ID # in the title.
		if ( preg_match( '/\s\(ID #[0-9].*?\)/', $form->post_title ) && 'wpforms' === $form->post_type ) {
			$post_created    = new DateTime( $form->post_date_gmt );
			$post_modified   = new DateTime( $form->post_modified_gmt );
			$alert_code      = 5505;

			// Check if this is indeed a new form.
			if( $form->post_date_gmt === $form->post_modified_gmt ) {
				// Grab old form ID from its post content.
				$old_form_content = json_decode($this->_old_post->post_content);
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
					'SourceID'       => sanitize_text_field( $old_form_content->id ),
					'PostID'         => $post_id,
					'EditorLinkForm' => $editor_link,
				);
				$this->plugin->alerts->Trigger( $alert_code, $variables );
				remove_action( 'save_post', array( $this, 'event_form_renamed_duplicated_and_notifications' ), 10, 3 );
			}
		}

		// Handling form notifications.
		if ( 'wpforms' === $form->post_type && isset( $this->_old_post ) && $update ) {
			// Checking to ensure this is not a draft or fresh form.
			if ( isset( $post->post_status ) && 'auto-draft' !== $post->post_status ) {
				$form_content     = json_decode( $form->post_content );
				$old_form_content = json_decode( $this->_old_post->post_content );
				$post_created     = new DateTime( $post->post_date_gmt );
				$post_modified    = new DateTime( $post->post_modified_gmt );
				$editor_link      = esc_url(
					add_query_arg(
						array(
							'view'    => 'fields',
							'form_id' => $post_id,
						),
						admin_url( 'admin.php?page=wpforms-builder' )
					)
				);

				// Create 2 arrays from the notification object for comparison later.
				$form_content_array = json_decode(json_encode( $form_content->settings->notifications ), true);
				$old_form_content_array = json_decode(json_encode( $old_form_content->settings->notifications ), true);

				// Compare the 2 arrays and create array of added items.
				$compare_added_items = array_diff(
					array_map( 'serialize', $form_content_array ),
					array_map( 'serialize', $old_form_content_array )
				);
				$added_items = array_map( 'unserialize', $compare_added_items );

				// Compare the 2 arrays and create array of removed items.
				$compare_removed_items = array_diff(
					array_map( 'serialize', $old_form_content_array ),
					array_map( 'serialize', $form_content_array )
				);
				$removed_items = array_map( 'unserialize', $compare_removed_items );

				$compare_changed_items = array_diff_assoc(
					array_map( 'serialize', $old_form_content_array ),
					array_map( 'serialize', $form_content_array )
				);
				$changed_items = array_map( 'unserialize', $compare_removed_items );

				// Check new content size determine if something has been added.
				if( count( $form_content_array ) > count( $old_form_content_array ) ) {
					$alert_code = 5506;
					foreach ( $added_items as $notification ) {
						if ( isset( $notification['notification_name'] ) ) {
							$notification_name = $notification['notification_name'];
						} else {
							$notification_name = esc_html__( 'Default Notification', 'wp-security-audit-log' );
						}
						$editor_link = $this->GetEditorLink( $form );
						$variables = array(
							'notifiation_name' => sanitize_text_field( $notification_name ),
							'form_name'        => sanitize_text_field( $form->post_title ),
							'PostID'           => $post_id,
							$editor_link['name'] => $editor_link['value'],
						);
						$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'must_not_new_form' ) );
					}
				// Check new content size determine if something has been removed.
				} elseif ( count( $form_content_array ) < count( $old_form_content_array ) ) {
					$alert_code = 5506;
					foreach ( $removed_items as $notification ) {
						if ( isset( $notification['notification_name'] ) ) {
							$notification_name = $notification['notification_name'];
						} else {
							$notification_name = esc_html__( 'Default Notification', 'wp-security-audit-log' );
						}
						$variables = array(
							'EventType'        => 'deleted',
							'notifiation_name' => sanitize_text_field( $notification_name ),
							'form_name'        => sanitize_text_field( $form->post_title ),
							'PostID'           => $post_id,
							'EditorLinkForm'   => $editor_link,
						);
						$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'must_not_new_form' ) );
					}
					// Compare old post and new post to see if the notifications have been disabled.
					} elseif ( $old_form_content->settings->notification_enable && ! $form_content->settings->notification_enable ) {
						$alert_code = 5508;
						$variables = array(
							'EventType'      => 'disabled',
							'form_name'      => sanitize_text_field( $form_content->settings->form_title ),
							'PostID'         => $post_id,
							'EditorLinkForm' => $editor_link,
						);
						$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'must_not_new_form' ) );

					// Finally, as none of the above triggered anything, lets see if the notifications themselved have been modified.
					} elseif ( $changed_items ) {
						$alert_code = 5506;
						foreach ( $removed_items as $notification ) {
							if ( isset( $notification['notification_name'] ) ) {
								$notification_name = $notification['notification_name'];
							} else {
								$notification_name = esc_html__( 'Default Notification', 'wp-security-audit-log' );
							}
							$variables = array(
								'EventType'        => 'modified',
								'notifiation_name' => sanitize_text_field( $notification_name ),
								'form_name'        => sanitize_text_field( $form->post_title ),
								'PostID'           => $post_id,
								'EditorLinkForm'   => $editor_link,
							);
							$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'must_not_new_form' ) );
					}
				}
			}
		}

		// Handling fields
		if ( 'wpforms' === $form->post_type && isset( $this->_old_post ) && $update ) {
			// Checking to ensure this is not a draft or fresh form.
			if ( isset( $post->post_status ) && 'auto-draft' !== $post->post_status ) {
				$form_content     = json_decode( $form->post_content );
				$old_form_content = json_decode( $this->_old_post->post_content );
				$post_created     = new DateTime( $post->post_date_gmt );
				$post_modified    = new DateTime( $post->post_modified_gmt );
				$editor_link      = esc_url(
					add_query_arg(
						array(
							'view'    => 'fields',
							'form_id' => $post_id,
						),
						admin_url( 'admin.php?page=wpforms-builder' )
					)
				);

				// Create 2 arrays from the fields object for comparison later.
				$form_content_array = json_decode( json_encode( $form_content->fields ), true );
				$old_form_content_array = json_decode( json_encode( $old_form_content->fields ), true );

				// Compare the 2 arrays and create array of added items.
				$compare_added_items = array_diff(
					array_map( 'serialize', $form_content_array ),
					array_map( 'serialize', $old_form_content_array )
				);
				$added_items = array_map( 'unserialize', $compare_added_items );

				// Compare the 2 arrays and create array of removed items.
				$compare_removed_items = array_diff(
					array_map( 'serialize', $old_form_content_array ),
					array_map( 'serialize', $form_content_array )
				);
				$removed_items = array_map( 'unserialize', $compare_removed_items );

				$compare_changed_items = array_diff_assoc(
					array_map( 'serialize', $old_form_content_array ),
					array_map( 'serialize', $form_content_array )
				);
				$changed_items = array_map( 'unserialize', $compare_removed_items );

				// Check new content size determine if something has been added.
				if ( count( $form_content_array ) > count( $old_form_content_array ) ) {
					$alert_code = 5504;
					foreach ( $added_items as $fields ) {
						$variables = array(
							'EventType'      => 'created',
							'field_name'     => sanitize_text_field( $fields['label'] ),
							'form_name'      => sanitize_text_field( $form->post_title ),
							'PostID'         => $post_id,
							'EditorLinkForm' => $editor_link,
						);
						$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'check_if_renamed' ) );
					}
				// Check new content size determine if something has been removed.
				} elseif ( count( $form_content_array ) < count( $old_form_content_array ) ) {
					$alert_code = 5504;
					foreach ( $removed_items as $fields ) {
						$variables = array(
							'EventType'      => 'deleted',
							'field_name'     => sanitize_text_field( $fields['label'] ),
							'form_name'      => sanitize_text_field( $form->post_title ),
							'PostID'         => $post_id,
							'EditorLinkForm' => $editor_link,
						);
						$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'check_if_renamed' ) );
					}
				// Check content to see if anything has been modified.
				} elseif ( $changed_items ) {
					$alert_code = 5504;
					foreach ( $changed_items as $fields ) {
						$variables = array(
							'EventType'      => 'modified',
							'field_name'     => sanitize_text_field( $fields['label'] ),
							'form_name'      => sanitize_text_field( $form->post_title ),
							'PostID'         => $post_id,
							'EditorLinkForm' => $editor_link,
						);
					$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'check_if_renamed' ) );
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
	 * @param object $data    - Post data.
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

		// Check time and also if there is an actual change in the post content.
		if ( abs( $post_created->diff( $post_modified )->s ) <= 1 || $post->post_content === $this->_old_post->post_content ) {
			// post hasn't changed return without event trigger.
			return;
		}

		$variables = array(
			'PostTitle'      => sanitize_text_field( $post->post_title ),
			'PostID'         => $form_id,
			'EditorLinkForm' => $editor_link,
		);

		$this->plugin->alerts->TriggerIf( $alert_code, $variables, array( $this, 'check_if_renamed' ) );

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
		$alert_code = 5507;
		global $pagenow;

		// Check current admin page and also that the delete key is present.
		if ( 'admin.php' === $pagenow && ( isset( $_GET['page'] ) && 'wpforms-entries' === $_GET['page'] ) && isset( $_GET['form_id'] ) && ( isset( $_GET['deleted'] ) && true === $_GET['deleted'] ) ) {
			wp_verify_nonce( ( isset( $_REQUEST['_wpnonce'] ) ) ? sanitize_key( $_REQUEST['_wpnonce'] ) : '', 'bulk-entries-nonce' );
			$form_id   = absint( $_GET['form_id'] );
			$form      = get_post( $form_id );
			$variables = array(
				'form_name' => sanitize_text_field( $form->post_title ),
				'PostID'    => $form_id,
			);
			$this->plugin->alerts->Trigger( $alert_code, $variables );
		}
	}

	/**
	 * Method: This function make sures that alert 5500
	 * has not been triggered before triggering categories
	 * & tags events.
	 *
	 * @param  WSAL_AlertManager $manager - WSAL Alert Manager.
	 * @return bool
	 */
	public function must_not_new_form( WSAL_AlertManager $manager ) {
		if ( $manager->WillOrHasTriggered( 5500 ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Method: This function make sures that alert 5500
	 * has not been triggered before triggering categories
	 * & tags events.
	 *
	 * @param  WSAL_AlertManager $manager - WSAL Alert Manager.
	 * @return bool
	 */
	public function check_if_renamed( WSAL_AlertManager $manager ) {
		if ( $manager->WillOrHasTriggered( 5501 ) || $manager->WillOrHasTriggered( 5500 ) || $manager->WillOrHasTriggered( 5506 ) || $manager->WillOrHasTriggered( 5508 ) || $manager->WillOrHasTriggered( 5504 ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Method: This function make sures that alert 5500
	 * has not been triggered before triggering categories
	 * & tags events.
	 *
	 * @param  WSAL_AlertManager $manager - WSAL Alert Manager.
	 * @return bool
	 */
	public function check_if_duplicate( WSAL_AlertManager $manager ) {
		if ( $manager->WillOrHasTriggered( 5505 ) ) {
			return false;
		}
		return true;
	}
}
