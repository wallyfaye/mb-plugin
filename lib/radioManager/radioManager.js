function radioManager(params){
  var targetElement = (typeof params.targetElement !== 'undefined') ? params.targetElement : null;
  var postType = (typeof params.postType !== 'undefined') ? params.postType : null;
  var fieldSlug = (typeof params.fieldSlug !== 'undefined') ? params.fieldSlug : null;
  var savedValue = (typeof params.savedValue !== 'undefined') ? params.savedValue : [];
  var fieldData = (typeof params.fieldData !== 'undefined') ? params.fieldData : [];

  var render = {
    element: function(params){
      var title = (typeof params.title === 'undefined') ? '' : params.title;
      var id = (typeof params.id === 'undefined') ? '' : params.id;
      var isSet = id == savedValue;

      var inputObject = $('<input type="radio" />');
      inputObject.attr({
        value: id,
        name: fieldSlug,
        checked: isSet
      });

      inputObject.html(title);

      targetElement.append(inputObject);

      var labelObject = $('<label />');
      labelObject.html(title)
      
      targetElement.append(labelObject);

      targetElement.append('<br />');

    }
  }

  var get = {
    postTypeData: function(postType, callback){
      $.get('/?rest_route=/wp/v2/' + postType + '&per_page=100', function(data){
        callback(data)
      }, 'json');
    },
    data: function(callback){
      if(fieldData.length > 0){
          callback(fieldData)
      } else {
        get.postTypeData(params.postType, function(postTypeData){
          var returnData = [];
          for (var i = 0; i < postTypeData.length; i++) {
            returnData.push({
              title: postTypeData[i].title.rendered,
              id: postTypeData[i].id
            })
          }
          callback(returnData)
        });
      }

    }
  };

  var init = function(){
    get.data(function(data){
      render.element({
        title: '',
        id: ''
      });
      for (var i = 0; i < data.length; i++) {
        render.element({
          title: data[i].title,
          id: data[i].id
        });
      }
    });
  };

  if(targetElement != null && postType != null){
    init();
  }
}

