<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputFeaturedImages extends InputBuilder{

    public function render($include_lib = true){
      $field_slug = $this->meta_box_data['field_slug'];
      $field_value = isset($this->custom_fields[$field_slug]) ? $this->custom_fields[$field_slug][0] : '';
      $post_id = $this->post_data->ID;
      include('views/input_featured_images.php');
    }

  }