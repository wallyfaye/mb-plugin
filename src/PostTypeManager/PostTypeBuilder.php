<?php

	namespace ModelBuilder\PostTypeManager;
  use ModelBuilder\Helpers\Slugify;
  use ModelBuilder\MetaBoxManager\MetaBoxBuilder;

	class PostTypeBuilder{

		public $models = array();
	
		public function __construct($models = null){
			if($models != NULL){
				$this->models = $models;
        $GLOBALS['bpPlugin']['bpPostTypes'] = array();
        $GLOBALS['bpPlugin']['bpMetaBoxes'] = array();
        $GLOBALS['bpPlugin']['bpRestFields'] = array();
			}
		}

    private function createPostType($params = array()){

      $plural = $params['plural'];
      $plural_slug = $params['plural_slug'];
      $singular = $params['singular'];
      $supports = $params['supports'];

      register_post_type( $plural_slug, array(
        'show_in_rest' => true,
        'labels' => array(
          'name' => _x( $plural, 'post type general name', 'bp-plugin-textdomain' ),
          'singular_name' => _x( $singular, 'post type singular name', 'bp-plugin-textdomain' ),
          'menu_name' => _x( $plural, 'admin menu', 'bp-plugin-textdomain' ),
          'name_admin_bar' => _x( $singular, 'add new on admin bar', 'bp-plugin-textdomain' ),
          'add_new' => _x( 'Add New', $plural_slug, 'bp-plugin-textdomain' ),
          'add_new_item' => __( 'Add New ' . $singular, 'bp-plugin-textdomain' ),
          'new_item' => __( 'New ' . $singular, 'bp-plugin-textdomain' ),
          'edit_item' => __( 'Edit ' . $singular, 'bp-plugin-textdomain' ),
          'view_item' => __( 'View ' . $singular, 'bp-plugin-textdomain' ),
          'all_items' => __( 'All ' . $plural, 'bp-plugin-textdomain' ),
          'search_items' => __( 'Search ' . $plural, 'bp-plugin-textdomain' ),
          'parent_item_colon' => __( 'Parent ' . $plural . ':', 'bp-plugin-textdomain' ),
          'not_found' => __( 'No ' . strtolower($plural) . ' found.', 'bp-plugin-textdomain' ),
          'not_found_in_trash' => __( 'No ' . strtolower($plural) . ' found in Trash.', 'bp-plugin-textdomain' )
        ),
        'description' => __( 'Description.', 'bp-plugin-textdomain' ),
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
        'supports' => $supports
      ));

    }

		public function buildPostType($post_type_schema = array()){

			$plural_slug = Slugify::getSlug($post_type_schema['plural']);
			$post_type_schema['plural_slug'] = $plural_slug;
			$GLOBALS['bpPlugin']['bpPostTypes'][] = $post_type_schema;

			add_action('init', function(){

				$i = 0;

				while(
					isset($GLOBALS['bpPlugin']['bpPostTypes'][$i]) 
					&& post_type_exists($GLOBALS['bpPlugin']['bpPostTypes'][$i]['plural_slug']) === false
				){

					$this_post_type = $GLOBALS['bpPlugin']['bpPostTypes'][$i];

          switch ($this_post_type['plural_slug']) {
            case 'pages':
              $mb_builder = new MetaBoxBuilder($this_post_type['fields']);

              foreach ($this_post_type['supports'] as $key_supports => $value_supports) {
                add_post_type_support('page', $value_supports);
              }

              foreach ($mb_builder->fields as $key_fields => $value_fields) {
                $value_fields['post_type'] = 'page';
                $mb_builder->createMetaBox($value_fields);
              }
            break;
            
            default:
              $this->createPostType(array(
                'plural' => $this_post_type['plural'],
                'plural_slug' => $this_post_type['plural_slug'],
                'singular' => $this_post_type['singular'],
                'supports' => $this_post_type['supports']
              ));

              $mb_builder = new MetaBoxBuilder($this_post_type['fields']);

              foreach ($mb_builder->fields as $key_fields => $value_fields) {
                $value_fields['post_type'] = $this_post_type['plural_slug'];
                $mb_builder->createMetaBox($value_fields);
              }
            break;
          }

					$i++;

				}

			});

		}

	}