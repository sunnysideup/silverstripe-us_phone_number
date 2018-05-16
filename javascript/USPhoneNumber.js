
if(jQuery('.usphonenumber').length) {
    jQuery(document).ready(
        function(){
            USPhoneField.init();
            USPhoneField.activateFieldListeners();
        }
    );
}

var USPhoneField = {

    init: function() {
        jQuery('input.usphonenumber').each(
            function(i, el){
                var el = jQuery(this);
                USPhoneField.formatPhoneNumber(el);
            }
        );
    },

    activateFieldListeners: function(){
        jQuery('input.usphonenumber').on(
            'add change',
            function(){
                var el = jQuery(this);
                USPhoneField.formatPhoneNumber(el);
            }
        );

        jQuery('input.usphonenumber').on(
            'propertychange click keyup input paste',
            function(){
                var el = jQuery(this);
                USPhoneField.formatPhoneNumber(el);
            }
        );
    },

    formatPhoneNumber: function(el) {
        if(el.is(':visible')){
            var val = jQuery(el).val();
            val = val.replace(/\D/g,'');
            // do validation tests
            if (USPhoneField.validateNumber(el)) {
                val = val.replace(/(\d{3})(\d{3})(\d{4})/,'($1) $2-$3');
            }
            else if(val.length > 0) {
                el.focus();
                // (123) 335-6789
                if(val.length > 5){
                    val = val.replace(/(\d{3})(\d{3})/,'($1) $2-');
                }
                else if(val.length > 2){
                    val = val.replace(/(\d{3})/,'($1) ');
                }
                el.val(val);
            }
            el.val(val);
        }
    },

    /**
     * adds class and return true (valid)
     * or false (invalid)
     * @param el
     * @return boolean
     *
     */
    validateNumber: function(el){
        var val = el.val();
        val = val.replace(/\D/g,'');
        // do validation tests
        if (val.length == 10 || val.length == 0) {
            el.removeClass("usphonenumbererror");
            el.addClass("usphonenumberok");
            return true;
        }
        else {
            el.addClass("usphonenumbererror");
            el.removeClass("usphonenumberok");
            return false;
        }
    }
}
