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
class Kumento_Content_Post_Types {
	/**
	* Recourses
	* https://codebriefly.com/how-to-create-taxonomy-for-users-in-wordpress/
	* https://www.nopio.com/blog/add-user-taxonomy-wordpress/
	*/
	public function register_kumento_news() {
		
		$labels = array(
			'name'               => __( 'Kumento News', 'kumento_content' ),
			'singular_name'      => __( 'Kumento News', 'kumento_content' ),
			'menu_name'          => __( 'Kumento News', 'kumento_content' ),
			'name_admin_bar'     => __( 'Kumento News', 'kumento_content' ),
			'add_new'            => __( 'Add new', 'kumento_content' ),
			'add_new_item'       => __( 'Add new Post', 'kumento_content' ),
			'new_item'           => __( 'New Post', 'kumento_content' ),
			'edit_item'          => __( 'Edit Post', 'kumento_content' ),
			'view_item'          => __( 'Show Post', 'kumento_content' ),
			'all_items'          => __( 'All Posts', 'kumento_content' ),
			'search_items'       => __( 'Search Posts', 'kumento_content' ),
			'parent_item_colon'  => __( 'Parent Posts:', 'kumento_content' ),
			'not_found'          => __( 'No Posts found.', 'kumento_content' ),
			'not_found_in_trash' => __( 'No Posts found in trash.', 'kumento_content' )
		);

		$args = array( 
			'public'      => false, 
			'labels'      => $labels,
			'has_archive' => false,
			'description' => __( 'Kumento News', 'kumento_content' ),
			'show_ui'	        => true,
			'show_in_admin_bar' => true,
			'menu_position' => 25,
			'menu_icon' => 'dashicons-admin-users',
			'taxonomies' => array( 'kumento_news_category' ),
			'query_var'          => true,
    		'rewrite'            => array( 'slug' => 'kumento_news' ),
			'exclude_from_search' => true,
			'supports' => array( 'title', 'editor', 'comments', 'revisions', 'trackbacks', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' => true,
			'show_in_rest' => true,
			'rest_base'          => 'kumento_news',
    		'rest_controller_class' => 'WP_REST_Posts_Controller'
		);
    	register_post_type( 'kumento_news', $args );
    }
	
	public function register_kumento_news_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'Categories', 'kumento_content' ),
			'singular_name'              => __( 'Categories', 'kumento_content' ),
			'menu_name'                  => __( 'Categories', 'kumento_content' ),
			'all_items'                  => __( 'All Categories', 'kumento_content' ),
			'parent_item'                => __( 'Parent Category', 'kumento_content' ),
			'parent_item_colon'          => __( 'Parent Category:', 'kumento_content' ),
			'new_item_name'              => __( 'New Category Name', 'kumento_content' ),
			'add_new_item'               => __( 'Add new Category', 'kumento_content' ),
			'edit_item'                  => __( 'Edit Category', 'kumento_content' ),
			'update_item'                => __( 'Update Category', 'kumento_content' ),
			'view_item'                  => __( 'View Category', 'kumento_content' ),
			'separate_items_with_commas' => __( 'Separate Category with commas', 'kumento_content' ),
			'add_or_remove_items'        => __( 'Add or remove Categories', 'kumento_content' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'kumento_content' ),
			'popular_items'              => __( 'Popular Categories', 'kumento_content' ),
			'search_items'               => __( 'Search Categories', 'kumento_content' ),
			'not_found'                  => __( 'Not Found', 'kumento_content' ),
			'no_terms'                   => __( 'No Categories', 'kumento_content' ),
			'items_list'                 => __( 'Categories list', 'kumento_content' ),
			'items_list_navigation'      => __( 'Categories list navigation', 'kumento_content' ),
		  );
		  $args = array(
			'labels'                    => $labels,
			'hierarchical'              => true,
			'public'                    => true,
			'show_ui'                   => true,
			'show_admin_column'         => true,
			'show_in_nav_menus'         => true,
			'show_in_rest'             	=> true,
			'rest_base'             => 'kumento_news_category',
    		'rest_controller_class' => 'WP_REST_Terms_Controller'
		  );
		  register_taxonomy( 'kumento_news_category', array( 'kumento_news' ), $args );

    }
}
?>