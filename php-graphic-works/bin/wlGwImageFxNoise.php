<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Noise Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html noise.png "Noise(255)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxNoise extends wlGwImageFx {

    /**
     * @var int noise intensity (interval: [0, 255])
     */
    private $_intensity;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Noise Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $intensity noise intensity (interval: [0, 255])
     */
    public function __construct($source = null, $intensity = 127) {
        parent::__construct($source);
        $this->setParams($intensity);
    }

    public function setParamsByArray($params) {
        $intensity = wlGwUtils::getArrayValue($params, array("intensity", 0));
        $this->setParams($intensity);
    }

    /**
     * Sets the Fx parameters.
     * @param int $intensity noise intensity (interval: [0, 255])
     * @return void
     */
    public function setParams($intensity = 0) {
        if (is_array($intensity)) {
            $this->setParamsByArray($intensity);
            return;
        }
        wlGwUtils::limitByInterval($intensity, 0, 255);
        $this->_intensity = $intensity;
    }

    protected function mainRender() {
        $bitmap = $this->_sourceImage->getSelectionBitmap();

        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        for ($y = 0; $y < $height; $y++)
            for ($x = 0; $x < $width; $x++)
                imagesetpixel($bitmap, $x, $y, imagecolorat($bitmap, $x, $y) | imagecolorallocate($bitmap, rand(0, $this->_intensity), rand(0, $this->_intensity), rand(0, $this->_intensity)));
        return $bitmap;
    }

    protected function getParamsInfo() {
        return array(
            "intensity" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 255),
                "description" => "Noise intensity",
                "isoptional" => true,
                "default" => 127,
            ),
        );
    }
    
}

?>