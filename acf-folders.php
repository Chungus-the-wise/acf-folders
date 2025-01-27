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

function register_acf_folder_taxonomy() {
  register_taxonomy(
	  "acf-folder",
 	  "acf-field-group",	  
          array(
     		"labels" => array(
			"name" => "ACF Folders",
			"singular_name" => "ACF Folder",
		),
		"show_in_rest" => true,
          )
  );
}

add_action( "admin_init", "register_acf_folder_taxonomy");
