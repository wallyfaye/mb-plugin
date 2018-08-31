<?php

  namespace Boilerplate\MetaBoxManager;

  class InputText{

    public function __construct($post_data = array(), $meta_box_data = array()){
      $this->post_data = $post_data;
      $this->meta_box_data = $meta_box_data;
      $this->custom_fields = get_post_custom($this->post_data->ID);
    }

    public function render(){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      include('views/input_text.php');
    }

  }