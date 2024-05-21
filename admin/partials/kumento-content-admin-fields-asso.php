<?php

/**
 * The kumento_asso Custom Meta Box class.
 *
 * This class is responsible for rendering a custom meta box in WordPress with user-defined fields/options.
 * It uses the WordPress add_meta_box() and update_post_meta() functions to render and save field values.
 *
 * @link              https://wpturbo.ai
 * @since             1.0.0
 * @package           WPTurbo
 * 
 */
class Kumento_Asso_Meta_Box {

	/**
	 * Array that defines display locations.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $display_locations The list of locations where this meta box should be displayed.
	 */
	private $display_locations = [
		'kumento_asso_post'
	];
	
	/**
	 * Variables array that defines fields/options for the meta box.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $fields The list of user defined fields/options.
	 */
	private $fields = [
		'kumento_content_country' => [
			'type' => 'select',
			'label' => 'Country',
			'default' => 'Danmark',
			'options' => [
				'Danmark',
			],
		],
        'kumento_content_address' => [
			'type' => 'text',
			'label' => 'Address',
			'default' => '',
		],
        'kumento_content_address_second' => [
			'type' => 'text',
			'label' => 'Address 2',
			'default' => '',
		],
		'kumento_content_zip' => [
			'type' => 'number',
			'label' => 'Zipcode',
			'default' => '',
		],
        'kumento_content_city' => [
			'type' => 'text',
			'label' => 'City',
			'default' => '',
		],
        'kumento_content_contact_name' => [
			'type' => 'text',
			'label' => 'Contact Name',
			'default' => '',
		],
        'kumento_content_contact_phoneno' => [
			'type' => 'number',
			'label' => 'Contact Phoneno',
			'default' => '',
		],
		'kumento_content_contact_email' => [
			'type' => 'email',
			'label' => 'Contact Email',
			'default' => '',
		],
		'kumento_content_homepage_link' => [
			'type' => 'url',
			'label' => 'Link to Homepage',
			'default' => '',
		],
		'kumento_content_youtube_link' => [
			'type' => 'url',
			'label' => 'Youtube Link',
			'default' => '',
		],
        'kumento_content_purpose' => [
			'type' => 'textarea',
			'label' => 'Purpose',
			'default' => '',
		],
        'kumento_content_cvr' => [
			'type' => 'number',
			'label' => 'CVR Number',
			'default' => '',
		],
	];
	
	/**
	 * WPTurbo_Custom_Meta_Box constructor.
	 *
	 * Adds actions to WordPress hooks "add_meta_boxes" and "save_post".
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'kumento_asso_register_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'kumento_asso_save_meta_box_fields' ] );
		add_action('rest_api_init', [ $this, 'kumento_register_asso_post_meta_fields' ] );
	}
	
	/**
	 * Adds meta boxes to appropriate WordPress screens.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function kumento_asso_register_meta_boxes() : void {
		foreach ( $this->display_locations as $location ) {
			add_meta_box(
				'kumento-content-asso-meta-box', /* The id of our meta box. */
				__( 'Fields', 'kumento_content' ), /* The title of our meta box. */
				[ $this, 'kumento_asso_render_meta_box_fields' ], /* The callback function that renders the metabox. */
				$location, /* The screen on which to show the box. */
				'normal', /* The placement of our meta box. */
				'high', /* The priority of our meta box. */
			);
		}
	}
	
	/**
	 * Renders the Meta Box and its fields.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param WP_Post $post The post object.
	 *
	 * @return void
	 */
	public function kumento_asso_render_meta_box_fields(WP_Post $post) : void {
		wp_nonce_field( 'kumento-content-asso-meta-box_data', 'kumento-content-asso-meta-box_nonce' );
		$html = '';
		foreach( $this->fields as $field_id => $field ){
			$meta_value = get_post_meta( $post->ID, $field_id, true );
			if ( empty( $meta_value ) && isset( $field['default'] ) ) {
				$meta_value = $field['default'];
			}
	
			$field_html = $this->kumento_asso_render_input_field( $field_id, $field, $meta_value );
			$label = "<label for='$field_id'>{$field['label']}</label>";
			$html .= $this->kumento_asso_format_field( $label, $field_html );
		}
		echo '<table class="form-table"><tbody>' . $html . '</tbody></table>';
	}
	
	/**
	 * Formats each field to table display.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $label The field label.
	 * @param string $field The field HTML code.
	 *
	 * @return string
	 */
	public function kumento_asso_format_field( string $label, string $field ): string {
		return '<tr class="form-field"><th>' . __( $label, 'kumento_content' ) . '</th><td>' . $field . '</td></tr>';
	}
	
	/**
	 * Renders each individual field HTML code.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $field_id The field ID.
	 * @param array $field The field configuration array.
	 * @param string $field_value The field value.
	 *
	 * @return string The HTML code.
	 */
	public function kumento_asso_render_input_field( string $field_id, array $field, string $field_value): string {
		switch( $field['type'] ){
			case 'select': {
				$field_html = '<select name="'.$field_id.'" id="'.$field_id.'">';
					foreach( $field['options'] as $key => $value ) {
						$key = !is_numeric( $key ) ? $key : $value;
						$selected = '';
						if( $field_value === $key ) {
							$selected = 'selected="selected"';
						}
						$field_html .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
					}
				$field_html .= '</select>';
				break;
			}
			case 'textarea': {
				$field_html = '<textarea name="' . $field_id . '" id="' . $field_id . '" rows="6">' . $field_value . '</textarea>';
				break;
			}
			default: {
				$field_html = "<input type='{$field['type']}' id='$field_id' name='$field_id' value='$field_value' />";
				break;
			}
		}
	
		return $field_html;
	}
	
	/**
	 * Called when this metabox is saved.
	 *
	 * Saves the new meta values of our metabox.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $post_id The post ID.
	 *
	 * @return int The post ID.
	 */
	public function kumento_asso_save_meta_box_fields( int $post_id ) {
		if ( ! isset( $_POST['kumento-content-asso-meta-box_nonce'] ) ) return;
	
		$nonce = $_POST['kumento-content-asso-meta-box_nonce'];
		if ( !wp_verify_nonce( $nonce, 'kumento-content-asso-meta-box_data' ) ) return;
	
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
		foreach ( $this->fields as $field_id => $field ) {
			if( isset( $_POST[$field_id] ) ){
				// Sanitize fields that need to be sanitized.
				switch( $field['type'] ) {
					case 'email': {
						$_POST[$field_id] = sanitize_email( $_POST[$field_id] );
						break;
					}
					case 'text': {
						$_POST[$field_id] = sanitize_text_field( $_POST[$field_id] );
						break;
					}
				}
				update_post_meta( $post_id, $field_id, $_POST[$field_id] );
			}
		}
	}
	
	public function kumento_register_asso_post_meta_fields() {

		foreach ( $this->display_locations as $location ) {
			register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_country', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_address', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_address_second', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_zip', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_city', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
			register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_contact_name', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_contact_phoneno', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
			register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_contact_email', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
			register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_homepage_link', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
			register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_youtube_link', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_purpose', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
            register_rest_field(
				$location, // Object post|term|comment etc.
				'kumento_content_cvr', // Name of field
				array(
					'get_callback'    => [ $this, 'kumento_get_all_post_meta' ],
					'update_callback'    => [ $this, 'kumento_update_post_meta' ],
					'schema'          => null, // Schema for the field
				)
			);
		}
		}
		
	
	/* Callback function */
	public function kumento_get_all_post_meta($object, $field_name, $request) {
		return get_post_meta($object['id'], $field_name, true);
	}
	
	public function kumento_update_post_meta($value, $object, $field_name) {
		return update_post_meta($object['id'], $field_name, $value);
	}
}

if ( class_exists( 'kumento_Asso_Meta_Box' ) ) {
	new kumento_Asso_Meta_Box();
}