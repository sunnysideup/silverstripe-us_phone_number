<?php
/**
 * Represents a decimal field from 0-1 containing a percentage value.
 *
 * Example instantiation in {@link DataObject::$db}:
 * <code>
 * static $db = array(
 * 	"SuccessRatio" => "Percentage",
 * 	"ReallyAccurate" => "Percentage(6)",
 * );
 * </code>
 *
 * @package framework
 * @subpackage model
 */
class USPhoneNumber extends Varchar {


    /**
     * @return string e.g. (555) 555-5555
     */
    public function Nice() {
        $val = $this->cleanInput($this->value);
        return "(".substr($val, 0, 3).") ".substr($val, 3, 3)."-".substr($val,6);
    }

    /*
     * @param DataObject $dataObject
     */
    public function saveInto($dataObject) {
        parent::saveInto($dataObject);
        $fieldName = $this->name;
        $dataObject->$fieldName = $this->cleanInput($dataObject->$fieldName);

    }

    function prepValueForDB($value){
        $value = $this->cleanInput($value);
        return parent::prepValueForDB($value);
    }

    /**
     * @param string $val
     *
     * @return string
     */
    protected function cleanInput($val) {
        return preg_replace("/[^0-9]/", "", $val);
    }


    /**
     * (non-PHPdoc)
     * @see DBField::scaffoldFormField()
     */
    public function scaffoldFormField($title = null, $params = null) {
        if(!$this->nullifyEmpty) {
            // Allow the user to select if it's null instead of automatically assuming empty string is
            return new NullableField(new USPhoneNumberField($this->name, $title));
        } else {
            // Automatically determine null (empty string)
            return new USPhoneNumberField($this->name, $title);
        }
    }

}
