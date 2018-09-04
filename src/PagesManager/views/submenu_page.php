<script src="<?php echo plugin_dir_url(__FILE__) . '../../../lib/html5sortable/html5sortable.min.js'; ?>"></script>

<h1>Sort</h1>
<div class="sortingContainer <?php echo $post_type_schema['plural_slug']; ?>"></div>

<script>

  (function($){

  	function sortingContainer(params) {

  		var targetElement = params.targetElement;
  		var postType = params.postType;

  		var render = {
  			sortableContainer: function(){
  				return $('<ul class="sortableContainer" />');
  			},
  			titleItem: function(data){
  				return $('<li class="titleItem" data-id="' + data.id + '"><h3>' + data.title.rendered + '</h3></li>');
  			}
  		};

  		var get = {
  			postTypeData: function(postType, callback){
  				$.get('/?rest_route=/wp/v2/' + postType + '&per_page=100', function(data){
  					callback(data)
  				}, 'json');
  			}
  		};

      var set = {
        customOrder: function(id, index, callback){
          $.ajax({
            type: 'POST',
            url: '/?rest_route=/wp/v2/' + postType + '/' + id,
            data: {
              custom_order: index
            },
            dataType: 'json',
            beforeSend: function ( xhr ) {
              xhr.setRequestHeader( 'X-WP-Nonce', '<?php echo wp_create_nonce( "wp_rest" ); ?>' );
            },
            complete: function(data){
              callback(index == data.responseJSON.custom_order)
            }
          })
        }
      }

  		var bind = {
		    sortable: function(targetClass){
		      sortable(targetClass, {
		        forcePlaceholderSize: true
		      });
		      sortable(targetClass)[0].addEventListener('sortupdate', function(e) {
            targetElement.find('.titleItem').each(function(index){

              set.customOrder($(this).attr('data-id'), index, function(result){
              });

            })
		      });
		    },
  		};

  		var init = function(){

  			get.postTypeData(postType, function(data){

  				var sortableContainer = render.sortableContainer();
  				targetElement.append(sortableContainer);

          data = data.sort(function (a, b) {
            return a.custom_order.localeCompare( b.custom_order );
          });

  				for (var i = 0; i < data.length; i++) {
  					sortableContainer.append(render.titleItem(data[i]))
  				}

  				bind.sortable('.' + sortableContainer.attr('class').split(' ').join('.'))

  			});

  		};

  		init();
  	}

    $(document).ready(function(){

      sortingContainer({
      	targetElement: $('.<?php echo $post_type_schema['plural_slug']; ?>.sortingContainer'),
      	postType: '<?php echo $post_type_schema['plural_slug']; ?>'
      });

    });

  })(jQuery);

</script>

<style>
	.sortingContainer{
		padding-right: 20px;
	}
	.titleItem{
		padding: 16px 8px;
		background-color: white;
		margin-bottom: 8px;
	}
	.titleItem:hover{
		cursor: move;
		background-color: #DDD;
	}
	.titleItem *{
		margin: 0px;
	}
</style>