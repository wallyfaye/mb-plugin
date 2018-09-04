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

    private function addMetaBoxes($params){

      add_action('add_meta_boxes', function() use ($params){

        $field_slug = $params['field_slug'];
        $field_proper = $params['field_proper'];
        $type = $params['type'];
        $post_type = $params['post_type'];
        $position = isset($params['position']) ? $params['position'] : 'side';

        add_meta_box(
          $field_slug,
          $field_proper,
          function($post, $arguments){
            $this->generateMetaBox($post, $arguments['args']);
          },
          $post_type,
          $position,
          'default',
          $params
        );

      });

    }

    private function savePost($params){

      add_action('save_post', function() use ($params){

        if(isset($_POST['post_type'])){

          $meta_box_key = $params['field_slug'];
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

      });

    }

    public function createMetaBox($params = array()){

      $this->addMetaBoxes($params);
      $this->savePost($params);

      add_action('rest_api_init', function() use ($params){

        register_rest_field( $params['post_type'], $params['field_slug'], array(
          'get_callback' => function($object, $field_name){
            return get_post_meta( $object['id'], $field_name, true);
          }
        ));

      });

    }

    public function createUserMetaBoxes($params = array()){

      $context = $this;

      add_action( 'show_user_profile', function($user_data) use ($context, $params){
        $context->createUserProfile($user_data, $params);
      });

      add_action( 'edit_user_profile', function($user_data) use ($context, $params){
        $context->createUserProfile($user_data, $params);
      });

      add_action( 'personal_options_update', function($user_id) use ($context, $params){
        $context->updateUserData($user_id, $params);
      });
      add_action( 'edit_user_profile_update', function($user_id) use ($context, $params){
        $context->updateUserData($user_id, $params);
      });

    }

    public function createUserProfile($user_data = array(), $params = array()){

      $userInputs = '';

      ob_start();

      foreach ($this->fields as $key_fields => $value_fields) {
        $this->createUserMetaBox($user_data, $value_fields);
      }

      $userInputs .= ob_get_clean();

      include('views/user_form.php');

    }

    public function createUserMetaBox($user_data = array(), $params = array()){

      $field_proper = $params['field_proper'];
      $field_slug = $params['field_slug'];

      ob_start();
      $this->generateMetaBox($user_data, $params);
      $field_input = ob_get_clean();

      include('views/user_input.php');

    }

    public function updateUserData($user_id = 0, $params = array()){

      if ( !current_user_can( 'edit_user', $user_id ) ){
        return false;
      }

      foreach ($params as $key_params => $value_params) {
        $field_slug = $value_params['field_slug'];
        $field_value = $_POST[$field_slug];
        update_user_meta( $user_id, $field_slug, $field_value );
      }

    }

  }
