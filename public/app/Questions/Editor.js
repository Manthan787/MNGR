(function(){
    app = angular.module('Questions');

    app.factory('Editor', function() {
      return {
        init: function(setup) {
            return tinymce.init({
    					selector: '#question',
    					menubar: false,
    					plugins: [
    			        "advlist autolink lists link image charmap print preview anchor",
    			        "searchreplace visualblocks code fullscreen",
    			        "insertdatetime media table contextmenu paste youtube"
    			    ],
        			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image youtube",
    					file_browser_callback: function(field_name, url, type, win) {
                if(type=='image') $('#my_form input').click();
            	},
    					setup: setup
    				})
    			}
        };
    })
})()
