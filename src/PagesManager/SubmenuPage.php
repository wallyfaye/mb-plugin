<?php

	namespace ModelBuilder\PagesManager;

	class SubmenuPage{

		public function __construct($params = array()){
			$this->post_type_schema = $params['post_type_schema'];
		}

		public function renderPage($value=''){
			$post_type_schema = $this->post_type_schema;
			add_action('admin_menu', function() use ($post_type_schema){
				add_submenu_page(
					'edit.php?post_type=' . $post_type_schema['plural_slug'],
					'Sort ' . $post_type_schema['plural'],
					'Sort',
					'edit_pages',
					$post_type_schema['plural_slug'] . '_sort',
					function() use ($post_type_schema){
						include('views/submenu_page.php');
					}
				);
			});
		}

	}
