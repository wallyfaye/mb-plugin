<input 
  id="<?php echo $field_slug; ?>" 
  name="<?php echo $field_slug; ?>" 
  class="<?php echo $field_slug; ?> flatpickr flatpickr-input active" 
  type="text" 
  placeholder="Select Date.." 
  readonly="readonly"
  value="<?php echo $field_value; ?>"
/>

<?php if ($include_lib): ?>
  <script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/flatpickr/flatpickr.min.js'; ?>"></script>
  <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__) . '../../../lib/flatpickr/flatpickr.min.css'; ?>">
<?php endif; ?>

<script>
  (function($){
    $(document).ready(function (argument) {
      $(".<?php echo $field_slug; ?>").flatpickr({
        enableTime: true,
        dateFormat: "m-d-Y H:i",
      });
    });
  })(jQuery);
</script>