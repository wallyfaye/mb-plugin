<?php

namespace Boilerplate\JsonLoader;

	class JsonFileParser{

		public $json_file_parsed = false;
		public $json_data;

		public function __construct($filepath = null){
			$json_file = file_get_contents($filepath);
			$json_data = json_decode($json_file, true);
			if($json_data != NULL && $json_data != FALSE){
				$this->json_file_parsed = true;
				$this->json_data = $json_data;
			}
		}

	}