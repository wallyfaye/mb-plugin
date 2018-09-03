<?php

	/**
		 * @package Wordpress_BP
		 * @version 0.1
	*/
	/*
		Plugin Name: Wordpress Model Builder
		Plugin URI: https://github.com/wallyfaye/bp
		Description: Create custom post types with meta boxes and REST API endpoints
		Author: Wally Faye
		Version: 0.2
		Author URI: https://github.com/wallyfaye
	*/

	// debugging
		ini_set('display_errors', 1);
		error_reporting(E_ALL);

	// include class autoloader
		require __DIR__ . '/vendor/autoload.php';
		use Boilerplate\Boilerplate;

		$bp = new Boilerplate(array(
			'models_file' => __DIR__ . '/src/models.json'
		));

		$bp->readModelsFile();
		$bp->buildPostTypes();