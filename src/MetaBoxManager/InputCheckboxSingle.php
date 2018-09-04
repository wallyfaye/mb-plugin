<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputCheckboxSingle extends InputBuilder{

   public function render(){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      $field_text = isset($this->meta_box_data['field_text']) ? $this->meta_box_data['field_text'] : '';
      include('views/input_checkbox_single.php');
    }

  }