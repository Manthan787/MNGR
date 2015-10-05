jQuery(document).ready(function($) {

	// Declare window variable
	var this_youtube_window = top.tinymce.activeEditor;
	console.log(this_youtube_window)
	var preview_link = ''
	$('#message').hide()
	// Action buttons
	$('#youtube_cancel').click(function() {
		this_youtube_window.windowManager.close();
	});
	$('#youtube_insert').click(function() {

		// Get link from input box
		this_link = $('#youtube_url').val();

		// If no link.. alert user
		if(this_link == '') {
			alert('Please enter a "YouTube" URL');
			return false;
		}

		if(hasValidHttpFormat(this_link)) {
			this_link = this_link.replace('http:','');
			this_link = this_link.replace('watch?v=','embed/');

			// Get user defined width and height
			this_width = $('#youtube_width').val();
			this_height = $('#youtube_height').val();

			// Assemble final link
			final_link = '<iframe width="'+this_width+'" height="'+this_height+'" src="'+this_link+'" frameborder="0" allowfullscreen></iframe>';

			this_youtube_window.execCommand('mceInsertContent', !1, final_link);  // Insert content into editor
			this_youtube_window.windowManager.close();  // Close window
		}
		else {
			$('#pre_preview_img').show()
			$('#message').show()
			$('#message').html('Not a valid youtube url format. Please ensure the "YouTube URL" field contains a valid link.<br /><br />Acceptable link format:<br /><b>http://www.youtube.com/watch?v=4vTyEy7Dn70</b>');
		}
	});

	// Subscribe to the input event to check if the link is valid. If valid, preview! Else, show message.
	$('#youtube_url').on('input' ,function() {
		preview_link = $(this).val();
		// If link contains valid http format
		if (hasValidHttpFormat(preview_link)) {
			preview_link = preview_link.replace('http:','');
			preview_link = preview_link.replace('watch?v=','embed/');
			$('#pre_preview_img').hide()
			$('#message').hide()
			$('#video_preview').html('<iframe width="345" height="242" src="'+preview_link+'" frameborder="0" allowfullscreen></iframe>');
		}
	});

	function hasValidHttpFormat(link) {
		if(link.indexOf("http://www.youtube.com/watch?v=") >= 0 || link.indexOf("https://www.youtube.com/watch?v=") >= 0)
			return true

		return false
	}

});
