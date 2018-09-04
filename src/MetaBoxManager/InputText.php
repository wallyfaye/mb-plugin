<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputText extends InputBuilder{

    public function render(){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      include('views/input_text.php');
    }

  }