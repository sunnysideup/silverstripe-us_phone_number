<?php

class USPhoneNumberField extends TextField
{

    /**
     * Includes the JavaScript neccesary for this field to work using the {@link Requirements} system.
     */
    public static function include_js()
    {
        Requirements::javascript(FRAMEWORK_DIR.'/thirdparty/jquery/jquery.js');
        Requirements::javascript('us_phone_number/javascript/USPhoneNumber.js');
        Requirements::themedCSS('USPhoneNumber', 'us_phone_number');
    }

    public function Field($properties = array())
    {
        $this->addExtraClass('text');
        $return = parent::Field($properties = array());
        self::include_js();
        return $return;
    }
}
