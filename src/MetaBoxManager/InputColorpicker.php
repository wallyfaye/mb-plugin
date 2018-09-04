<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputColorpicker extends InputBuilder{

    public function render($include_lib = true){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      $field_colors = $this->meta_box_data['field_colors'];
      include('views/input_colorpicker.php');
    }

  }