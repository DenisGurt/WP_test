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
	});
})(jQuery);