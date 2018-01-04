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

	// resource variables
		$plugin_models = __DIR__ . '/src/models.json';

	// load json models
		$model_json = new \Boilerplate\JsonLoader\JsonFileParser($plugin_models);
		if($model_json->json_file_parsed != true){
			exit("error with models.json");
		}

		print_r($model_json->json_data);
		die();
