<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Mask Effect class definition<br/>
 * <strong>Vectorial self generated shapes:</strong>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html mask1.png "Mask(circle)"</td>
 * <td>@image html mask2.png "Mask(circle, 45)"</td>
 * <td>@image html mask3.png "Mask(ellipse)"</td>
 * <td>@image html mask4.png "Mask(rounded, 10)"</td>
 * <td>@image html mask5.png "Mask(rounded, 25)"</td>
 * <td>@image html mask6.png "Mask(interlaced, 1)"</td>
 * <td>@image html mask7.png "Mask(interlaced, 2)"</td>
 * </tr></table>
 * <strong>Masks loaded from files:</strong>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html mask8.png "Mask(rabbit.png, 1)"</td>
 * <td>@image html mask10.png "Mask(xray.png, 1)"</td>
 * <td>@image html mask11.png "Mask(grayscale.png, 1)"</td>
 * <td>@image html mask12.png "Mask(rubick.png, 1)"</td>
 * <td>@image html mask13.png "Mask(frame1.png, 1)"</td>
 * <td>@image html mask14.png "Mask(frame2.png, 1)"</td>
 * <td>@image html mask15.png "Mask(frame3.png, 1)"</td>
 * </tr></table>
 * <strong>The masks:</strong>
 * <table border="0"><tr>
 * <td>@image html mask-rabbit.png ""</td>
 * <td>@image html mask-xray.png ""</td>
 * <td>@image html mask-grayscale.png ""</td>
 * <td>@image html mask-rubick.png ""</td>
 * <td>@image html mask-frame1.png ""</td>
 * <td>@image html mask-frame2.png ""</td>
 * <td>@image html mask-frame3.png ""</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxMask extends wlGwImageFx {

    const WLGW_SHAPE_MASK_NONE = "none";
    const WLGW_SHAPE_MASK_CIRCLE = "circle";
    const WLGW_SHAPE_MASK_ELLIPSE = "ellipse";
    const WLGW_SHAPE_MASK_ROUNDED = "rounded";
    const WLGW_SHAPE_MASK_INTERLACED = "interlaced";

    /**
     * @var string shape the mask shape (values: [none, circle, ellipse, rounded, interlaced, a png file uri])
     */
    private $_shape;

    /**
     * @var int mask parameter. It is used according to the shape parameter.
     * - if shape is circle: rotation angle measured in degrees (interval: [-360, 360])
     * - if shape is rounded: radius of the rounded corners
     * - if shape is interlaced: height of the interlaced lines
     * - if shape is ellipse: not used
     * - if shape is an uri: specifies if the file mask will be stretched to the match the size of source image
     */
    private $_param1;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Mask Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param string $shape the mask shape (values: [none, circle, ellipse, rounded, interlaced, a png file uri])
     * @param int $param1 the mask parameter. It is used according to the shape parameter.
     * - if shape is circle: rotation angle measured in degrees (interval: [-360, 360])
     * - if shape is rounded: radius of the rounded corners
     * - if shape is interlaced: height of the interlaced lines
     * - if shape is ellipse: not used
     * - if shape is an uri: specifies if the file mask will be stretched to the match the size of source image
     */
    public function __construct($source = null, $shape = self::WLGW_SHAPE_MASK_NONE, $param1 = 0) {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams($shape);
    }

    public function setParamsByArray($params) {
        $shape = wlGwUtils::getArrayValue($params, array("shape", 0));
        $param1 = wlGwUtils::getArrayValue($params, array("param1", 1));
        $this->setParams($shape, $param1);
    }

    /**
     * Sets the Fx parameters.
     * @param string $shape the mask shape (values: [none, circle, ellipse, rounded, interlaced, a png file uri])
     * @param int $param1
     * @return void 
     */
    public function setParams($shape = self::WLGW_SHAPE_MASK_NONE, $param1 = 0) {
        if (is_array($shape)) {
            $this->setParamsByArray($shape);
            return;
        }

        if($shape == self::WLGW_SHAPE_MASK_CIRCLE)
            wlGwUtils::limitByInterval($param1, -360, 360);

        $this->_shape = $shape;
        $this->_param1 = $param1;
    }

    protected function mainRender() {
        if ($this->_param1 < 0)
            $this->_param1 += 360;

        $source = $this->_sourceImage->getSelectionBitmap();
        $width = imagesx($source);
        $height = imagesy($source);

        $mask = null;
        $output = $source;
        if($this->_shape == self::WLGW_SHAPE_MASK_CIRCLE)
        {
            $square = min($width, $height);
            $output = wlGwUtils::createTCBitmap($square, $square);
    
            $black = wlGwUtils::getColorBlack($output, 0, 0, 0);
            imagecopyresampled($output, $source, 0, 0, ($width - $square) / 2, ($height - $square) / 2, $square, $square, $square, $square);

            if ($this->_param1 != 0) {
                $rotated_img = imagerotate($output, $this->_param1, $black);
                $rotated_map_width = imagesx($rotated_img);
                $rotated_map_height = imagesy($rotated_img);
                imagecopy($output, $rotated_img, 0, 0, ($rotated_map_width - $square) / 2, ($rotated_map_height - $square) / 2, $square, $square);
            }
            $mask = $this->createCircleMask($source);
        }else if($this->_shape == self::WLGW_SHAPE_MASK_ELLIPSE)
        {
            $mask = $this->createEllipseMask($source);
        }else if($this->_shape == self::WLGW_SHAPE_MASK_ROUNDED)
        {
            wlGwUtils::limitByInterval($this->_param1, 0, floor(min($width, $height) / 2));
            $mask = $this->createRoundedMask($source);
        }else if($this->_shape == self::WLGW_SHAPE_MASK_INTERLACED)
        {
            $mask = $this->createInterlacedMask($source);
        }else
        {
            $mask = $this->createFileMask($source);
        }

        if(isset($mask))
            wlGwUtils::applyMask($output, $mask);

        return $output;
    }

    /**
     * Generates a mask form a uri (local file or url)
     * @param resource $bitmap
     * @return resource the mask
     */
    private function createFileMask($bitmap)
    {
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        $tmp = new wlGwImage($this->_shape, true);
        $tmp->load();
        if ($tmp->getError())
            return null;

        $mask2 = $tmp->bitmap;
        $mask = $mask2;

        if($this->_param1)
        {
            $mask = wlGwUtils::createTCBitmap($width, $height);
            imagecopyresampled($mask, $mask2, 0, 0, 0, 0, $width, $height, imagesx($mask2), imagesy($mask2));

            @imagedestroy($mask2);
        }

        return $mask;
    }

    /**
     * Generates a circle shaped mask
     * @param resource $bitmap
     * @return resource the mask
     */
    private function createCircleMask($bitmap)
    {
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        $square = min($width, $height);
        $square2 = $square * 2;

        $mask2 = wlGwUtils::createTCBitmap($square2, $square2);
        wlGwUtils::fill($mask2, wlGwUtils::getColorBlack($mask2));
        $c = floor($square);
        imagefilledellipse($mask2, $c, $c, $square2 - 2, $square2 - 2, wlGwUtils::getColorWhite($mask2));
        imagefilter($mask2, IMG_FILTER_SMOOTH, 9);

        $mask = wlGwUtils::createTCBitmap($square, $square);
        imagecopyresampled($mask, $mask2, 0, 0, 0, 0, $square, $square, $square2, $square2);

        @imagedestroy($mask2);

        return $mask;
    }

    /**
     * Generates an ellipsed shaped mask
     * @param resource $bitmap
     * @return resource the mask
     */
    private function createEllipseMask($bitmap)
    {
        $width = imagesx($bitmap) * 2;
        $height = imagesy($bitmap) * 2;

        $mask = wlGwUtils::createTCBitmap($width, $height);
        wlGwUtils::fill($mask, wlGwUtils::getColorBlack($mask));
        $cx = floor($width / 2);
        $cy = floor($height / 2);

        imagefilledellipse($mask, $cx, $cy, $width - 2, $height - 2, wlGwUtils::getColorWhite($mask));
        imagefilter($mask, IMG_FILTER_SMOOTH, 9);

        $this->halfStretch($mask);

        return $mask;
    }

    /**
     * Generates a rounded rectangle shaped mask
     * @param resource $bitmap
     * @return resource the mask
     */
    private function createRoundedMask($bitmap)
    {
        $width = imagesx($bitmap) * 2;
        $height = imagesy($bitmap) * 2;

        $mask = wlGwUtils::createTCBitmap($width, $height);
        wlGwUtils::fill($mask, wlGwUtils::getColorBlack($mask));
        wlGwUtils::fillRoundedRectangle($mask, 0, 0, $width - 1, $height - 1, $this->_param1 * 2, wlGwUtils::getColorWhite($mask));
        imagefilter($mask, IMG_FILTER_SMOOTH, 9);

        $this->halfStretch($mask);
        
        return $mask;
    }

    /**
     * Generates an interlaced shaped mask
     * @param resource $bitmap
     * @return resource the mask
     */
    private function createInterlacedMask($bitmap)
    {
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        $mask = wlGwUtils::createTCBitmap($width, $height);
        wlGwUtils::fill($mask, wlGwUtils::getColorBlack($mask));
        $white = wlGwUtils::getColorWhite($mask);

        $y = 0;
        while($y < $height)
        {
            imagefilledrectangle($mask, 0, $y, $width - 1, $y + $this->_param1 - 1, $white);
            $y += ($this->_param1 * 2);
        }
            
        return $mask;
    }

    /**
     * Stretches an image to half size
     * @param resource $bitmap
     * @return resource the mask
     */
    private function halfStretch(&$bitmap)
    {
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        $width2 = floor($width / 2);
        $height2 = floor($height / 2);

        $out = wlGwUtils::createTCBitmap($width2, $height2);
        imagecopyresampled($out, $bitmap, 0, 0, 0, 0, $width2, $height2, $width, $height);

        @imagedestroy($bitmap);
        $bitmap = $out;
    }

    protected function getParamsInfo() {
        return array(
            "shape" => array(
                "type" => "string",
                "description" => "Shape (none, circle, ellipse, rounded, interlaced, path_to_uri)",
                "isoptional" => true,
                "default" => "none",
            ),
            "param1" => array(
                "type" => "int",
                "description" => "Mask parameter",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }
}

?>