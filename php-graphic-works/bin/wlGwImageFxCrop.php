<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Crop Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html crop.png "Crop(0, 0, 40, 40)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxCrop extends wlGwImageFx {

    /**
     * @var int x-coordinate of first point
     */
    private $_x1;
    /**
     * @var int y-xoordinate of first point
     */
    private $_y1;
    /**
     * @var int x-coordinate of second point
     */
    private $_x2;
    /**
     * @var int y-coordinate of second point
     */
    private $_y2;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Crop Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $x1 x-coordinate of first point
     * @param int $y1 y-coordinate of first point
     * @param int $x2 x-coordinate of second point
     * @param int $y2 y-coordinate of second point
     */
    public function __construct($source = null, $x1 = 0, $y1 = 0, $x2 = 0, $y2 = 0) {
        parent::__construct($source);
        $this->_replaceSourceImage = true;
        $this->setParams($x1, $y1, $x2, $y2);
    }

    public function setParamsByArray($params) {
        $x1 = wlGwUtils::getArrayValue($params, array("x1", 0));
        $y1 = wlGwUtils::getArrayValue($params, array("y1", 1));
        $x2 = wlGwUtils::getArrayValue($params, array("x2", 2));
        $y2 = wlGwUtils::getArrayValue($params, array("y2", 3));
        $this->setParams($x1, $y1, $x2, $y2);
    }

    /**
     * Sets the Fx parameters.
     * @param int $x1 x-coordinate of first point
     * @param int $y1 y-coordinate of first point
     * @param int $x2 x-coordinate of second point
     * @param int $y2 y-coordinate of second point
     * @return void
     */
    public function setParams($x1 = 0, $y1 = 0, $x2 = 0, $y2 = 0) {
        if (is_array($x1)) {
            $this->setParamsByArray($x1);
            return;
        }

        wlGwUtils::makeNumber($x1);
        wlGwUtils::makeNumber($y1);
        wlGwUtils::makeNumber($x2);
        wlGwUtils::makeNumber($y2);

        $this->_x1 = $x1;
        $this->_y1 = $y1;
        $this->_x2 = $x2;
        $this->_y2 = $y2;
    }

    protected function mainRender() {
        $cropWidth = $this->_x2 - $this->_x1;
        $cropHeight = $this->_y2 - $this->_y1;

        if ($cropWidth != 0 && $cropHeight != 0) {
            $this->_sourceImage->setSelection($this->_x1, $this->_y1, $this->_x2, $this->_y2, false);
            if ($this->_sourceImage->isSelectionLimitedToBoundaries())
                return $this->_sourceImage->getSelectionBitmap();
            else {
                $output = imagecreatetruecolor($cropWidth, $cropHeight);
                imagecopy($output, $this->_sourceImage->bitmap, abs($this->_x1), abs($this->_y1), 0, 0, $this->_sourceImage->getWidth(), $this->_sourceImage->getHeight());
                imagesavealpha($output, true);
                imagealphablending($output, false);
                $this->_sourceImage->setSelection();
                return $output;
            }
        } else {
            return $this->_sourceImage->getSelectionBitmap();
        }
    }

    protected function getParamsInfo() {
        return array(
            "x1" => array(
                "type" => "int",
                "description" => "X1",
                "isoptional" => true,
                "default" => 0,
            ),
            "y1" => array(
                "type" => "int",
                "description" => "Y1",
                "isoptional" => true,
                "default" => 0,
            ),
            "x2" => array(
                "type" => "int",
                "description" => "X2",
                "isoptional" => true,
                "default" => 0,
            ),
            "y2" => array(
                "type" => "int",
                "description" => "Y2",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>