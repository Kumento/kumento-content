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

	/**
	 * Kumento News
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
			'public'      			=> false, 
			'labels'      			=> $labels,
			'has_archive' 			=> false,
			'description' 			=> __( 'Kumento News', 'kumento_content' ),
			'public'	        	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-rest-api',
			'taxonomies' 			=> array( 'kumento_news_category' ),
			'query_var'          	=> true,
    		'rewrite'            	=> array( 'slug' => 'k_news' ),
			'supports' 				=> array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' 			=> true,
			'show_in_rest' 			=> true,
			'rest_base'          	=> 'kumento_news_post',
    		'rest_controller_class' => 'WP_REST_Posts_Controller'
		);
    	register_post_type( 'kumento_news_post', $args );
    }
	
	public function register_kumento_news_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'News Categories', 'kumento_content' ),
			'singular_name'              => __( 'News Categories', 'kumento_content' ),
			'menu_name'                  => __( 'News Categories', 'kumento_content' ),
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
			'rewrite'            		=> array( 'slug' => 'k_news_cat' ),
			'rest_base'             	=> 'kumento_news_category',
    		'rest_controller_class' 	=> 'WP_REST_Terms_Controller'
		  );
		  register_taxonomy( 'kumento_news_category', array( 'kumento_news_post' ), $args );

    }

	/**
	 * Kumento Press
	 */
	public function register_kumento_press() {
		
		$labels = array(
			'name'               => __( 'Kumento Press', 'kumento_content' ),
			'singular_name'      => __( 'Kumento Press', 'kumento_content' ),
			'menu_name'          => __( 'Kumento Press', 'kumento_content' ),
			'name_admin_bar'     => __( 'Kumento Press', 'kumento_content' ),
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
			'public'      			=> false, 
			'labels'      			=> $labels,
			'has_archive' 			=> false,
			'description' 			=> __( 'Kumento Press', 'kumento_content' ),
			'public'	        	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-rest-api',
			'taxonomies' 			=> array( 'kumento_press_category' ),
			'query_var'          	=> true,
    		'rewrite'            	=> array( 'slug' => 'k_press' ),
			'supports' 				=> array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' 			=> true,
			'show_in_rest' 			=> true,
			'rest_base'          	=> 'kumento_press_post',
    		'rest_controller_class' => 'WP_REST_Posts_Controller'
		);
    	register_post_type( 'kumento_press_post', $args );
    }
	
	public function register_kumento_press_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'Press Categories', 'kumento_content' ),
			'singular_name'              => __( 'Press Categories', 'kumento_content' ),
			'menu_name'                  => __( 'Press Categories', 'kumento_content' ),
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
			'rewrite'            		=> array( 'slug' => 'k_press_cat' ),
			'rest_base'             	=> 'kumento_press_category',
    		'rest_controller_class' 	=> 'WP_REST_Terms_Controller'
		  );
		  register_taxonomy( 'kumento_press_category', array( 'kumento_press_post' ), $args );

    }

	/**
	 * Kumento Event
	 */
	public function register_kumento_event() {
		
		$labels = array(
			'name'               => __( 'Kumento Event', 'kumento_content' ),
			'singular_name'      => __( 'Kumento Event', 'kumento_content' ),
			'menu_name'          => __( 'Kumento Event', 'kumento_content' ),
			'name_admin_bar'     => __( 'Kumento Event', 'kumento_content' ),
			'add_new'            => __( 'Add new', 'kumento_content' ),
			'add_new_item'       => __( 'Add new Event', 'kumento_content' ),
			'new_item'           => __( 'New Event', 'kumento_content' ),
			'edit_item'          => __( 'Edit Event', 'kumento_content' ),
			'view_item'          => __( 'Show Event', 'kumento_content' ),
			'all_items'          => __( 'All Events', 'kumento_content' ),
			'search_items'       => __( 'Search Events', 'kumento_content' ),
			'parent_item_colon'  => __( 'Parent Events:', 'kumento_content' ),
			'not_found'          => __( 'No Events found.', 'kumento_content' ),
			'not_found_in_trash' => __( 'No Events found in trash.', 'kumento_content' )
		);

		$args = array( 
			'public'      			=> false, 
			'labels'      			=> $labels,
			'has_archive' 			=> false,
			'description' 			=> __( 'Kumento Event', 'kumento_content' ),
			'public'	        	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-rest-api',
			'taxonomies' 			=> array( 'kumento_event_category' ),
			'query_var'          	=> true,
    		'rewrite'            	=> array( 'slug' => 'k_event' ),
			'supports' 				=> array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' 			=> true,
			'show_in_rest' 			=> true,
			'rest_base'          	=> 'kumento_event_post',
    		'rest_controller_class' => 'WP_REST_Posts_Controller'
		);
    	register_post_type( 'kumento_event_post', $args );
    }
	
	public function register_kumento_event_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'Event Categories', 'kumento_content' ),
			'singular_name'              => __( 'Event Categories', 'kumento_content' ),
			'menu_name'                  => __( 'Event Categories', 'kumento_content' ),
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
			'rewrite'            		=> array( 'slug' => 'k_event_cat' ),
			'rest_base'             	=> 'kumento_event_category',
    		'rest_controller_class' 	=> 'WP_REST_Terms_Controller'
		  );
		  register_taxonomy( 'kumento_event_category', array( 'kumento_event_post' ), $args );

    }

	/**
	 * Kumento Company
	 */
	public function register_kumento_company() {
		
		$labels = array(
			'name'               => __( 'Kumento Company', 'kumento_content' ),
			'singular_name'      => __( 'Kumento Company', 'kumento_content' ),
			'menu_name'          => __( 'Kumento Company', 'kumento_content' ),
			'name_admin_bar'     => __( 'Kumento Company', 'kumento_content' ),
			'add_new'            => __( 'Add new', 'kumento_content' ),
			'add_new_item'       => __( 'Add new Company', 'kumento_content' ),
			'new_item'           => __( 'New Company', 'kumento_content' ),
			'edit_item'          => __( 'Edit Company', 'kumento_content' ),
			'view_item'          => __( 'Show Company', 'kumento_content' ),
			'all_items'          => __( 'All Companies', 'kumento_content' ),
			'search_items'       => __( 'Search Companies', 'kumento_content' ),
			'parent_item_colon'  => __( 'Parent Companies:', 'kumento_content' ),
			'not_found'          => __( 'No Companies found.', 'kumento_content' ),
			'not_found_in_trash' => __( 'No Companies found in trash.', 'kumento_content' )
		);

		$args = array( 
			'public'      			=> false, 
			'labels'      			=> $labels,
			'has_archive' 			=> false,
			'description' 			=> __( 'Kumento Company', 'kumento_content' ),
			'public'	        	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-rest-api',
			'taxonomies' 			=> array( 'kumento_company_category' ),
			'query_var'          	=> true,
    		'rewrite'            	=> array( 'slug' => 'k_company' ),
			'supports' 				=> array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' 			=> true,
			'show_in_rest' 			=> true,
			'rest_base'          	=> 'kumento_company_post',
    		'rest_controller_class' => 'WP_REST_Posts_Controller'
		);
    	register_post_type( 'kumento_company_post', $args );
    }
	
	public function register_kumento_company_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'Company Categories', 'kumento_content' ),
			'singular_name'              => __( 'Company Categories', 'kumento_content' ),
			'menu_name'                  => __( 'Company Categories', 'kumento_content' ),
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
			'rewrite'            		=> array( 'slug' => 'k_company_cat' ),
			'rest_base'             	=> 'kumento_company_category',
    		'rest_controller_class' 	=> 'WP_REST_Terms_Controller'
		  );
		  register_taxonomy( 'kumento_company_category', array( 'kumento_company_post' ), $args );

    }

	/**
	 * Kumento Association
	 */
	public function register_kumento_association() {
		
		$labels = array(
			'name'               => __( 'Kumento Association', 'kumento_content' ),
			'singular_name'      => __( 'Kumento Association', 'kumento_content' ),
			'menu_name'          => __( 'Kumento Association', 'kumento_content' ),
			'name_admin_bar'     => __( 'Kumento Association', 'kumento_content' ),
			'add_new'            => __( 'Add new', 'kumento_content' ),
			'add_new_item'       => __( 'Add new Association', 'kumento_content' ),
			'new_item'           => __( 'New Association', 'kumento_content' ),
			'edit_item'          => __( 'Edit Association', 'kumento_content' ),
			'view_item'          => __( 'Show Association', 'kumento_content' ),
			'all_items'          => __( 'All Associations', 'kumento_content' ),
			'search_items'       => __( 'Search Associations', 'kumento_content' ),
			'parent_item_colon'  => __( 'Parent Associations:', 'kumento_content' ),
			'not_found'          => __( 'No Associations found.', 'kumento_content' ),
			'not_found_in_trash' => __( 'No Associations found in trash.', 'kumento_content' )
		);

		$args = array( 
			'public'      			=> false, 
			'labels'      			=> $labels,
			'has_archive' 			=> false,
			'description' 			=> __( 'Kumento Association', 'kumento_content' ),
			'public'	        	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position' 		=> 5,
			'menu_icon' 			=> 'dashicons-rest-api',
			'taxonomies' 			=> array( 'kumento_asso_category' ),
			'query_var'          	=> true,
    		'rewrite'            	=> array( 'slug' => 'k_asso' ),
			'supports' 				=> array( 'title', 'editor', 'comments', 'revisions', 'author', 'excerpt', 'page-attributes', 'thumbnail', 'custom-fields' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' 			=> true,
			'show_in_rest' 			=> true,
			'rest_base'          	=> 'kumento_association_post',
    		'rest_controller_class' => 'WP_REST_Posts_Controller'
		);
    	register_post_type( 'kumento_asso_post', $args );
    }
	
	public function register_kumento_association_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'Association Categories', 'kumento_content' ),
			'singular_name'              => __( 'Association Categories', 'kumento_content' ),
			'menu_name'                  => __( 'Association Categories', 'kumento_content' ),
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
			'rewrite'            		=> array( 'slug' => 'k_asso_cat' ),
			'rest_base'             	=> 'kumento_association_category',
    		'rest_controller_class' 	=> 'WP_REST_Terms_Controller'
		  );
		  register_taxonomy( 'kumento_asso_category', array( 'kumento_asso_post' ), $args );

    }
}
?>