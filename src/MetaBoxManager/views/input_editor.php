<input 
  type="hidden" 
  id="<?php echo $field_slug; ?>" 
  name="<?php echo $field_slug; ?>" 
  value="<?php echo $field_value; ?>" 
/>

<?php 
  wp_editor( 
    $field_value, 
    '_' . $field_slug
  ); 
?>

<script>
  (function($){
    $(document).ready(function (argument) {
      setTimeout(function () {
        for (var i = 0; i < tinymce.editors.length; i++) {
          if(tinymce.editors[i].id == '<?php echo "_" . $field_slug; ?>'){
            tinymce.get(tinymce.editors[i].id).on("change", function() { 
              $('input#<?php echo $field_slug; ?>').val(tinyMCE.activeEditor.getContent());
            });
          }
        }
      })
    })
  })(jQuery);
</script>