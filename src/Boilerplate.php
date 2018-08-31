<?php

	namespace Boilerplate;

	use Boilerplate\JsonLoader\JsonFileParser;
	use Boilerplate\PostTypeManager\PostTypeBuilder;

	class Boilerplate{

		public function __construct($params = array()) 
		{
			$GLOBALS['bpPlugin'] = array();
			$this->models_file = $params['models_file'];
		}

		public function readModelsFile(){
			$model_json = new JsonFileParser($this->models_file);
			if($model_json->json_decoded != true){
				exit("models.json could not be decoded");
			}
			$this->models_array = $model_json->json_data;
		}

		public function buildPostTypes($value='')
		{
			$pt_builder = new PostTypeBuilder($this->models_array);

			$GLOBALS['bpPlugin']['bpPostTypes'] = array();

			foreach ($pt_builder->models as $key_model => $value_model) {
				$pt_builder->buildPostType($value_model);
			}

		}


	}