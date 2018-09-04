function selectManager(params){
  var targetElement = (typeof params.targetElement !== 'undefined') ? params.targetElement : null;
  var postType = (typeof params.postType !== 'undefined') ? params.postType : null;
  var fieldSlug = (typeof params.fieldSlug !== 'undefined') ? params.fieldSlug : null;
  var savedValue = (typeof params.savedValue !== 'undefined') ? params.savedValue : [];

  var render = {
    checkbox: function(params){
      var title = (typeof params.title === 'undefined') ? '' : params.title;
      var id = (typeof params.id === 'undefined') ? '' : params.id;
      var isSet = id == savedValue;

      var inputObject = $('<option />');
      inputObject.attr({
        value: id,
        selected: isSet
      });

      inputObject.html(title);

      targetElement.append(inputObject);
    }
  }

  var get = {
    postTypeData: function(postType, callback){
      $.get('/?rest_route=/wp/v2/' + postType + '&per_page=100', function(data){
        callback(data)
      }, 'json');
    }
  };

  var init = function(){
    get.postTypeData(params.postType, function(postTypeData){
      render.checkbox({
        title: '',
        id: ''
      });
      for (var i = 0; i < postTypeData.length; i++) {
        render.checkbox({
          title: postTypeData[i].title.rendered,
          id: postTypeData[i].id
        });
      }
    });
  };

  if(targetElement != null && postType != null){
    init();
  }
}

