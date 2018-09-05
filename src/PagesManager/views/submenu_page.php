<script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/html5sortable/html5sortable.min.js'; ?>"></script>
<script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/sortingContainer/sortingContainer.js'; ?>"></script>

<h1>Sort</h1>
<div class="sortingContainer <?php echo $post_type_schema['plural_slug']; ?>"></div>

<script>

  (function($){

    $(document).ready(function(){

      sortingContainer({
      	targetElement: $('.<?php echo $post_type_schema['plural_slug']; ?>.sortingContainer'),
      	postType: '<?php echo $post_type_schema['plural_slug']; ?>',
        nonce: '<?php echo wp_create_nonce( "wp_rest" ); ?>'
      });

    });

  })(jQuery);

</script>

<style>

	.sortingContainer{
		padding-right: 20px;
	}

	.sortingContainer .titleItem{
		padding: 16px 8px;
		background-color: white;
		margin-bottom: 8px;
	}

	.sortingContainer .titleItem:hover{
		cursor: move;
		background-color: #DDD;
	}

	.sortingContainer .titleItem *{
		margin: 0px;
	}

</style>