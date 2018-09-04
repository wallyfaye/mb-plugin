<?php

  namespace ModelBuilder\MetaBoxManager;

  class InputBuilder{

    public function __construct($post_data = array(), $meta_box_data = array()){
      $this->post_data = $post_data;
      $this->meta_box_data = $meta_box_data;
      if(get_class($post_data) == 'WP_User'){
        $this->custom_fields = get_user_meta($this->post_data->ID);
      } else {
        $this->custom_fields = get_post_custom($this->post_data->ID);
      }
    }
  }