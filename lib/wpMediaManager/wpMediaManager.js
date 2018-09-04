function wpMediaManager(params){

  var metaBox = (typeof params.metaBox === 'undefined') ? null : params.metaBox;
  var inputField = (typeof params.inputField === 'undefined') ? null : params.inputField;
  var listingField = (typeof params.listingField === 'undefined') ? null : params.listingField;
  var popupTitle = (typeof params.popupTitle === 'undefined') ? 'Select Featured Images' : params.popupTitle;
  var popupButtonText = (typeof params.popupButtonText === 'undefined') ? 'Set Featured Images' : params.popupButtonText;
  var frame;

  var render = {
    popup: function(){
      frame = wp.media({
        title: popupTitle,
        button: {
          text: popupButtonText
        },
        multiple: true
      });
    },
    imageListing: function(imageIds){
      listingField.html('');
      for(var i = 0; i < imageIds.length; i++){
        var imageItem = render.imageItem(imageIds[i]);
        listingField.append(imageItem);
      }
      get.imagesData(imageIds, function(imagesData){
        for (var i = 0; i < imagesData.length; i++) {
          var imageData = imagesData[i]
          listingField.find('[data-id="' + imageData.id + '"] .content').css({
            'background-image': 'url(' + imageData.media_details.sizes.medium.source_url + ')'
          })
        }
      });
    },
    imageItem: function(imageId){
      var imageItem = $('<li class="imageItem" />');
      var deleteItem = $('<div class="delete">delete</div>');
      var itemContent = $('<div class="content"></div>');
      imageItem.attr('data-id', imageId);
      imageItem.append(deleteItem);
      imageItem.append(itemContent);
      return imageItem;
    }
  };

  var set = {
    inputValue: function(imageIdArray){
      var jsonString = JSON.stringify(imageIdArray);
      inputField.val(jsonString);
    },
    selectedImages: function(){          
      var selection = frame.state().get('selection');
      $.each(get.inputValue(), function (index, val) {
        selection.add(wp.media.attachment(val))
      });
    }
  };

  var get = {
    imagesData: function(imageIds, callback){
      $.get('/?rest_route=/wp/v2/media&per_page=100&include=' + imageIds.join([',']), function(data){
        callback(data)
      }, 'json')
    },
    inputValue: function(){
      var parsedValue = '';
      try {
        parsedValue = JSON.parse(inputField.val());
      } catch(e) {
      }
      return parsedValue;
    },
    listingIds: function(){
      var listingIds = [];
      listingField.children().each(function(){
        listingIds.push($(this).attr('data-id'));
      });
      return listingIds;
    }
  };

  var bind = {
    popupOpened: function(){
      frame.on( 'open', function() {
        set.selectedImages();
      });
    },
    popupLauncher: function(){
      metaBox.find('.upload-custom-img').on( 'click', function( event ){
        event.preventDefault();
        frame.open();
      });
    },
    imageSelect: function(){
      frame.on( 'select', function() {
        var these_attachments = frame.state().get('selection').toJSON();
        var imageIds = [];
        for (var i = 0; i < these_attachments.length; i++) {
          imageIds.push(these_attachments[i].id);
        }
        set.inputValue(imageIds);
        render.imageListing(get.inputValue());
        bind.sortable();
        bind.delete();
      });
    },
    sortable: function(){
      var targetClass = '.' + listingField.attr('class').split(' ').join('.');
      sortable(targetClass, {
        forcePlaceholderSize: true
      });
      sortable(targetClass)[0].addEventListener('sortupdate', function(e) {
        set.inputValue(get.listingIds());
      });
    },
    delete: function(){
      listingField.find('.delete').on('click', function(){
        $(this).parents('.imageItem').remove();
        set.inputValue(get.listingIds());
      })
    }
  };

  var init = function(){
    render.popup();
    bind.popupLauncher();
    bind.imageSelect();
    bind.popupOpened();
    if(get.inputValue() != ''){
      render.imageListing(get.inputValue());
      bind.sortable();
      bind.delete();
    }
  }

  if(metaBox != null && inputField != null){
    init();
  }

}