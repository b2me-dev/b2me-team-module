<?php

	/* Module Name: B2Me Team Module */

	class B2Me_Team_Module {

		public function __construct() {
			add_action('init', array($this, 'register_team_post_type'));
			add_action('add_meta_boxes', array( $this, 'add_meta_box'));
			add_action('save_post', array( $this, 'save'));
			add_filter('manage_team_posts_columns', array( $this, 'add_team_columns'));
			add_action('manage_team_posts_custom_column', array( $this, 'display_custom_columns'), 10, 2);
			add_shortcode('b2-team', array($this, 'team'));
		}

		/* Register Team post type */
		public function register_team_post_type() {
			$labels = array(
				'name'                  => 'Team',
				'singular_name'         => 'Member',
				'menu_name'             => 'Team',
				'name_admin_bar'        => 'Member',
				'add_new'               => 'Add New',
				'add_new_item'          => 'Add New Member',
				'new_item'              => 'New Member',
				'edit_item'             => 'Edit Member',
				'view_item'             => 'View Member',
				'all_items'             => 'All Team',
				'search_items'          => 'Search Team',
				'parent_item_colon'     => 'Parent Team:',
				'not_found'             => 'No team found.',
				'not_found_in_trash'    => 'No team found in Trash.',
				'featured_image'        => 'Member Featured Image',
				'set_featured_image'    => 'Set featured image',
				'remove_featured_image' => 'Remove featured image',
				'use_featured_image'    => 'Use as featured image',
				'archives'              => 'Member archives',
				'insert_into_item'      => 'Insert into member',
				'uploaded_to_this_item' => 'Uploaded to this member',
				'filter_items_list'     => 'Filter team list',
				'items_list_navigation' => 'Team list navigation',
				'items_list'            => 'Team list',
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'team' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor', 'thumbnail' ),
				'menu_icon' 		 => 'dashicons-admin-users',
			);

			register_post_type( 'team', $args );
		}

		/* Add meta box for custom fields */
		public function add_meta_box( $post_type ) {
			$post_types = array( 'post', 'team' );
	
			if ( in_array( $post_type, $post_types ) ) {
				add_meta_box(
					'team_custom_metabox',
					'Custom Fields',
					array( $this, 'render_meta_box_content' ),
					$post_type,
					'advanced',
					'high'
				);
			}
		}

		/* Display custom fields */
		public function render_meta_box_content( $post ) {		
			wp_nonce_field( 'b2me_team_inner_custom_box', 'b2me_team_nonce' );
			
			$position = get_post_meta( $post->ID, 'position', true );

			$email = get_post_meta( $post->ID, 'email', true );
			$phone = get_post_meta( $post->ID, 'phone', true );

			$facebook = get_post_meta( $post->ID, 'facebook', true );
			$instagram = get_post_meta( $post->ID, 'instagram', true );
			$twitter = get_post_meta( $post->ID, 'twitter', true );
			$linkedin = get_post_meta( $post->ID, 'linkedin', true );
	
			?>
				<p><label for="position"><strong>Position</strong></label></p>
				<input type="text" id="position" name="position" value="<?php echo esc_attr( $position ); ?>" size="50" />

				<br/><br/><hr>

				<h3>Contact Details</h3>

				<p><label for="email"><strong>Email Address</strong></label></p>
				<input type="text" id="email" name="email" value="<?php echo esc_attr( $email ); ?>" size="50" />

				<br/><br/><hr>

				<p><label for="phone"><strong>Phone Number</strong></label></p>
				<input type="text" id="phone" name="phone" value="<?php echo esc_attr( $phone ); ?>" size="50" />

				<br/><br/><hr>

				<h3>Social Media Links</h3>

				<p><label for="facebook"><strong>Facebook</strong></label></p>
				<input type="text" id="facebook" name="facebook" value="<?php echo esc_attr( $facebook ); ?>" size="50" />

				<br/><br/><hr>

				<p><label for="instagram"><strong>Instagram</strong></label></p>
				<input type="text" id="instagram" name="instagram" value="<?php echo esc_attr( $instagram ); ?>" size="50" />

				<br/><br/><hr>

				<p><label for="twitter"><strong>Twitter</strong></label></p>
				<input type="text" id="twitter" name="twitter" value="<?php echo esc_attr( $twitter ); ?>" size="50" />

				<br/><br/><hr>

				<p><label for="linkedin"><strong>LinkedIn</strong></label></p>
				<input type="text" id="linkedin" name="linkedin" value="<?php echo esc_attr( $linkedin ); ?>" size="50" />

				<br/><br/><hr>

			<?php
		}

		/* Save and update custom fields */
		public function save( $post_id ) {
			/* Check nonce */
			if ( ! isset( $_POST['b2me_team_nonce'] ) ) {
				return $post_id;
			}

			$nonce = $_POST['b2me_team_nonce'];
			if ( ! wp_verify_nonce( $nonce, 'b2me_team_inner_custom_box' ) ) {
				return $post_id;
			}
	
			/* Do not autosave */
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}
	
			/* Check user privilege */
			if ( 'page' == $_POST['post_type'] ) {
				if ( ! current_user_can( 'edit_page', $post_id ) ) {
					return $post_id;
				}
			} else {
				if ( ! current_user_can( 'edit_post', $post_id ) ) {
					return $post_id;
				}
			}
	
			/* Update fields */
			$position = sanitize_text_field( $_POST['position'] );
			$email = sanitize_text_field( $_POST['email'] );
			$phone = sanitize_text_field( $_POST['phone'] );
			$facebook = sanitize_text_field( $_POST['facebook'] );
			$instagram = sanitize_text_field( $_POST['instagram'] );
			$twitter = sanitize_text_field( $_POST['twitter'] );
			$linkedin = sanitize_text_field( $_POST['linkedin'] );

			update_post_meta( $post_id, 'position', $position );
			update_post_meta( $post_id, 'email', $email );
			update_post_meta( $post_id, 'phone', $phone );
			update_post_meta( $post_id, 'facebook', $facebook );
			update_post_meta( $post_id, 'instagram', $instagram );
			update_post_meta( $post_id, 'twitter', $twitter );
			update_post_meta( $post_id, 'linkedin', $linkedin );
		}

		/* Display team columns */
		public function add_team_columns($columns) {
			return array_merge($columns, 
						array(
							'position' => 'Position',
							'email' => 'Email Address',
							'phone' => 'Phone Number',
						)
					);
		}

		function display_custom_columns($column, $post_id) {
			switch ($column) {
				case 'position':
					echo get_post_meta($post_id, 'position', true);
					break;
				case 'email':
					echo get_post_meta($post_id, 'email', true);
					break;
				case 'phone':
					echo get_post_meta($post_id, 'phone', true);
					break;
			}
		}

		/* Shortcode */
		public function team($attr) {
			
		}
	}

	new B2Me_Team_Module();