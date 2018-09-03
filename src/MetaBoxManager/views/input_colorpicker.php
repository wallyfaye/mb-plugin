<input 
  id="<?php echo $field_slug; ?>" 
  name="<?php echo $field_slug; ?>" 
  class="<?php echo $field_slug; ?>" 
  type="text" 
  value="<?php echo $field_value; ?>"
/>

<?php if ($include_lib): ?>
  <script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/spectrum/spectrum.min.js'; ?>"></script>
  <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../../../lib/spectrum/spectrum.min.css'; ?>">
<?php endif; ?>

<script>
  (function($){
    $(document).ready(function (argument) {
      $(".<?php echo $field_slug; ?>").spectrum({
        showAlpha: true,
        preferredFormat: "rgb",
        showInput: true,
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        palette: [<?php echo '"' . implode('","', $field_colors) . '"'; ?>],
        localStorageKey: "spectrum.admin<?php echo $field_slug; ?>",
        change: function(color){
          $(this).val(color.toHexString());
        }
      });
    });
  })(jQuery);
</script>