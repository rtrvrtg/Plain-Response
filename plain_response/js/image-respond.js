
(function($){
	
	var Plain_Respond_Image_Response = {
	  selectors: 'img.full, img.half, img.quarter, img.third, img.twothirds, img.threequarters',
	  max: 1600,
	  steps: {
	    400: 'quarter',
	    512: 'third',
	    800: 'half',
	    1024: 'twothirds',
	    1200: 'threequarters',
	    1600: 'full'
	  },
	  current: window.innerWidth
    };
	
	var Plain_Respond_Image_Responder = function(image) {
  
	  var params = {
	    image: image,
	    width: image.width,
	    step: null,
	  };
	  
	  var priv = {
	    init: function() {
	      if (!params.image.getAttribute('originalsrc')) {
	        params.image.setAttribute('originalsrc', params.image.src);
	      }
	      pub.update();
	    },
	    
	    joinUrl: function(scheme, style, path) {
	      return Drupal.settings.plain_response[scheme + '_files'] + 'styles/' + [
		    'plain_response_' + style, scheme, path
		  ].join('/');
	    },
	    
	    url: function(style) {
	      var parts = params.image.getAttribute('originalsrc').split('://'),
	      scheme = '',
	      path = '';
	      
	      if (parts.length > 1) {
	        scheme = parts.shift(),
	        path = parts.join('://');
	      }
	      else {
	        path = parts[0];
	      }
	      
	      var newUrl = '';
	      
	      if (scheme == 'public' || scheme == 'private') {	      
			newUrl = this.joinUrl(scheme, style, path);
	      }
	      else {
	        if (scheme != '') {
	          path = scheme + '://' + path;
	        }
	        return path;
	        
	        /*
	        We might be able to use this if more stream wrappers are made available to 
	        cover files in themes, modules, etc.
	        http://drupal.org/project/system_stream_wrapper can provide what we need.
	        
	        var testPath = path.replace(Drupal.settings.plain_response.base_url, '');
	        
	        if (testPath != path) {
	          path = testPath;
	          scheme = Drupal.settings.plain_response.default_scheme;
	          newUrl = this.joinUrl(scheme, style, path);
	        }
	        else {
	          // External file. not going to mess with this.
	          return path;
	        }
	        */
	      }
	      
	      return newUrl;
	    }
	  };
	  
	  var pub = {
	    update: function(){
	      var current = params.step;
	      for (var step in Plain_Respond_Image_Response.steps) {
	        if (step > Plain_Respond_Image_Response.current) {
	          if (!current) {
	            current = step;
	          }
	          break;
	        }
	        else {
	          current = step;
	        }
	      }
	      
	      // load image
	      var style = Plain_Respond_Image_Response.steps[current],
	      url = priv.url(style);
	      
	      if (url != params.image.src) {
	        params.image.src = url;
	      }
	    }
	  };
	  
	  priv.init();
	  
	  return pub;
	  
	};
	
	$(document).ready(function(){
	  
	  var Responders = [];
	  
	  $(Plain_Respond_Image_Response.selectors).each(function(){
	    var r = new Plain_Respond_Image_Responder(this);
	    Responders.push(r);
	  });
	  
	  $(window).resize(function(){
	    Plain_Respond_Image_Response.current = window.innerWidth;
	    $.each(Responders, function(){
	      this.update();
	    });
	  });
	});
	
})(jQuery);