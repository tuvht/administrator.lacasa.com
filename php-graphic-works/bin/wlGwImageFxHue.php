<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Hue Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html hue1.png "Hue(10)"</td>
 * <td>@image html hue2.png "Hue(100)"</td>
 * <td>@image html hue3.png "Hue(255)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxHue extends wlGwImageFx {

    /**
     * @var int hue level (interval: [0, 255])
     */
    private $_amount;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Hue Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $amount hue level (interval: [0, 255])
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
     * @param int $amount hue level (interval: [0, 255])
     * @return void 
     */
    public function setParams($amount = 0) {
        if (is_array($amount)) {
            $this->setParamsByArray($amount);
            return;
        }
        wlGwUtils::limitByInterval($amount, 0, 255);
        $this->_amount = $amount;
    }

    protected function mainRender() {
        if ($this->_amount == 0)
            return $this->_sourceImage->bitmap;

        $factor = 10 * $this->_amount / 255;

        if ($factor == 0)
            return parent::render();

        $bitmap = $this->_sourceImage->getSelectionBitmap();
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        for ($y = 0; $y < $height; $y++)
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($bitmap, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $hsbArr = wlGwUtils::rgb2hsb($r, $g, $b);
                $hsbArr[0] = $factor * $hsbArr[0];
                $hsbArr[0] = max(0.0, min($hsbArr[0], 360.0));
                $rgbArr = wlGwUtils::hsb2rgb($hsbArr[0], $hsbArr[1], $hsbArr[2]);
                $hsbrgb = imagecolorallocate($bitmap, $rgbArr[0], $rgbArr[1], $rgbArr[2]);
                imagesetpixel($bitmap, $x, $y, ($rgb & 0xff000000) | ($hsbrgb));
            }
        return $bitmap;
    }

    protected function getParamsInfo() {
        return array(
            "amount" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 255),
                "description" => "Hue level",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>