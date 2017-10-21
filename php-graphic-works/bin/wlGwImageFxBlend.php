<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Blend Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html blend.png "Blend('watermark.png', 50, 0, 0)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxBlend extends wlGwImageFx {

    /**
     * @var resource the resource image bitmap to be mixed with the source
     */
    protected $_image;
    /**
     * @var int mixing opacity (0 = transparent, 100 = opaque)
     */
    private $_opacity;
    /**
     * @var int x-coordinate of where to draw the image to be mixed
     */
    private $_x;
    /**
     * @var int y-coordinate of where to draw the image to be mixed
     */
    private $_y;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Blend Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param string|wlGwImage|resource $image the image to be mixed with the source
     * @param int $opacity mixing opacity (0 = transparent, 100 = opaque)
     * @param int $x x-coordinate of where to draw the image to be mixed
     * @param int $y y-coordinate of where to draw the image to be mixed
     */
    public function __construct($source = null, $image = null, $opacity = 100, $x = 0, $y = 0) {
        parent::__construct($source);
        $this->setParams($image, $opacity, $x, $y);
    }

    public function setParamsByArray($params) {
        $image = wlGwUtils::getArrayValue($params, array("image", 0));
        $opacity = wlGwUtils::getArrayValue($params, array("opacity", 1));
        $x = wlGwUtils::getArrayValue($params, array("x", 2));
        $y = wlGwUtils::getArrayValue($params, array("y", 3));
        $this->setParams($image, $opacity, $x, $y);
    }

    /**
     * Sets the Fx parameters.
     * @param string|wlGwImage|resource $image the image to be mixed with the source
     * @param int $opacity mixing opacity (0 = transparent, 100 = opaque)
     * @param int $x x-coordinate of where to draw the image to be mixed
     * @param int $y y-coordinate of where to draw the image to be mixed
     * @return void 
     */
    public function setParams($image = null, $opacity = 100, $x = 0, $y = 0) {
        if (is_array($image)) {
            $this->setParamsByArray($image);
            return;
        }

        wlGwUtils::limitByInterval($opacity, 0, 100);
        wlGwUtils::makeNumber($x);
        wlGwUtils::makeNumber($y);

        $this->_opacity = $opacity;
        $this->_x = $x;
        $this->_y = $y;

        $this->_image = $this->getBitmap($image);
    }

    /**
     * Returns the resource image bitmap to be mixed with the source image
     * @param string|wlGwImage|resource $image specifies the source of the image (if string, it represents a path to the image (local or url))
     * @return resource image bitmap to be mixed
     */
    protected function getBitmap($image) {
        if (!isset($image))
            return null;

        if (is_string($image)) {
            $tmp = new wlGwImage($image, true);
            $tmp->load();
            if ($tmp->getError())
                return null;
            return $tmp->bitmap;
        } elseif (is_resource($image)) {
            return $image;
        }
        return null;
    }

    protected function mainRender() {
        if ($this->_opacity == 0)
            return $this->_sourceImage->bitmap;

        if (isset($this->_image)) {
            $bmpToMixWidth = imagesx($this->_image);
            $bmpToMixHeight = imagesy($this->_image);

            if ($bmpToMixWidth && $bmpToMixHeight) {
                imagealphablending($this->_image, false);
                imagesavealpha($this->_image, true);
                wlGwUtils::imageBlend($this->_sourceImage->bitmap, $this->_image, $this->_x, $this->_y, 0, 0, $bmpToMixWidth, $bmpToMixHeight, $this->_opacity);
            }
            @imagedestroy($this->_image);
        }
        return $this->_sourceImage->bitmap;
    }

    protected function getParamsInfo() {
        return array(
            "image" => array(
                "type" => "string",
                "description" => "Blend with image",
                "isoptional" => true,
                "default" => "http://",
            ),
            "opacity" => array(
                "type" => "int",
                "range" => array("from" => 1, "to" => 100),
                "description" => "Opacity",
                "isoptional" => true,
                "default" => 100,
            ),
            "x" => array(
                "type" => "int",
                "description" => "Position X",
                "isoptional" => true,
                "default" => 0,
            ),
            "y" => array(
                "type" => "int",
                "description" => "Position Y",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>