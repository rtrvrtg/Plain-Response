(function($){
	
	var Plain_Response_Behaviour = {
	  topFixed: function() {
	    var fixedItems = {};
	    
	    $('.top-fixed').each(function(i){
	    	if (!this.id) {
	    	  this.id = 'top-fixed-' + i;
	    	}
	    	fixedItems[this.id] = this.offsetTop;
	    });
	    
	    $(window).scroll(function(){
	    });
	  }
	};
	
	$(document).ready(function(){
	  
	  for (var i in Plain_Response_Behaviour) {
	    Plain_Response_Behaviour[i]();
	  }
	  
	});
	
})(jQuery);