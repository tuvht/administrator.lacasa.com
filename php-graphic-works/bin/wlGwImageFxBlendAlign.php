<?php

require_once 'wlGwImageFx.php';
require_once 'wlGwImageFxBlend.php';

/**
 * WiseLoop PHP Graphic Works Blend Align Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html blendalign1.png "BlendAlign(watermark.png, 90, center-center)"</td>
 * <td>@image html blendalign2.png "BlendAlign(watermark.png, 50, bottom-left)"</td>
 * <td>@image html blendalign3.png "BlendAlign(window.png, 70, stretch)"</td>
 * <td>@image html blendalign4.png "BlendAlign(frame1.png, 100, stretch)"</td>
 * <td>@image html blendalign5.png "BlendAlign(frame2.png, 100, stretch)"</td>
 * <td>@image html blendalign6.png "BlendAlign(heart.png, 100, stretch)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxBlendAlign extends wlGwImageFxBlend {

    /**
     * @var  $wlGwAlign alignment
     */
    private $_align;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Blend Align Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param string|wlGwImage|resource $image the image to be mixed with the source
     * @param int $opacity mixing opacity (0 = transparent, 100 = opaque)
     * @param type $wlGwAlign alignment
     * @see wlGwUtils
     */
    public function __construct($source = null, $image = null, $opacity = 100, $wlGwAlign = wlGwUtils::WLGW_ALIGN_CENTER_CENTER) {
        parent::__construct($source);
        $this->setParams($image, $opacity, $wlGwAlign);
    }

    public function setParamsByArray($params) {
        $image = wlGwUtils::getArrayValue($params, array("image", 0));
        $opacity = wlGwUtils::getArrayValue($params, array("opacity", 1));
        $wlGwAlign = wlGwUtils::getArrayValue($params, array("align", 2));
        $this->setParams($image, $opacity, $wlGwAlign);
    }

    /**
     * Sets the Fx parameters.
     * @param string|wlGwImage|resource $image the image to be mixed with the source
     * @param int $opacity mixing opacity (0 = transparent, 100 = opaque)
     * @param type $wlGwAlign alignment
     * @see wlGwUtils
     * @return void 
     */
    public function setParams($image = null, $opacity = 100, $wlGwAlign = wlGwUtils::WLGW_ALIGN_CENTER_CENTER) {
        if (is_array($image)) {
            $this->setParamsByArray($image);
            return;
        }

        $this->_align = $wlGwAlign;
        $this->_image = $this->getBitmap($image);

        $iniWidth = 0;
        $iniHeight = 0;
        if (isset($this->_sourceImage)) {
            $iniWidth = $this->_sourceImage->getWidth();
            $iniHeight = $this->_sourceImage->getHeight();
        }

        $width = 0;
        $height = 0;
        if (isset($this->_image)) {
            $width = imagesx($this->_image);
            $height = imagesy($this->_image);
        }
        $coords = wlGwUtils::getAlignCoords($iniWidth, $iniHeight, $width, $height, $wlGwAlign);
        parent::setParams($this->_image, $opacity, $coords[0], $coords[1]);
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
            if($this->_align == wlGwUtils::WLGW_ALIGN_STRETCH)
            {
                $width = $this->_sourceImage->getWidth();
                $height = $this->_sourceImage->getHeight();

                $image = wlGwUtils::createTCBitmap($width, $height);
                imagecopyresampled($image, $tmp->bitmap, 0, 0, 0, 0, $width, $height, imagesx($tmp->bitmap), imagesy($tmp->bitmap));

                @imagedestroy($tmp->bitmap);
                return $image;
            }else
                return $tmp->bitmap;
        } elseif (is_resource($image)) {
            return $image;
        }
        return null;
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
                    wlGwUtils::WLGW_ALIGN_STRETCH,
                ),
                "isoptional" => true,
                "default" => "",
            ),
        );
    }

}

?>