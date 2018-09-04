<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputDate extends InputBuilder{

    public function render($include_lib = true){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      include('views/input_date.php');
    }

  }