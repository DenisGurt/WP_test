( function($) {
	$(document).ready(function(){
	    var dateFormat = "dd/mm/yy";
	    var from = $( "#acf-start_date input.input" )
	        .on( "change", function() {
	        	console.log(getDate( this ));
				to.datepicker( "option", "minDate", getDate( this ) );
	        });

	    var to = $( "#acf-end_date input.input" )
			.on( "change", function() {
				from.datepicker( "option", "maxDate", getDate( this ) );
			});
	 
	    function getDate( element ) {
			var date;
			try {
				date = $.datepicker.parseDate( dateFormat, element.value );
			} catch( error ) {
				date = null;
			}

			return date;
		}

	    $('#upload_logo_button').click(function() {
	        tb_show('Upload a logo', 'media-upload.php?referer=wptuts-settings&type=image&TB_iframe=true&post_id=0', false);
	        return false;
	    });
	    window.send_to_editor = function(html) {
		    var image_url = $(html).attr('src');
		    console.log(image_url);
		    $('#logo_url').val(image_url);
		    tb_remove();

		    $('#upload_logo_preview img').attr('src',image_url);
 
    		$('#submit_options_form').trigger('click');
		}

		// Add Color Picker to all inputs that have 'color-field' class
		$('.color-picker').wpColorPicker();
	});
})(jQuery);