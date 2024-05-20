<?php

/**
 * The WPTurbo Custom Meta Box class.
 *
 * This class is responsible for rendering a custom meta box in WordPress with user-defined fields/options.
 * It uses the WordPress add_meta_box() and update_post_meta() functions to render and save field values.
 *
 * @link              https://wpturbo.ai
 * @since             1.0.0
 * @package           WPTurbo
 * 
 */
class Kumento_News_Meta_Box {

	/**
	 * Array that defines display locations.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $display_locations The list of locations where this meta box should be displayed.
	 */
	private $display_locations = [
		'kumento_news_post',
		'kumento_press_post'
	];
	
	/**
	 * Variables array that defines fields/options for the meta box.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array $fields The list of user defined fields/options.
	 */
	private $fields = [
		'kumento-content-publicist' => [
			'type' => 'text',
			'label' => 'Publicist',
			'default' => '',
		],
		'kumento-content-country' => [
			'type' => 'select',
			'label' => 'Country',
			'default' => 'Danmark',
			'options' => [
				'Danmark',
			],
		],
		'kumento-content-contact-phoneno' => [
			'type' => 'number',
			'label' => 'Contact Phoneno',
			'default' => '',
		],
		'kumento-content-contact-email' => [
			'type' => 'email',
			'label' => 'Email',
			'default' => '',
		],
		'kumento-content-homepage-link' => [
			'type' => 'url',
			'label' => 'Link to Homepage',
			'default' => '',
		],
		'kumento-content-youtube-link' => [
			'type' => 'url',
			'label' => 'Youtube Link',
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
		add_action( 'add_meta_boxes', [ $this, 'wpturbo_register_meta_boxes' ] );
		add_action( 'save_post', [ $this, 'wpturbo_save_meta_box_fields' ] );
	}
	
	/**
	 * Adds meta boxes to appropriate WordPress screens.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return void
	 */
	public function wpturbo_register_meta_boxes() : void {
		foreach ( $this->display_locations as $location ) {
			add_meta_box(
				'kumento-content-news-meta-box', /* The id of our meta box. */
				__( 'Fields', 'kumento_content' ), /* The title of our meta box. */
				[ $this, 'wpturbo_render_meta_box_fields' ], /* The callback function that renders the metabox. */
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
	public function wpturbo_render_meta_box_fields(WP_Post $post) : void {
		wp_nonce_field( 'kumento-content-news-meta-box_data', 'kumento-content-news-meta-box_nonce' );
		$html = '';
		foreach( $this->fields as $field_id => $field ){
			$meta_value = get_post_meta( $post->ID, $field_id, true );
			if ( empty( $meta_value ) && isset( $field['default'] ) ) {
				$meta_value = $field['default'];
			}
	
			$field_html = $this->wpturbo_render_input_field( $field_id, $field, $meta_value );
			$label = "<label for='$field_id'>{$field['label']}</label>";
			$html .= $this->wpturbo_format_field( $label, $field_html );
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
	public function wpturbo_format_field( string $label, string $field ): string {
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
	public function wpturbo_render_input_field( string $field_id, array $field, string $field_value): string {
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
	public function wpturbo_save_meta_box_fields( int $post_id ) {
		if ( ! isset( $_POST['kumento-content-news-meta-box_nonce'] ) ) return;
	
		$nonce = $_POST['kumento-content-news-meta-box_nonce'];
		if ( !wp_verify_nonce( $nonce, 'kumento-content-news-meta-box_data' ) ) return;
	
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
	
}

if ( class_exists( 'Kumento_News_Meta_Box' ) ) {
	new Kumento_News_Meta_Box();
}