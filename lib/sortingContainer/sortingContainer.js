var sortingContainer = (function($){

  return function (params) {

    var targetElement = params.targetElement;
    var postType = params.postType;
    var nonce = params.nonce;

    var render = {
      updateContainer: function(){
        return $('<h5 class="updateContainer">&nbsp;</h5>');
      },
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
            xhr.setRequestHeader( 'X-WP-Nonce', nonce );
          },
          complete: function(data){
            callback(index == data.responseJSON.custom_order)
          }
        })
      },
      updateContainerStatus: function(status){
        if(status){
          targetElement.find('.updateContainer').html('updated');
          setTimeout(function(){
            targetElement.find('.updateContainer').html('&nbsp;');
          }, 3000);
        } else {
          targetElement.find('.updateContainer').html('error');
          setTimeout(function(){
            targetElement.find('.updateContainer').html('&nbsp;');
          }, 3000);
        }
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
              set.updateContainerStatus(result);
            });

          })
        });
      },
    };

    var init = function(){

      get.postTypeData(postType, function(data){

        var updateContainer = render.updateContainer();
        targetElement.append(updateContainer);

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

})(jQuery);
