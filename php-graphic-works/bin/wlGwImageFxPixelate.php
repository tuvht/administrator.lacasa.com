<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Pixelate Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html pixelate1.png "Pixelate(10, false)"</td>
 * <td>@image html pixelate2.png "Pixelate(10, true)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxPixelate extends wlGwImageFx {

    /**
     * @var int pixelation level (interval: [0, 255])
     */
    private $_amount;
    /**
     * @var bool specifies if blur should be applied after pixelation
     */
    private $_blur;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Pixelate Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $amount pixelation level (interval: [0, 255])
     * @param bool $blur specifies if blur should be applied after pixelation
     */
    public function __construct($source = null, $amount = 0, $blur = false) {
        parent::__construct($source);
        $this->_phpVersion = "5.3.0";
        $this->setParams($amount, $blur);
    }

    public function setParamsByArray($params) {
        $amount = wlGwUtils::getArrayValue($params, array("amount", 0));
        $blur = wlGwUtils::getArrayValue($params, array("blur", 1));
        $this->setParams($amount, $blur);
    }

    /**
     * Sets the Fx parameters.
     * @param int $amount pixelation level (interval: [0, 255])
     * @param bool $blur specifies if blur should be applied after pixelation
     * @return void 
     */
    public function setParams($amount = 0, $blur = false) {
        if (is_array($amount)) {
            $this->setParamsByArray($amount);
            return;
        }
        wlGwUtils::limitByInterval($amount, 0, 255);
        $this->_amount = $amount;
        $this->_blur = $blur;
    }

    protected function mainRender() {
        if ($this->_amount == 0 || $this->_amount == 1)
            return $this->_sourceImage->bitmap;

        if (function_exists("imagefilter")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            imagefilter($bitmap, IMG_FILTER_PIXELATE, $this->_amount, $this->_blur);
            return $bitmap;
        }
        return null;
    }

    protected function getParamsInfo() {
        return array(
            "amount" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 255),
                "description" => "Pixelate level",
                "isoptional" => true,
                "default" => 0,
            ),
            "blur" => array(
                "type" => "bool",
                "description" => "Apply blur",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>