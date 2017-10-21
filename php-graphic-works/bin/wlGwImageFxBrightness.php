<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Brightness Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html brightness1.png "Brightness(90)"</td>
 * <td>@image html brightness2.png "Brightness(-90)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxBrightness extends wlGwImageFx {

    /**
     * @var int amount of brightness (interval: [-255, 255])
     */
    private $_amount;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Brightness Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $amount amount of brightness (interval: [-255, 255])
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
     * @param int $amount the amount of brightness (interval: [-255, 255])
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
            imagefilter($bitmap, IMG_FILTER_BRIGHTNESS, $this->_amount);
            return $bitmap;
        }
        return null;
    }

    protected function aceRender() {
        $factor = 1;
        if ($this->_amount <= 0)
            $factor = 1 - ($this->_amount / -255);
        else
            $factor = 10 * ($this->_amount / 255);

        if ($factor == 1)
            return $this->_sourceImage->bitmap;

        $width = $this->_sourceImage->getWidth();
        $height = $this->_sourceImage->getHeight();

        $bitmap = $this->_sourceImage->getSelectionBitmap();

        for ($y = 0; $y < $height; $y++)
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($bitmap, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $hsbArr = wlGwUtils::rgb2hsb($r, $g, $b);

                $hsbArr[2] = $factor * $hsbArr[2];
                $hsbArr[2] = max(0.0, min($hsbArr[2], 255.0));

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
                "range" => array("from" => -255, "to" => 255),
                "description" => "Brightness level",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>