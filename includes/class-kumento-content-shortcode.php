<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://vander.dk
 * @since      1.0.0
 *
 * @package    Kumento_Content
 * @subpackage Kumento_Content/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Kumento_Content
 * @subpackage Kumento_Content/includes
 * @author     Ulrik Vander <ulrik@vander.dk>
 */
class Kumento_Content_Shortcode {
	
	private $plugin_name;

	public function register_shortcodes() {
		add_shortcode( 'kumento_post', array( $this, 'kumento_post_shortcode_function') );
	}

	public function kumento_post_shortcode_function($atts = []){
		$a = shortcode_atts( array(
			'sourceUrl' => 'https://test.kumento.org',
			'type' => 'kumento_news_post',
			'layout' => '',
			'showSidebar' => false,
			'category' => '',
		), $atts );
		?>

		<div id="kumentoApp" style="position: relative; width: 100%; display: block;"></div>

		<script type="text/javascript">
			var sourceUrl = '<?php echo $a['sourceUrl']; ?>';
			var type = '<?php echo $a['type']; ?>';
			var layout = '<?php echo $a['layout']; ?>';
			var showSidebar = '<?php echo $a['showSidebar']; ?>';
			var category = '<?php echo $a['category']; ?>';
			const kumento = {
				sourceUrl: sourceUrl,
				type:  type,
				layout: layout,
				showSidebar: showSidebar,
				category: category,
			};
		</script>
		<script
			type="module"
			crossorigin
			src="<?php echo KUMENTO_CONTENT_URL; ?>assets/index.js?v=<?php echo filemtime(KUMENTO_CONTENT_PATH . '/assets/index.js'); ?>"
		>
		</script>
		<?php
    }
}
?>