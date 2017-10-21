<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Grayscale Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html grayscale.png "Grayscale()"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxGrayscale extends wlGwImageFx {

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
            imagefilter($bitmap, IMG_FILTER_GRAYSCALE);
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
                $rgb = imagecolorat($bitmap, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $i = round(($r + $g + $b) / 3);
                imagesetpixel($bitmap, $x, $y, imagecolorallocate($bitmap, $i, $i, $i));
            }
        return $bitmap;
    }

}

?>