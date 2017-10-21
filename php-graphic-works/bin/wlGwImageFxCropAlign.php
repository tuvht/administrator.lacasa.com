<?php

require_once 'wlGwImageFx.php';
require_once 'wlGwImageFxCrop.php';

/**
 * WiseLoop PHP Graphic Works Crop Align Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html cropalign.png "CropAlign(center-center, 40, 40)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxCropAlign extends wlGwImageFxCrop {

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Crop Align Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param type $wlGwAlign alignment
     * @param int $width cropping width
     * @param int $height cropping height
     * @see wlGwUtils
     */
    public function __construct($source = null, $wlGwAlign = wlGwUtils::WLGW_ALIGN_CENTER_CENTER, $width = 0, $height = 0) {
        parent::__construct($source);
        $this->setParams($wlGwAlign, $width, $height);
    }

    public function setParamsByArray($params) {
        $wlGwAlign = wlGwUtils::getArrayValue($params, array("align", 0));
        $width = wlGwUtils::getArrayValue($params, array("width", 1));
        $height = wlGwUtils::getArrayValue($params, array("height", 2));
        $this->setParams($wlGwAlign, $width, $height);
    }

    /**
     * Sets the Fx parameters.
     * @param type $wlGwAlign alignment
     * @param int $width cropping width
     * @param int $height cropping height
     * @see wlGwUtils
     * @return void
     */
    public function setParams($wlGwAlign = wlGwUtils::WLGW_ALIGN_CENTER_CENTER, $width = 0, $height = 0) {
        if (is_array($wlGwAlign)) {
            $this->setParamsByArray($wlGwAlign);
            return;
        }

        $wlGwAlign = strtolower($wlGwAlign);

        wlGwUtils::makeNumber($width);
        wlGwUtils::makeNumber($height);

        $iniWidth = 0;
        $iniHeight = 0;
        if (isset($this->_sourceImage)) {
            $iniWidth = $this->_sourceImage->getWidth();
            $iniHeight = $this->_sourceImage->getHeight();
        }

        $coords = wlGwUtils::getAlignCoords($iniWidth, $iniHeight, $width, $height, $wlGwAlign);
        parent::setParams($coords[0], $coords[1], $coords[0] + $width, $coords[1] + $height);
    }

    protected function getParamsInfo() {
        return array(
            "wlGwAlign" => array(
                "type" => "string",
                "description" => "Alignment",
                "enum" => array(
                    wlGwUtils::WLGW_ALIGN_TOP_LEFT,
                    wlGwUtils::WLGW_ALIGN_TOP_CENTER,
                    wlGwUtils::WLGW_ALIGN_TOP_RIGHT,
                    wlGwUtils::WLGW_ALIGN_CENTER_LEFT,
                    wlGwUtils::WLGW_ALIGN_CENTER_CENTER,
                    wlGwUtils::WLGW_ALIGN_CENTER_RIGHT,
                    wlGwUtils::WLGW_ALIGN_BOTTOM_LEFT,
                    wlGwUtils::WLGW_ALIGN_BOTTOM_CENTER,
                    wlGwUtils::WLGW_ALIGN_BOTTOM_RIGHT,
                ),
                "isoptional" => true,
                "default" => "",
            ),
            "width" => array(
                "type" => "int",
                "description" => "Width",
                "isoptional" => true,
                "default" => 0,
            ),
            "height" => array(
                "type" => "int",
                "description" => "Height",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>