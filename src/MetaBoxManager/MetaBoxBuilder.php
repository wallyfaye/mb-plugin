<?php

  namespace Boilerplate\MetaBoxManager;

  class MetaBoxBuilder{

    public function __construct($fields = array()){
      $this->fields = $fields;
    }

    private function generateMetaBox($post_data, $meta_box_data){
      switch ($meta_box_data['type']) {
        case 'input_text':
          $input_text = new InputText($post_data, $meta_box_data);
          $input_text->render();
        break;
      }
    }

    public function createMetaBox($params = array()){

      $params['isset'] = false;
      $GLOBALS['bpPlugin']['bpMetaBoxes'][] = $params;

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

      add_action('save_post', function(){

        if(isset($_POST['post_type'])){
          
          foreach ($GLOBALS['bpPlugin']['bpPostTypes'] as $key_bpPostTypes => $value_bpPostTypes) {

            if($value_bpPostTypes['plural_slug'] == $_POST['post_type']){

              foreach ($value_bpPostTypes['fields'] as $key_fields => $value_fields) {

                $meta_box_id = $value_fields['field_slug'];
                $meta_box_value = $_POST[$meta_box_id];
                $post_ID = $_POST['post_ID'];

                if(isset($meta_box_value)){

                  update_post_meta( $post_ID, $meta_box_id, sanitize_text_field( $meta_box_value ) );

                }

              }

            }

          }

        }

      });

    }

  }
