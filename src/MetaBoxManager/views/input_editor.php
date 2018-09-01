<input 
  type="hidden" 
  id="<?php echo $field_slug; ?>" 
  name="<?php echo $field_slug; ?>" 
  value="<?php echo $field_value; ?>" 
/>
<?php 
  wp_editor( 
    $field_value, 
    '_' . $field_slug,
    array(
      'textarea_rows' => 8,
      'tabindex' => 4,
      'tinymce' => array(
        'theme_advanced_buttons1' => 'bold, italic, ul, min_size, max_size',
        'theme_advanced_buttons2' => '',
        'theme_advanced_buttons3' => '',
        'theme_advanced_buttons4' => '',
      ),
    )
  ); 
?>
<script>
  jQuery(document).ready(function (argument) {
    setTimeout(function () {
      for (var i = 0; i < tinymce.editors.length; i++) {
        if(tinymce.editors[i].id == '<?php echo "_" . $field_slug; ?>'){
          tinymce.get(tinymce.editors[i].id).on("change", function() { 
            jQuery('input#<?php echo $field_slug; ?>').val(tinyMCE.activeEditor.getContent());
          });
        }
      }
    })
  })
</script>