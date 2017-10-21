<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Reflection Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html reflection2.png "Reflection(20, 2, 100, 0)"</td>
 * <td>@image html reflection1.png "Reflection(50%, 0, 90, 0)"</td>
 * <td>@image html reflection3.png "Reflection(100%, 1, 100, 0)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxReflection extends wlGwImageFx {

    /**
     * @var int reflection height (interval: [0, source_image_height])
     */
    private $_height;
    /**
     * @var int distance between image and reflection
     */
    private $_distance;
    /**
     * @var int reflection transparency start percent value (interval: [0, 100])
     */
    private $_transparencyStart;
    /**
     * @var int reflection transparency end percent value (interval: [0, 100])
     */
    private $_transparencyEnd;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Reflection Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param string|int $height reflection height, (put '%' after the numeric value to set percentage from original height) (interval: [0, source_image_height])
     * @param int $distance distance between image and reflection
     * @param int $transparencyStart reflection transparency start percent value (interval: [0, 100])
     * @param int $transparencyEnd reflection transparency end percent value (interval: [0, 100])
     */
    public function __construct($source = null, $height = "50%", $distance = 0, $transparencyStart = 90, $transparencyEnd = 0) {
        parent::__construct($source);
        $this->_replaceSourceImage = true;
        $this->setParams($height, $distance, $transparencyStart, $transparencyEnd);
    }

    public function setParamsByArray($params) {
        $height = wlGwUtils::getArrayValue($params, array("height", 0), "50%");
        $distance = wlGwUtils::getArrayValue($params, array("distance", 1));
        $transparencyStart = wlGwUtils::getArrayValue($params, array("transparencyStart", 2), 90);
        $transparencyEnd = wlGwUtils::getArrayValue($params, array("transparencyEnd", 3));
        $this->setParams($height, $distance, $transparencyStart, $transparencyEnd);
    }

    /**
     * Sets the Fx parameters.
     * @param string|int $height reflection height, (put '%' after the numeric value to set percentage from original height) (interval: [0, source_image_height])
     * @param int $distance distance between image and reflection
     * @param int $transparencyStart reflection transparency start percent value
     * @param int $transparencyEnd reflection transparency end percent value
     * @return void
     */
    public function setParams($height = "50%", $distance = 0, $transparencyStart = 90, $transparencyEnd = 0) {
        if (is_array($height)) {
            $this->setParamsByArray($height);
            return;
        }

        $iniHeight = 0;
        if (isset($this->_sourceImage)) {
            $iniHeight = $this->_sourceImage->getHeight();
        }

        if (wlGwUtils::stringEndsWith($height, "%") || wlGwUtils::stringEndsWith($height, "p"))
            $height = wlGwUtils::percentToValue($height, $iniHeight);

        wlGwUtils::limitByInterval($height, 0, $iniHeight);

        if ($height <= 1)
            $height = (int) ($iniHeight * $height);

        wlGwUtils::limitByInterval($distance, 0, 100);
        wlGwUtils::limitByInterval($transparencyStart, 0, 100);
        wlGwUtils::limitByInterval($transparencyEnd, 0, 100);

        $this->_height = $height;
        $this->_distance = $distance;
        $this->_transparencyStart = $transparencyStart;
        $this->_transparencyEnd = $transparencyEnd;
    }

    protected function mainRender() {
        if (!$this->_height)
            return $this->_sourceImage->bitmap;

        $ini_width = $this->_sourceImage->getWidth();
        $ini_height = $this->_sourceImage->getHeight();
        $height = $this->_height;
        $distance = $this->_distance;
        $refl_height = $height + $distance;
        $trs = $this->_transparencyStart;
        $tre = $this->_transparencyEnd;

        $output = wlGwUtils::createTCBitmap($ini_width, $ini_height + $refl_height);

        $refl_output = wlGwUtils::createTCBitmap($ini_width, $refl_height);

        $buffer = wlGwUtils::createTCBitmap($ini_width, $refl_height);

        //flipping
        imagecopy($refl_output, $this->_sourceImage->bitmap, 0, 0, 0, $ini_height - $refl_height, $ini_width, $refl_height);

        for ($y = 0; $y < $height; $y++)
            imagecopy($buffer, $refl_output, 0, $y + $distance, 0, $refl_height - $y - 1, $ini_width, 1);
        $refl_output = $buffer;

        //applying transparency
        $trsize = abs($trs - $tre);
        imagelayereffect($refl_output, IMG_EFFECT_OVERLAY);
        for ($y = 0; $y <= $refl_height; $y++) {
            if ($trs > $tre)
                $tr = (int) ($trs - ($y / $refl_height * $trsize));
            else
                $tr=(int) ($trs + ($y / $refl_height * $trsize));
            imagefilledrectangle($refl_output, 0, $y, $ini_width, $y, imagecolorallocatealpha($refl_output, 127, 127, 127, 127 - $tr));
        }
        for ($y = 0; $y < $distance; $y++);
            imagefilledrectangle($refl_output, 0, $y, $ini_width, $y, imagecolorallocatealpha($refl_output, 127, 127, 127, 127));

        imagefilter($refl_output, IMG_FILTER_GAUSSIAN_BLUR);
        imagecopy($output, $this->_sourceImage->bitmap, 0, 0, 0, 0, $ini_width, $ini_height);
        imagecopy($output, $refl_output, 0, $ini_height, 0, 0, $ini_width, $refl_height);

        if (isset($buffer))
            @imagedestroy($buffer);

        if (isset($refl_output))
            @imagedestroy($refl_output);

        return $output;
    }

    protected function getParamsInfo() {
        return array(
            "height" => array(
                "type" => "percent",
                "range" => array("from" => 0, "to" => 100),
                "description" => "Reflection height (percent from image height)",
                "isoptional" => true,
                "default" => 50,
            ),
            "distance" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 100),
                "description" => "Reflection distance",
                "isoptional" => true,
                "default" => 0,
            ),
            "transparencyStart" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 100),
                "description" => "Transparency start",
                "isoptional" => true,
                "default" => 90,
            ),
            "transparencyEnd" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 100),
                "description" => "Transparency end",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>