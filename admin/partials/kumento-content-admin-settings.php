<?php

/**
 * Class WP_Kumento_Content_Plugin_Settings
 *
 * Configure the plugin settings page.
 */
class WP_Kumento_Content_Plugin_Settings {

	/**
	 * Capability required by the user to access the My Plugin menu entry.
	 *
	 * @var string $capability
	 */
	private $capability = 'manage_options';

	/**
	 * Array of fields that should be displayed in the settings page.
	 *
	 * @var array $fields
	 */
	private $fields = [
		[
			'id' => 'kumento_news_show',
			'label' => 'Kumento News',
			'description' => '',
			'type' => 'checkbox',
		],
		[
			'id' => 'kumento_press_show',
			'label' => 'Kumento Press',
			'description' => '',
			'type' => 'checkbox',
		],
		[
			'id' => 'kumento_company_show',
			'label' => 'Kumento Company',
			'description' => '',
			'type' => 'checkbox',
		],
		[
			'id' => 'kumento_event_show',
			'label' => 'Kumento Event',
			'description' => '',
			'type' => 'checkbox',
		],
		[
			'id' => 'kumento_association_show',
			'label' => 'Kumento Association',
			'description' => '',
			'type' => 'checkbox',
		],
	];

	/**
	 * The Plugin Settings constructor.
	 */
	function __construct() {
		add_action( 'admin_init', [$this, 'settings_init'] );
		add_action( 'admin_menu', [$this, 'options_page'] );
		add_action( 'rest_api_init', [$this, 'register_rest_images'] );
	}

	/**
	 * Register the settings and all fields.
	 */
	function settings_init() : void {

		// Register a new setting this page.
		register_setting( 'kumento-content-plugin-settings', 'kumento_content_options' );


		// Register a new section.
		add_settings_section(
			'kumento-content-plugin-settings-section',
			__( 'Show Kumento Sections', 'kumento_content' ),
			[$this, 'render_section'],
			'kumento-content-plugin-settings'
		);


		/* Register All The Fields. */
		foreach( $this->fields as $field ) {
			// Register a new field in the main section.
			add_settings_field(
				$field['id'], /* ID for the field. Only used internally. To set the HTML ID attribute, use $args['label_for']. */
				__( $field['label'], 'kumento-content' ), /* Label for the field. */
				[$this, 'render_field'], /* The name of the callback function. */
				'kumento-content-plugin-settings', /* The menu page on which to display this field. */
				'kumento-content-plugin-settings-section', /* The section of the settings page in which to show the box. */
				[
					'label_for' => $field['id'], /* The ID of the field. */
					'class' => 'wporg_row', /* The class of the field. */
					'field' => $field, /* Custom data for the field. */
				]
			);
		}
	}

	/**
	 * Add a subpage to the WordPress Settings menu.
	 */
	function options_page() : void {
		add_submenu_page(
			'options-general.php', /* Parent Menu Slug */
			'Kumento Content Settings', /* Page Title */
			__( 'Kumento Content', 'kumento_content' ), /* Menu Title */
			$this->capability, /* Capability */
			'kumento-content-plugin-settings', /* Menu Slug */
			[$this, 'render_options_page'], /* Callback */
		);
	}

	/**
	 * Render the settings page.
	 */
	function render_options_page() : void {

		// check user capabilities
		if ( ! current_user_can( $this->capability ) ) {
			return;
		}

		$siteURL = get_site_url();
		$kumentoOptions = get_option('kumento_content_options');

		// add error/update messages

		// check if the user have submitted the settings
		// WordPress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
			// add settings saved message with the class of "updated"
			add_settings_error( 'wporg_messages', 'wporg_message', __( 'Settings Saved', 'kumento-content' ), 'updated' );
		}

		// show error/update messages
		settings_errors( 'wporg_messages' );
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<h2 class="description"></h2>
			<form action="options.php" method="post">
				<?php
				/* output security fields for the registered setting "wporg" */
				settings_fields( 'kumento-content-plugin-settings' );
				/* output setting sections and their fields */
				/* (sections are registered for "wporg", each field is registered to a specific section) */
				do_settings_sections( 'kumento-content-plugin-settings' );
				/* output save settings button */
				submit_button( __( 'Save Settings', 'kumento-content') );
				?>
			</form>
		</div>
		<div class="wrap">
			<h2><?php echo esc_html( __( 'Endpoints', 'kumento-content' ) ); ?></h2>
			<?php 
			if($kumentoOptions['kumento_news_show']){
				echo '<h3>'.esc_html( __( 'Kumento News', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_news_post</code></pre>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_news_category</code></pre>';
			}

			if($kumentoOptions['kumento_press_show']){
				echo '<h3>'.esc_html( __( 'Kumento Press', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_press_post</code></pre>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_press_category</code></pre>';
			}

			if($kumentoOptions['kumento_company_show']){
				echo '<h3>'.esc_html( __( 'Kumento Company', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_company_post</code></pre>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_company_category</code></pre>';
			}

			if($kumentoOptions['kumento_event_show']){
				echo '<h3>'.esc_html( __( 'Kumento Event', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_event_post</code></pre>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_event_category</code></pre>';
			}

			if($kumentoOptions['kumento_association_show']){
				echo '<h3>'.esc_html( __( 'Kumento Association', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_asso_post</code></pre>';
				echo '<pre><code>'.$siteURL.'/wp-json/wp/v2/kumento_asso_category</code></pre>';
			}
			?>
		</div>
		<div class="wrap">
			<h2><?php echo esc_html( __( 'Shortcodes', 'kumento-content' ) ); ?></h2>
			<ul>
				<li><?php echo esc_html( __( 'sourceUrl: Site to pull the endpoint from. Required.', 'kumento-content' ) ); ?></li>
				<li><?php echo esc_html( __( 'type: The post-type used in the endpoint. Required', 'kumento-content' ) ); ?></li>
				<li><?php echo esc_html( __( 'layout: Display layouts. Optional.', 'kumento-content' ) ); ?></li>
				<li><?php echo esc_html( __( 'showSidebar: Kategory filter sidebar. Optional.', 'kumento-content' ) ); ?></li>
				<li><?php echo esc_html( __( 'category: Category number, used to filter posts by a category. Optional.', 'kumento-content' ) ); ?></li>
			</ul>
			<?php 
			if($kumentoOptions['kumento_news_show']){
				echo '<h3>'.esc_html( __( 'Kumento News', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>[kumento_post sourceUrl="'.$siteURL.'" type="kumento_news_post" layout="" showSidebar="false" category=""]</code></pre>';
			}

			if($kumentoOptions['kumento_press_show']){
				echo '<h3>'.esc_html( __( 'Kumento Press', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>[kumento_post sourceUrl="'.$siteURL.'" type="kumento_press_post" layout="" showSidebar="false" category=""]</code></pre>';
			}

			if($kumentoOptions['kumento_company_show']){
				echo '<h3>'.esc_html( __( 'Kumento Company', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>[kumento_post sourceUrl="'.$siteURL.'" type="kumento_company_post" layout="" showSidebar="false" category=""]</code></pre>';
			}

			if($kumentoOptions['kumento_event_show']){
				echo '<h3>'.esc_html( __( 'Kumento Event', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>[kumento_post sourceUrl="'.$siteURL.'" type="kumento_event_post" layout="" showSidebar="false" category=""]</code></pre>';
			}

			if($kumentoOptions['kumento_association_show']){
				echo '<h3>'.esc_html( __( 'Kumento Association', 'kumento-content' ) ).'</h3>';
				echo '<pre><code>[kumento_post sourceUrl="'.$siteURL.'" type="kumento_asso_post" layout="" showSidebar="false" category=""]</code></pre>';
			}
			?>
		</div>
		<?php
	}

	/**
	 * Render a settings field.
	 *
	 * @param array $args Args to configure the field.
	 */
	function render_field( array $args ) : void {

		$field = $args['field'];

		// Get the value of the setting we've registered with register_setting()
		$options = get_option( 'kumento_content_options' );

		switch ( $field['type'] ) {

			case "text": {
				?>
				<input
					type="text"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "checkbox": {
				?>
				<input
					type="checkbox"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="1"
					<?php echo isset( $options[ $field['id'] ] ) ? ( checked( $options[ $field['id'] ], 1, false ) ) : ( '' ); ?>
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "textarea": {
				?>
				<textarea
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
				><?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?></textarea>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "select": {
				?>
				<select
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
				>
					<?php foreach( $field['options'] as $key => $option ) { ?>
						<option value="<?php echo $key; ?>" 
							<?php echo isset( $options[ $field['id'] ] ) ? ( selected( $options[ $field['id'] ], $key, false ) ) : ( '' ); ?>
						>
							<?php echo $option; ?>
						</option>
					<?php } ?>
				</select>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "password": {
				?>
				<input
					type="password"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "wysiwyg": {
				wp_editor(
					isset( $options[ $field['id'] ] ) ? $options[ $field['id'] ] : '',
					$field['id'],
					array(
						'textarea_name' => 'kumento_content_options[' . $field['id'] . ']',
						'textarea_rows' => 5,
					)
				);
				break;
			}

			case "email": {
				?>
				<input
					type="email"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "url": {
				?>
				<input
					type="url"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "color": {
				?>
				<input
					type="color"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

			case "date": {
				?>
				<input
					type="date"
					id="<?php echo esc_attr( $field['id'] ); ?>"
					name="kumento_content_options[<?php echo esc_attr( $field['id'] ); ?>]"
					value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>"
				>
				<p class="description">
					<?php esc_html_e( $field['description'], 'kumento-content' ); ?>
				</p>
				<?php
				break;
			}

		}
	}


	/**
	 * Render a section on a page, with an ID and a text label.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args {
	 *     An array of parameters for the section.
	 *
	 *     @type string $id The ID of the section.
	 * }
	 */
	function render_section( array $args ) : void {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', 'kumento-content' ); ?></p>
		<?php
	}

	public function register_rest_images(){
		register_rest_field( array('post','kumento_news_post','kumento_press_post','kumento_company_post','kumento_event_post','kumento_asso_post'),
			'fimg_url',
			array(
				'get_callback'    => [ $this, 'get_rest_featured_image' ],
				'update_callback' => null,
				'schema'          => null,
			)
		);
	}
	public function get_rest_featured_image( $object, $field_name, $request ) {
		if( $object['featured_media'] ){
			$img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
			return $img[0];
		}
		return false;
	}
}

new WP_Kumento_Content_Plugin_Settings();