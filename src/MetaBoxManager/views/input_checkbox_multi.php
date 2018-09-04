<div class="checkbox_container <?php echo $field_slug; ?>"></div>

<?php if ($include_lib): ?>
  <script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/checkboxMultiManager/checkboxMultiManager.js'; ?>"></script>
<?php endif; ?>

<script>

  (function($){

    $(document).ready(function(){

      checkboxMultiManager({
        targetElement: $(".checkbox_container.<?php echo $field_slug; ?>"),
        postType: '<?php echo $field_post_type; ?>',
        fieldSlug: '<?php echo $field_slug; ?>',
        savedValue: JSON.parse('<?php echo $saved_value; ?>'),
        fieldData: JSON.parse('<?php echo json_encode($field_function); ?>')
      });

    })

  })(jQuery);

</script>