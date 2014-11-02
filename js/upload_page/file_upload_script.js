jQuery(function(){
	
    jQuery( 'body' ).on( 'click' , '#drop a' , function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        jQuery(this).parent().find('input[name="videolocation"]').click();
    });
	
	function initialize_file_upload_form() {
	
		// Initialize the jQuery File Upload plugin
		jQuery('#youtube-plus-pro-upload-form').fileupload({
					
			progressInterval: 10,
			
			maxChunkSize: local_data.chunk_max_size , // 10 MB
		
			// This element will accept file drag/drop uploading
			dropZone: jQuery('#drop'),

			// This function is called when a file is added to the queue;
			// either via the browse button, or via drag/drop:
			add: function (e, data) {
							
				if (!(/\.(mov|mpeg4|mp4|avi|wmv|mpegps|3gpp|webm)$/i).test(data.files[0].name)) {
					// if an unacceptable file type was dropped in
					
						if ( jQuery('#acceptable_filetypes').is(':visible') ) {
							return;
						} else {	
							jQuery('#drop').after('<div id="acceptable_filetypes" style="display:none;"><h2 style="color:red;">Error - Please use an acceptable file type :</h2><ul><li>.MOV</li><li>.MPEG4</li><li>.MP4</li><li>.AVI</li><li>.WMV</li><li>.MPEGPS</li><li>.FLV</li><li>.3GPP</li><li>.WebM</li></ul></div>');
							jQuery('#acceptable_filetypes').fadeIn();
						}	
					return;
					
				} else {
					// if an acceptable file type was used
					jQuery('#acceptable_filetypes').remove();
				}
							
							
				var file_name = data.files[0].name;
				var video_title = file_name.split('.')[0];
				
				jQuery('#drop').fadeOut('fast', function() {
					// create a submit button
					jQuery('#video-submission-button').html('<input type="submit" value="Upload" class="button-primary submit-video-button" onclick="return false;">');
					jQuery('#video-title').val(video_title);
					jQuery('#video-title-div').fadeIn();
					jQuery('#video-description-div').fadeIn();
					jQuery('.video-upload-advanced-settings-toggle').fadeIn();
					jQuery('#video-submission-button').fadeIn();
				});

				
				jQuery("#youtube-plus-pro-upload-form").undelegate(".submit-video-button","click").delegate(".submit-video-button","click", function () {
					data.submit();
					// initialize the knob plugin
					jQuery('#upload_form_container').find('#progress_container').fadeIn().find('input').knob({"readOnly":true,'inputColor':'#818181','font':'"Open Sans"'}).trigger(
						'configure',
						{
							'fgColor' : '#66CC66',
							'angleOffset' : '-125'
						}
					);
					return false;
				});
				
							
			},
			
			start: function(e, data) {
				// disable the input fields on form submission
				jQuery('#youtube-plus-pro-upload-form').fadeOut('fast');
			},

			fail:function(e, data){
				// Something has gone wrong!
				// data.context.addClass('error');
				console.log(data);
				jQuery('#progress_bar').hide();
				jQuery('#youtube-plus-pro-upload-form').fadeIn('fast').prepend('<div class="yt4wp-error-alert"><strong> Oh No!</strong> There was an error uploading content. Try again. If the error persists, please submit a ticket with the YouTube for WordPress <a href="http://www.youtubeforwordpress.com/support/submit-ticket/" target="_blank">Support</a> team.</div>');
			},
			
			done:function(e, data){	
				jQuery(document).find('.youTube_api_key_preloader').remove();
				if ( local_data.current_page == 'toplevel_page_youtube-for-wordpress' ) {		
					jQuery('#video_success_response').html('<h3>Content Successfuly Uploaded</h3><p>Your new content should now be viewable from within the <a style="margin-top:-6px;" class="button-secondary" href="?page=youtube-for-wordpress&amp;tab=youtube_plus_browse">browse</a> tab, but may be unavailable until it completes processing.</p><br /><a href="#" class="upload_another_video button-secondary">Upload Another</a>').show();
				} else {
					jQuery('#video_success_response').html('<h3>Content Successfuly Uploaded</h3><p>Your new content should now be viewable from within the <a style="margin-top:-6px;" class="button-secondary nav-tab" onclick=jQuery("a[alt=browse_user_content]").click(); alt="browse_user_content" href="#">browse</a> tab, but may be unavailable until it completes processing.</p><br /><a href="#" class="upload_another_video button-secondary">Upload Another</a>').show();
				}
			}

		});
		
	}
	
	initialize_file_upload_form();
	
		jQuery('#youtube-plus-pro-upload-form').bind('fileuploadprogress', function (e, data) {
			 
				// alert(data.loaded);
				// Calculate the completion percentage of the upload
				var progress = parseInt(data.loaded / data.total * 100, 10);
				
				// check the progress, and update
				// the color
				newColor = '';
				if( progress <= 40 ) {
					newColor = '#ff3232';
				} else if ( progress <= 75 ) {
					newColor = '#ffff67';
				} else {
					newColor = '#66CC66';
				}
				
				// Update the hidden input field and trigger a change
				// so that the jQuery knob plugin knows to update the dial
				jQuery('#upload_form_container').find('#progress_container').find('input').trigger('configure',{'fgColor':newColor});
				jQuery('#upload_form_container').find('#progress_container').find('input').val(progress).trigger('change');

				console.log('Progress : '+progress);
				console.log('Bitrate : '+data.bitrate);
				console.log('Color : '+newColor);
				
				if ( progress == 100 ) {
					setTimeout(function() {
						jQuery('#upload_form_container').find( '#progress_container' ).fadeOut('fast', function() {
							jQuery(this).after('<img class="youTube_api_key_preloader" src="'+localized_data.preloader_url+'" alt="preloader" >').delay(600).next().fadeTo('slow',1);
						});
					}, 1800);
				}
				
		});
	
    // Prevent the default action when a file is dropped on the window
    jQuery(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

	
	// upload another video button click
		// currently doesn't reset the upload form button, or remove disabled attr from buttons and inputs
	jQuery('#video_success_response').undelegate('.upload_another_video','click').delegate('.upload_another_video','click',function() {
		jQuery('#video_success_response').fadeOut('fast',function() {
			// reset the progress container
			jQuery('#upload_form_container').find('#progress_container').find('input').val('0').trigger('change');
			// hide+reset all of our fields
			jQuery('#video-title-div').hide();
			jQuery('#video-description-div').hide();
			jQuery('#video-details').val('');
			jQuery('input[value="public"]').prop('checked',true);
			jQuery('.advanced-settings').hide();
			jQuery('.video-upload-advanced-settings-toggle').hide();
			jQuery('#video-submission-button').hide();
			jQuery('#upload_form_container').find('#progress_container').hide();
			jQuery('input[name="video-tags"]').importTags('');
			jQuery('#video-category').find('option:first').attr('selected','selected');
			jQuery('select[name="video-playlist-setting"]').find('option:first').attr('selected','selected');
			// display the drop field again
			jQuery('#youtube-plus-pro-upload-form').slideDown('fast',function() {
				jQuery('#drop').fadeIn('fast');
			});
			
		});
		return false;
	});	
	
	
});