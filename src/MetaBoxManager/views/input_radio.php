<div class="radio_container <?php echo $field_slug; ?>" name="<?php echo $field_slug; ?>"></div>

<?php if ($include_lib): ?>
  <script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/radioManager/radioManager.js'; ?>"></script>
<?php endif; ?>

<script>

  (function($){

    $(document).ready(function(){

      radioManager({
        targetElement: $(".radio_container.<?php echo $field_slug; ?>"),
        postType: '<?php echo $field_post_type; ?>',
        fieldSlug: '<?php echo $field_slug; ?>',
        savedValue: '<?php echo $saved_value; ?>',
        fieldData: JSON.parse('<?php echo json_encode($field_function); ?>')
      });

    })

  })(jQuery);

</script>