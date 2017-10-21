<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Negative Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html negative.png "Negative()"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxNegative extends wlGwImageFx {

    public function __construct($source = null) {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams();
    }

    public function setParamsByArray($params) {
        $this->setParams();
    }

    public function setParams() {
        
    }

    protected function mainRender() {
        if (function_exists("imagefilter")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            imagefilter($bitmap, IMG_FILTER_NEGATE);
            return $bitmap;
        }
        return null;
    }

    protected function aceRender() {
        $bitmap = $this->_sourceImage->getSelectionBitmap();
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        for ($y = 0; $y < $height; $y++)
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($this->_sourceImage->bitmap, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                imagesetpixel($bitmap, $x, $y, imagecolorallocate($bitmap, 255 - $r, 255 - $g, 255 - $b));
            }
        return $bitmap;
    }

}

?>