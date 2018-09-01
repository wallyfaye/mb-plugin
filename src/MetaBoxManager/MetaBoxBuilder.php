<?php

  namespace Boilerplate\MetaBoxManager;

  class MetaBoxBuilder{

    public function __construct($fields = array()){
      $this->fields = $fields;
      $this->meta_box_lib_include = array(
        'input_text' => false,
        'input_date' => false,
        'input_colorpicker' => false,
        'input_editor' => false,
      );
    }

    private function generateMetaBox($post_data, $meta_box_data){
      $include_lib = false;
      if($this->meta_box_lib_include[$meta_box_data['type']] == false){
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
                $meta_box_value = $_POST[$meta_box_key];
                $post_ID = $_POST['post_ID'];

                if(isset($meta_box_value)){

                  update_post_meta( 
                    $post_ID, 
                    $meta_box_key, 
                    sanitize_text_field( $meta_box_value ) 
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

    }

  }
