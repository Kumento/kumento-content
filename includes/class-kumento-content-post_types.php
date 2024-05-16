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
	public function register_certa_member_files() {
		
		$labels = array(
			'name'               => __( 'Certa File Upload', 'kumento_content' ),
			'singular_name'      => __( 'Certa File Upload', 'kumento_content' ),
			'menu_name'          => __( 'Certa File Upload', 'kumento_content' ),
			'name_admin_bar'     => __( 'Certa File Upload', 'kumento_content' ),
			'add_new'            => __( 'Add new', 'kumento_content' ),
			'add_new_item'       => __( 'Add new File', 'kumento_content' ),
			'new_item'           => __( 'New File', 'kumento_content' ),
			'edit_item'          => __( 'Edit File', 'kumento_content' ),
			'view_item'          => __( 'Show File', 'kumento_content' ),
			'all_items'          => __( 'All Files', 'kumento_content' ),
			'search_items'       => __( 'Search Files', 'kumento_content' ),
			'parent_item_colon'  => __( 'Parent Files:', 'kumento_content' ),
			'not_found'          => __( 'No Files found.', 'kumento_content' ),
			'not_found_in_trash' => __( 'No Files found in trash.', 'kumento_content' )
		);

		$args = array( 
			'public'      => false, 
			'labels'      => $labels,
			'has_archive' => false,
			'description' => __( 'File Section', 'kumento_content' ),
			'show_ui'	        => true,
			'show_in_admin_bar' => true,
			'menu_position' => 25,
			'menu_icon' => 'dashicons-admin-users',
			'taxonomies' => array( 'certa_member_file_cat' ),
			'exclude_from_search' => true,
			'supports' => array( 'title' ),
			// as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
			'map_meta_cap' => true
		);
    	register_post_type( 'certa_member_files', $args );
    }
	
	public function register_certa_member_file_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'File Categories', 'kumento_content' ),
			'singular_name'              => __( 'File Categories', 'kumento_content' ),
			'menu_name'                  => __( 'File Categories', 'kumento_content' ),
			'all_items'                  => __( 'All File Categories', 'kumento_content' ),
			'parent_item'                => __( 'Parent File Category', 'kumento_content' ),
			'parent_item_colon'          => __( 'Parent File Category:', 'kumento_content' ),
			'new_item_name'              => __( 'New File Category Name', 'kumento_content' ),
			'add_new_item'               => __( 'Add new File Category', 'kumento_content' ),
			'edit_item'                  => __( 'Edit File Category', 'kumento_content' ),
			'update_item'                => __( 'Update File Category', 'kumento_content' ),
			'view_item'                  => __( 'View File Category', 'kumento_content' ),
			'separate_items_with_commas' => __( 'Separate File Category with commas', 'kumento_content' ),
			'add_or_remove_items'        => __( 'Add or remove File Categories', 'kumento_content' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'kumento_content' ),
			'popular_items'              => __( 'Popular File Categories', 'kumento_content' ),
			'search_items'               => __( 'Search File Categories', 'kumento_content' ),
			'not_found'                  => __( 'Not Found', 'kumento_content' ),
			'no_terms'                   => __( 'No File Categories', 'kumento_content' ),
			'items_list'                 => __( 'File Categories list', 'kumento_content' ),
			'items_list_navigation'      => __( 'File Categories list navigation', 'kumento_content' ),
		  );
		  $args = array(
			'labels'                    => $labels,
			'hierarchical'              => true,
			'public'                    => true,
			'show_ui'                   => true,
			'show_admin_column'         => true,
			'show_in_nav_menus'         => true,
			'show_tagcloud'             => true,
		  );
		  register_taxonomy( 'certa_member_file_cat', array( 'certa_member_files' ), $args );

    }

    public function register_certa_member_taxnonomy() {
		
		$labels = array(
			'name'                       => __( 'Certa Member Categories', 'kumento_content' ),
			'singular_name'              => __( 'Certa Member Categories', 'kumento_content' ),
			'menu_name'                  => __( 'Member Categories', 'kumento_content' ),
			'all_items'                  => __( 'All Member Categories', 'kumento_content' ),
			'parent_item'                => __( 'Parent Member Category', 'kumento_content' ),
			'parent_item_colon'          => __( 'Parent Member Category:', 'kumento_content' ),
			'new_item_name'              => __( 'New Member Category Name', 'kumento_content' ),
			'add_new_item'               => __( 'Add new Member Category', 'kumento_content' ),
			'edit_item'                  => __( 'Edit Member Category', 'kumento_content' ),
			'update_item'                => __( 'Update Member Category', 'kumento_content' ),
			'view_item'                  => __( 'View Member Category', 'kumento_content' ),
			'separate_items_with_commas' => __( 'Separate Member Category with commas', 'kumento_content' ),
			'add_or_remove_items'        => __( 'Add or remove Member Categories', 'kumento_content' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'kumento_content' ),
			'popular_items'              => __( 'Popular Member Categories', 'kumento_content' ),
			'search_items'               => __( 'Search Member Categories', 'kumento_content' ),
			'not_found'                  => __( 'Not Found', 'kumento_content' ),
			'no_terms'                   => __( 'No Member Categories', 'kumento_content' ),
			'items_list'                 => __( 'Member Categories list', 'kumento_content' ),
			'items_list_navigation'      => __( 'Member Categories list navigation', 'kumento_content' ),
		  );
		  $args = array(
			'labels'                    => $labels,
			'hierarchical'              => true,
			'public'                    => true,
			'show_ui'                   => true,
			'show_admin_column'         => true,
			'show_in_nav_menus'         => true,
			'show_tagcloud'             => true,
		  );
		  register_taxonomy( 'certa_member_cat', 'user', $args );

    }
}
?>