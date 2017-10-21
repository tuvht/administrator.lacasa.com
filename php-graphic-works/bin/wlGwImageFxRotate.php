<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Rotate Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html rotate1.png "Rotate(90)"</td>
 * <td>@image html rotate2.png "Rotate(45)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxRotate extends wlGwImageFx {

    /**
     * @var int rotation angle (interval: [-360, 360])
     */
    private $_angle;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Rotate Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $angle rotation angle (interval: [-360, 360])
     */
    public function __construct($source = null, $angle = 0) {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams($angle);
    }

    public function setParamsByArray($params) {
        $angle = wlGwUtils::getArrayValue($params, array("angle", 0));
        $this->setParams($angle);
    }

    /**
     * Sets the Fx parameters.
     * @param int $angle rotation angle (interval: [-360, 360])
     * @return void 
     */
    public function setParams($angle = 0) {
        if (is_array($angle)) {
            $this->setParamsByArray($angle);
            return;
        }
        wlGwUtils::limitByInterval($angle, -360, 360);
        $this->_angle = $angle;
    }

    protected function mainRender() {
        if ($this->_angle < 0)
            $this->_angle += 360;

        if ($this->_angle == 0 || $this->_angle == -360 || $this->_angle == 360)
            return $this->_sourceImage->bitmap;

        $bitmap = $this->_sourceImage->getSelectionBitmap();
        if (function_exists("imagerotate")) {
            $result = imagerotate($bitmap, $this->_angle, -1);
            imagealphablending($result, true);
            imagesavealpha($result, true);
            return $result;
        }
        return null;
    }

    protected function aceRender() {
        if ($this->_angle < 0)
            $this->_angle += 360;

        if ($this->_angle == 0 || $this->_angle == -360 || $this->_angle == 360)
            return $this->_sourceImage->bitmap;

        $bitmap = $this->_sourceImage->getSelectionBitmap();
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        $output = imagecreatetruecolor($width, $height);

        $centerX = floor($width / 2);
        $centerY = floor($height / 2);

        // Run on all pixels of the destination image and fill them:
        for ($dstImageX = 0; $dstImageX < $width; $dstImageX++) {
            for ($dstImageY = 0; $dstImageY < $height; $dstImageY++) {
                // Calculate pixel coordinate in coordinate system centered at the image center:
                $x = $dstImageX - $centerX;
                $y = $centerY - $dstImageY;

                if (($x == 0) && ($y == 0)) {
                    // We are in the image center, this pixel should be copied as is:
                    $srcImageX = $x;
                    $srcImageY = $y;
                } else {
                    $r = sqrt($x * $x + $y * $y); // radius - absolute distance of the current point from image center

                    $curAngle = asin($y / $r); // angle of the current point [rad]

                    if ($x < 0)
                        $curAngle = pi() - $curAngle;

                    $newAngle = $curAngle + (-1 * $this->_angle) * pi() / 180; // new angle [rad]
                    // Calculate new point coordinates (after rotation) in coordinate system at image center
                    $newXRel = floor($r * cos($newAngle));
                    $newYRel = floor($r * sin($newAngle));

                    // Convert to image absolute coordinates
                    $srcImageX = $newXRel + $centerX;
                    $srcImageY = $centerY - $newYRel;
                }
                $pixelColor = imagecolorat($bitmap, $srcImageX, $srcImageY);
                imagesetpixel($output, $dstImageX, $dstImageY, $pixelColor);
            }
        }
        return $output;
    }

    protected function getParamsInfo() {
        return array(
            "angle" => array(
                "type" => "int",
                "range" => array("from" => -360, "to" => 360),
                "description" => "Angle",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>