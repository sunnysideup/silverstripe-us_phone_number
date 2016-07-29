

(function($) {
	$.entwine(
		'ss.usphonenumber',
		function($){
			$('input.usphonenumber').entwine(
				{

					formatPhoneNumber: function() {
						var el = $(this);
						if(jQuery(el).is(':visible')){
							var val = jQuery(el).val();
							val = val.replace(/\D/g,'');
							// do validation tests
							if (this.validateNumber()) {
								// (123) 335-6789
								val = val.replace(/(\d{3})(\d{3})(\d{4})/,'($1) $2-$3');
								jQuery(el).val(val);
							}
							else if(val.length > 0) {
								jQuery(el).focus();
							}
						}
					},

					/**
					 * adds class and return true (valid)
					 * or false (invalid)
					 * @param el
					 * @return boolean
					 *
					 */
					validateNumber: function(){
						var el = $(this);
						var val = jQuery(el).val();
						val = val.replace(/\D/g,'');
						// do validation tests
						if (val.length == 10 || val.length == 0) {
							jQuery(el).removeClass("usphonenumbererror");
							jQuery(el).addClass("usphonenumberok");
							return true;
						}
						else {
							jQuery(el).addClass("usphonenumbererror");
							jQuery(el).removeClass("usphonenumberok");
							return false;
						}
					},

					onadd: function() {
						this.formatPhoneNumber();
					},
					onpropertychange: function() {
						this.validateNumber();
					},
					onchange: function() {
						this.formatPhoneNumber();
					},
					onclick: function() {
						this.validateNumber();
					},
					onkeyup: function() {
						this.validateNumber();
					},
					oninput: function() {
						this.validateNumber();
					},
					onpaste: function() {
						this.validateNumber();
					}
				}
			);
		}
	);
}(jQuery));
