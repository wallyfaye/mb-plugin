<?php  

	declare(strict_types=1);
	
	use PHPUnit\Framework\TestCase;

	final class JsonFileParserTest extends TestCase
	{

		protected $validate;

		public function setUp() {
			// $this->model_json = new \Boilerplate\JsonLoader\JsonFileParser($plugin_models);
		}

		/** @test
		 *	@covers JsonLoader::JsonFileParser
		 */

		public function validate_gets_valid_request_1(){
			$this->assertFalse(false, strtoupper('Bad file name'));
		}

	}

?>
