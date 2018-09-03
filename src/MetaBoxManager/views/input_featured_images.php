<p><a class="upload-custom-img" href="<?php echo esc_url( get_upload_iframe_src( 'image', $post_id ) ); ?>">Add featured images</a></p>
<ul class="custom-img-container <?php echo $field_slug; ?>"></ul>
<input type="hidden" class="hidden_meta" id="<?php echo $field_slug; ?>" name="<?php echo $field_slug; ?>" value='<?php echo $field_value; ?>' >

<?php if ($include_lib): ?>
  <script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/html5sortable/html5sortable.min.js'; ?>"></script>
  <script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/wpMediaManager/wpMediaManager.js'; ?>"></script>
<?php endif; ?>

<script>

  (function($){

    $(document).ready(function(){

      wpMediaManager({
        metaBox: $('#<?php echo $field_slug; ?>.postbox'),
        inputField: $('input#<?php echo $field_slug; ?>'),
        listingField: $('ul.custom-img-container.<?php echo $field_slug; ?>')
      });

    })

  })(jQuery);

</script>

<style>
  .imageItem{
    position: relative;
  }

  .imageItem:hover{
    cursor: move;
  }

  .imageItem:hover .delete{
    display: block;
  }

  .imageItem .delete{
    box-sizing: border-box;
    position: absolute;
    top: 0px;
    left: 0px;
    width: 100%;
    display: none;
    text-align: center;
    padding: 4px;
    background-color: #fb6666;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
  }

  .imageItem .delete:hover{
    cursor: pointer;
    background-color: #af2c2c;
  }

  .imageItem .content{
    height: 140px;
  }
</style>