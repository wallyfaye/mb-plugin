<?php

  namespace ModelBuilder\MetaBoxManager;

  class MetaBoxBuilder{

    public function __construct($fields = array()){
      $this->fields = $fields;
      $this->meta_box_lib_include = array(
        'input_text' => false,
        'input_date' => false,
        'input_colorpicker' => false,
        'input_editor' => false,
        'input_featured_images' => false,
        'input_checkbox_multi' => false,
        'input_select' => false,
        'input_radio' => false
      );
    }

    private function generateMetaBox($post_data, $meta_box_data){
      $include_lib = false;
      if(
        isset($this->meta_box_lib_include[$meta_box_data['type']]) 
        && $this->meta_box_lib_include[$meta_box_data['type']] == false
      ){
        $this->meta_box_lib_include[$meta_box_data['type']] = true;
        $include_lib = true;
      }

      switch ($meta_box_data['type']) {

        case 'input_text':
          $input_text = new InputText($post_data, $meta_box_data);
          $input_text->render($include_lib);
        break;

        case 'input_date':
          $input_date = new InputDate($post_data, $meta_box_data);
          $input_date->render($include_lib);
        break;

        case 'input_colorpicker':
          $input_colorpicker = new InputColorpicker($post_data, $meta_box_data);
          $input_colorpicker->render($include_lib);
        break;

        case 'input_editor':
          $input_editor = new InputEditor($post_data, $meta_box_data);
          $input_editor->render($include_lib);
        break;

        case 'input_featured_images':
          $input_featured_images = new InputFeaturedImages($post_data, $meta_box_data);
          $input_featured_images->render($include_lib);
        break;

        case 'input_checkbox_single':
          $input_checkbox_single = new InputCheckboxSingle($post_data, $meta_box_data);
          $input_checkbox_single->render($include_lib);
        break;

        case 'input_checkbox_multi':
          $input_checkbox_multi = new InputCheckboxMulti($post_data, $meta_box_data);
          $input_checkbox_multi->render($include_lib);
        break;

        case 'input_select':
          $input_select = new InputSelect($post_data, $meta_box_data);
          $input_select->render($include_lib);
        break;

        case 'input_radio':
          $input_radio = new InputRadio($post_data, $meta_box_data);
          $input_radio->render($include_lib);
        break;
      }
    }

    private function addMetaBoxes(){

      add_action('add_meta_boxes', function(){

        $i = 0;

        while(
          isset($GLOBALS['bpPlugin']['bpMetaBoxes'][$i]) 
          && $GLOBALS['bpPlugin']['bpMetaBoxes'][$i]['isset'] === false
        ){

          $this_meta_box = $GLOBALS['bpPlugin']['bpMetaBoxes'][$i];

          $field_slug = $this_meta_box['field_slug'];
          $field_proper = $this_meta_box['field_proper'];
          $type = $this_meta_box['type'];
          $post_type = $this_meta_box['post_type'];
          $position = isset($this_meta_box['position']) ? $this_meta_box['position'] : 'side';

          add_meta_box(
            $field_slug,
            $field_proper,
            function($post, $arguments){
              $this->generateMetaBox($post, $arguments['args']);
            },
            $post_type,
            $position,
            'default',
            $this_meta_box
          );

          $i++;

        }

      });

    }

    private function savePost(){

      add_action('save_post', function(){

        if(isset($_POST['post_type'])){

          foreach ($GLOBALS['bpPlugin']['bpPostTypes'] as $key_bpPostTypes => $value_bpPostTypes) {

            if($value_bpPostTypes['plural_slug'] == $_POST['post_type']){

              foreach ($value_bpPostTypes['fields'] as $key_fields => $value_fields) {

                $meta_box_key = $value_fields['field_slug'];
                $post_ID = $_POST['post_ID'];

                if(isset($_POST[$meta_box_key])){
                  $meta_box_value = $_POST[$meta_box_key];

                  update_post_meta( 
                    $post_ID, 
                    $meta_box_key, 
                    (gettype($meta_box_value) === 'string') ? sanitize_text_field($meta_box_value) : $meta_box_value
                  );

                } else {

                  update_post_meta( 
                    $post_ID, 
                    $meta_box_key, 
                    ''
                  );

                }

              }

            }

          }

        }

      });

    }

    public function createMetaBox($params = array()){

      $params['isset'] = false;
      $GLOBALS['bpPlugin']['bpMetaBoxes'][] = $params;

      $this->addMetaBoxes();
      $this->savePost();

      $GLOBALS['bpPlugin']['bpRestFields'][] = $params;
      add_action('rest_api_init', function(){

        $i = 0;

        while(
          isset($GLOBALS['bpPlugin']['bpRestFields'][$i]) 
          && $GLOBALS['bpPlugin']['bpRestFields'][$i]['isset'] === false
        ){

          $this_rest_field = $GLOBALS['bpPlugin']['bpRestFields'][$i];

          register_rest_field( $this_rest_field['post_type'], $this_rest_field['field_slug'], array(
            'get_callback' => function($object, $field_name){
              return get_post_meta( $object['id'], $field_name, true);
            }
          ));

          $GLOBALS['bpPlugin']['bpRestFields'][$i]['isset'] = true;
          $i++;

        }

      });

    }

  }
