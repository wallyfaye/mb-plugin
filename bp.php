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
