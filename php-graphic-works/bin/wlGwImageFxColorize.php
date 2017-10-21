<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Colorize Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html colorize1.png "Colorize(60, 90, 60, 0)"</td>
 * <td>@image html colorize2.png "Colorize(255, 0, 0, 0)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxColorize extends wlGwImageFx {

    /**
     * @var int red level (interval: [0, 255])
     */
    private $_r;
    /**
     * @var int green level (interval: [0, 255])
     */
    private $_g;
    /**
     * @var int blue level (interval: [0, 255])
     */
    private $_b;
    /**
     * @var int alpha level (interval: [0, 127])
     */
    private $_a;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Colorize Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $r red level (interval: [0, 255])
     * @param int $g green level (interval: [0, 255])
     * @param int $b blue level (interval: [0, 255])
     * @param int $a alpha level (interval: [0, 127])
     */
    public function __construct($source = null, $r = 0, $g = 0, $b = 0, $a = 0) {
        parent::__construct($source);
        $this->_phpVersion = "5.2.5";
        $this->setParams($r, $g, $b, $a);
    }

    public function setParamsByArray($params) {
        $r = wlGwUtils::getArrayValue($params, array("r", 0));
        $g = wlGwUtils::getArrayValue($params, array("g", 1));
        $b = wlGwUtils::getArrayValue($params, array("b", 2));
        $a = wlGwUtils::getArrayValue($params, array("a", 3));
        $this->setParams($r, $g, $b, $a);
    }

    /**
     * Sets the Fx parameters.
     * @param int $r red level (interval: [0, 255])
     * @param int $g green level (interval: [0, 255])
     * @param int $b blue level (interval: [0, 255])
     * @param int $a alpha level (interval: [0, 127])
     * @return void 
     */
    public function setParams($r = 0, $g = 0, $b = 0, $a = 0) {
        if (is_array($r)) {
            $this->setParamsByArray($r);
            return;
        }
        wlGwUtils::limitByInterval($r, 0, 255);
        wlGwUtils::limitByInterval($g, 0, 255);
        wlGwUtils::limitByInterval($b, 0, 255);
        wlGwUtils::limitByInterval($a, 0, 127);

        $this->_r = $r;
        $this->_g = $g;
        $this->_b = $b;
        $this->_a = $a;
    }

    protected function mainRender() {
        if ($this->_r + $this->_g + $this->_b + $this->_a == 0)
            return $this->_sourceImage->bitmap;

        if (function_exists("imagefilter")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            imagefilter($bitmap, IMG_FILTER_COLORIZE, $this->_r, $this->_g, $this->_b, $this->_a);
            return $bitmap;
        }
        return null;
    }

    protected function getParamsInfo() {
        return array(
            "r" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 255),
                "description" => "Red level",
                "isoptional" => true,
                "default" => 0,
            ),
            "g" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 255),
                "description" => "Green level",
                "isoptional" => true,
                "default" => 0,
            ),
            "b" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 255),
                "description" => "Blue level",
                "isoptional" => true,
                "default" => 0,
            ),
            "a" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 127),
                "description" => "Alpha level",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>