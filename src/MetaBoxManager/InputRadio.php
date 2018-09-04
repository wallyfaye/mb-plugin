<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputRadio extends InputBuilder{

    public function render($include_lib = true){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      $field_post_type = isset($this->meta_box_data['field_post_type']) ? $this->meta_box_data['field_post_type'] : '';
      $saved_value = isset($this->custom_fields[$field_slug]) === false || $this->custom_fields[$field_slug][0] == '' ? '' : $this->custom_fields[$field_slug][0];
      include('views/input_radio.php');
    }

  }