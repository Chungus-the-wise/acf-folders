<?php

/**
 * Plugin Name: ACF Folders
 * Description:       Add Folders to acf features
 * Version:           1.0
 * Requires at least: 5.6
 * Requires PHP:      7.3
 * Author:            Antoine Dessertenne
 * Author URI:        https://github.com/Chungus-the-wise
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       acf-folders
 * Domain Path:       /languages
 * Requires Plugins:  advanced-custom-fields
 */

// Adds Folders taxonomy
function register_acf_folder_taxonomy() {
  register_taxonomy(
    "acf-folder",
    "acf-field-group",	  
    array(
      "labels" => array(
        "name" => "ACF Folders",
        "singular_name" => "ACF Folder",
      ),
      "show_in_menu" => true,
      "show_in_rest" => true,
      "public" => true,
      "show_admin_column" => true,
      "hierarchical" => true,
    )
  );
}

// Adds menu item to ACF parent menu
function add_acf_folder_menu_item() {
  add_submenu_page(
    'edit.php?post_type=acf-field-group',
    'ACF Folders',
    'ACF Folders',
    'edit_posts',
    'edit-tags.php?taxonomy=acf-folder',
    '',

  );
}

// For some reason, we need to alter the taxonomy view query on the post list page
function folders_list_filter( $query ) {
  if( ! is_admin() ) {
   return;
  }
  if (
      $query->query['post_type'] == 'post'
      //&& isset($query->query['acf-folders'])
  ) {
    $folder = $query->query['acf-folder'];
    $query->set( "post_type", "acf-field-group" );
    $tax_query = array(
      array(
        "taxonomy" => "acf-folder",
        "field" => "slug",
        "terms" => array($folder),
        "operator" => "IN"
      )
    );
    $query->set( "tax_query", $tax_query );
  }

}
add_filter( 'pre_get_posts', 'folders_list_filter' );
add_action( "acf/init", "register_acf_folder_taxonomy");
add_action( "admin_menu", "add_acf_folder_menu_item" );
