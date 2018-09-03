<input 
  type="checkbox" 
  name="<?php echo $field_slug; ?>" 
  id="<?php echo $field_slug; ?>" 
  value="Y" 
  <?php if($field_value == "Y"){echo "checked";} ?>
>
<label for="<?php echo $field_slug; ?>">
  <?php echo $field_text; ?>
</label>