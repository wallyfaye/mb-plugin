<?php

	namespace Boilerplate\PostTypeManager;
	use Boilerplate\Helpers\Slugify;

	class PostTypeBuilder{

		public $models = array();
	
		public function __construct($models = null){
			if($models != NULL){
				$this->models = $models;
			}
		}

		public function buildPostType($post_type_schema = array()){

			$plural_slug = Slugify::getSlug($post_type_schema['plural']);
			$post_type_schema['plural_slug'] = $plural_slug;
			$GLOBALS['bpPlugin']['bpPostTypes'][] = $post_type_schema;

			add_action( 'init', function($someVar = 'test'){

				$i = 0;

				while(
					isset($GLOBALS['bpPlugin']['bpPostTypes'][$i]) 
					&& post_type_exists($GLOBALS['bpPlugin']['bpPostTypes'][$i]['plural_slug']) === false
				){

					$this_pt = $GLOBALS['bpPlugin']['bpPostTypes'][$i];
					$plural = $this_pt['plural'];
					$plural_slug = $this_pt['plural_slug'];
					$singular = $this_pt['singular'];

					$args = array(
						'labels' => array(
							'name' => _x( $plural, 'post type general name', 'your-plugin-textdomain' ),
							'singular_name' => _x( $singular, 'post type singular name', 'your-plugin-textdomain' ),
							'menu_name' => _x( $plural, 'admin menu', 'your-plugin-textdomain' ),
							'name_admin_bar' => _x( $singular, 'add new on admin bar', 'your-plugin-textdomain' ),
							'add_new' => _x( 'Add New', $plural_slug, 'your-plugin-textdomain' ),
							'add_new_item' => __( 'Add New ' . $singular, 'your-plugin-textdomain' ),
							'new_item' => __( 'New ' . $singular, 'your-plugin-textdomain' ),
							'edit_item' => __( 'Edit ' . $singular, 'your-plugin-textdomain' ),
							'view_item' => __( 'View ' . $singular, 'your-plugin-textdomain' ),
							'all_items' => __( 'All ' . $plural, 'your-plugin-textdomain' ),
							'search_items' => __( 'Search ' . $plural, 'your-plugin-textdomain' ),
							'parent_item_colon' => __( 'Parent ' . $plural . ':', 'your-plugin-textdomain' ),
							'not_found' => __( 'No ' . strtolower($plural) . ' found.', 'your-plugin-textdomain' ),
							'not_found_in_trash' => __( 'No ' . strtolower($plural) . ' found in Trash.', 'your-plugin-textdomain' )
						),
						'description' => __( 'Description.', 'your-plugin-textdomain' ),
						'public' => true,
						'publicly_queryable' => true,
						'show_ui' => true,
						'show_in_menu' => true,
						'query_var' => true,
						'rewrite' => array( 'slug' => $plural_slug ),
						'capability_type' => 'post',
						'has_archive' => true,
						'hierarchical' => false,
						'menu_position' => null,
						'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
					);

					register_post_type( $plural_slug, $args );

					$i++;

				}

			});

		}

	}