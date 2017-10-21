<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Contrast Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html contrast1.png "Contrast(10)"</td>
 * <td>@image html contrast2.png "Contrast(-10)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxContrast extends wlGwImageFx {

    /**
     * @var int contrast level (interval: [-255, 255])
     */
    private $_amount;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Contrast Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $amount contrast level (interval: [-255, 255])
     */    
    public function __construct($source = null, $amount = 0) {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams($amount);
    }

    public function setParamsByArray($params) {
        $amount = wlGwUtils::getArrayValue($params, array("amount", 0));
        $this->setParams($amount);
    }

    /**
     * Sets the Fx parameters.
     * @param int $amount contrast level (interval: [-255, 255])
     * @return void 
     */
    public function setParams($amount = 0) {
        if (is_array($amount)) {
            $this->setParamsByArray($amount);
            return;
        }

        wlGwUtils::limitByInterval($amount, -255, 255);
        $this->_amount = $amount;
    }

    protected function mainRender() {
        if ($this->_amount == 0)
            return $this->_sourceImage->bitmap;

        if (function_exists("imagefilter")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            imagefilter($bitmap, IMG_FILTER_CONTRAST, -1 * $this->_amount);
            return $bitmap;
        }
        return null;
    }

    protected function getParamsInfo() {
        return array(
            "amount" => array(
                "type" => "int",
                "range" => array("from" => -255, "to" => 255),
                "description" => "Contrast level",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>