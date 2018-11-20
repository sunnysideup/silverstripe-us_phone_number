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
class USPhoneNumber extends Varchar
{


    /**
     * @return string e.g. (555) 555-5555
     */
    public function Nice()
    {
        $val = $this->cleanInput($this->value);

        return "(".substr($val, 0, 3).") ".substr($val, 3, 3)."-".substr($val, 6);
    }

    /**
     *
     * @param boolean $includeIntprefix (includes +1 at the beginning of the number)
     *
     * @return string
     */
    public function TelLink($includeIntprefix = false)
    {
        $str = 'tel:' . $this->initializePhoneString($includeIntprefix);
        return $str . $this->removeNonNumbericChars($this->value);
    }

    /**
     * @param boolean $includeIntprefix (includes +1 at the beginning of the number)
     *
     * @return string
     */
    public function CallToLink($includeIntprefix = false)
    {
        $str = 'callto:' . $this->initializePhoneString($includeIntprefix);
        return $str . $this->removeNonNumbericChars($this->value);
    }

    /**
     * @param boolean $includeIntprefix (includes +1 at the beginning of the number)
     *
     * @return string
     */
    public function initializePhoneString($includeIntprefix){
        $str = '';
        if($includeIntprefix){
            $str = '+1';
        }
        return $str;
    }

    /**
     * @param string $str
     *
     * @return string
     */
    public function removeNonNumbericChars($str){
        return preg_replace('/[^0-9]/', '', $str);
    }

    /*
     * @param DataObject $dataObject
     */
    public function saveInto($dataObject)
    {
        parent::saveInto($dataObject);
        $fieldName = $this->name;
        $dataObject->$fieldName = $this->cleanInput($dataObject->$fieldName);
    }

    public function prepValueForDB($value)
    {
        $value = $this->cleanInput($value);
        return parent::prepValueForDB($value);
    }

    /**
     * @param string $val
     *
     * @return string
     */
    protected function cleanInput($val)
    {
        return preg_replace("/[^0-9]/", "", $val);
    }


    /**
     * (non-PHPdoc)
     * @see DBField::scaffoldFormField()
     */
    public function scaffoldFormField($title = null, $params = null)
    {
        if (!$this->nullifyEmpty) {
            // Allow the user to select if it's null instead of automatically assuming empty string is
            return new NullableField(new USPhoneNumberField($this->name, $title));
        } else {
            // Automatically determine null (empty string)
            return new USPhoneNumberField($this->name, $title);
        }
    }
}
