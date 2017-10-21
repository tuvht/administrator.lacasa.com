<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Puzzle Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html puzzle.png "Puzzle(5)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxPuzzle extends wlGwImageFx {

    /**
     * @var int scramble level (interval: [0, 20])
     */
    private $_scramble;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Puzzle Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $scramble scramble level (interval: [0, 20])
     */
    public function __construct($source = null, $scramble = 5) {
        parent::__construct($source);
        $this->setParams($scramble);
    }

    public function setParamsByArray($params) {
        $scramble = wlGwUtils::getArrayValue($params, array("scramble", 0));
        $this->setParams($scramble);
    }

    /**
     * Sets the Fx parameters.
     * @param int $scramble scramble level (interval: [0, 20])
     * @return void 
     */
    public function setParams($scramble = 5) {
        if (is_array($scramble)) {
            $this->setParamsByArray($scramble);
            return;
        }

        wlGwUtils::limitByInterval($scramble, 0, 20);
        $this->_scramble = $scramble;
    }

    protected function mainRender() {
        $bitmap = $this->_sourceImage->getSelectionBitmap();

        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        $size = $this->commonStep($width, $height);

        $countWidth = (int) floor($width / $size);
        $countHeight = (int) floor($height / $size);

        for ($i = 0; $i < $this->_scramble * $countWidth * $countHeight; $i++) {
            $x1 = rand(0, $countWidth - 1) * $size;
            $y1 = rand(0, $countHeight - 1) * $size;

            $temp = imagecreatetruecolor($size, $size);
            imagecopy($temp, $bitmap, 0, 0, $x1, $y1, $size, $size);

            $x2 = rand(0, $countWidth - 1) * $size;
            $y2 = rand(0, $countHeight - 1) * $size;
            imagecopy($bitmap, $bitmap, $x1, $y1, $x2, $y2, $size, $size);
            imagecopy($bitmap, $temp, $x2, $y2, 0, 0, $size, $size);
            imagedestroy($temp);
        }

        return $bitmap;
    }

    /**
     * Returns the largest common divider of two numbers
     * @param int $a number one
     * @param int $b number two
     * @return int the largest common divider
     */
    private function commonStep($a, $b) {
        if ($a == $b)
            return $a;
        elseif ($a > $b)
            return $this->commonStep($a - $b, $b);
        else
            return $this->commonStep($a, $b - $a);
    }

    protected function getParamsInfo() {
        return array(
            "scramble" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 20),
                "description" => "Scramble level",
                "isoptional" => true,
                "default" => 5,
            ),
        );
    }

}

?>