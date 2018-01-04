<?php

	/**
		 * @package Wordpress_BP
		 * @version 0.1
	*/
	/*
		Plugin Name: Wordpress Boilerplate
		Plugin URI: https://github.com/wallyfaye/bp
		Description: This is meant to be used to get projects started quickly
		Author: Wally Faye
		Version: 0.1
		Author URI: https://github.com/wallyfaye
	*/

	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	// include class autoloader
		require 'Psr4AutoloaderClass.php';

	// resource variables
		$plugin_folder = '/var/www/html/wp-content/plugins/';
		$plugin_source = 'bp/src';
		$plugin_models = 'bp/models.json';

	// autoload classes
		$loader = new \PHP_FIG\Psr4AutoloaderClass;
		$loader->register();
		$loader->addNamespace('Boilerplate', $plugin_folder . $plugin_source);

	// load json models
		$model_json = new \Boilerplate\JsonLoader\JsonFileParser($plugin_folder . $plugin_models);
		if($model_json->json_file_parsed != true){
			exit("error with models.json");
		}

		print_r($model_json->json_data);
		die();

		

// add_action( 'init', 'codex_book_init' );

// function codex_book_init() {
// 	$class_1 = new \Foo\Bar\Qux\Quux;
// 	$class_2 = new \Foo\Bar\Baz;

// 	$labels = array(
// 		'name'               => _x( 'Books', 'post type general name', 'your-plugin-textdomain' ),
// 		'singular_name'      => _x( 'Book', 'post type singular name', 'your-plugin-textdomain' ),
// 		'menu_name'          => _x( $class_1->foo_bar . '_' . $class_2->foo_bar, 'admin menu', 'your-plugin-textdomain' ),
// 		'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'your-plugin-textdomain' ),
// 		'add_new'            => _x( 'Add New', 'book', 'your-plugin-textdomain' ),
// 		'add_new_item'       => __( 'Add New Book', 'your-plugin-textdomain' ),
// 		'new_item'           => __( 'New Book', 'your-plugin-textdomain' ),
// 		'edit_item'          => __( 'Edit Book', 'your-plugin-textdomain' ),
// 		'view_item'          => __( 'View Book', 'your-plugin-textdomain' ),
// 		'all_items'          => __( 'All Books', 'your-plugin-textdomain' ),
// 		'search_items'       => __( 'Search Books', 'your-plugin-textdomain' ),
// 		'parent_item_colon'  => __( 'Parent Books:', 'your-plugin-textdomain' ),
// 		'not_found'          => __( 'No books found.', 'your-plugin-textdomain' ),
// 		'not_found_in_trash' => __( 'No books found in Trash.', 'your-plugin-textdomain' )
// 	);

// 	$args = array(
// 		'labels'             => $labels,
// 		'description'        => __( 'Description.', 'your-plugin-textdomain' ),
// 		'public'             => true,
// 		'publicly_queryable' => true,
// 		'show_ui'            => true,
// 		'show_in_menu'       => true,
// 		'query_var'          => true,
// 		'rewrite'            => array( 'slug' => 'book' ),
// 		'capability_type'    => 'post',
// 		'has_archive'        => true,
// 		'hierarchical'       => false,
// 		'menu_position'      => null,
// 		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
// 	);

// 	register_post_type( 'book', $args );
// }