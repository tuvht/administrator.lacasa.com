<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Flip Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html fliph.png "Flip(true, false)"</td>
 * <td>@image html flipv.png "Flip(false, true)"</td>
 * <td>@image html fliphv.png "Flip(true, true)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxFlip extends wlGwImageFx {

    /**
     * @var bool flip horizontal
     */
    private $_horizontal;
    /**
     * @var bool flip vertical
     */
    private $_vertical;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Flip Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param bool $horizontal flip horizontal
     * @param bool $vertical flip vertical
     */
    public function __construct($source = null, $horizontal = false, $vertical = false) {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams($horizontal, $vertical);
    }

    public function setParamsByArray($params) {
        $horizontal = wlGwUtils::getArrayValue($params, array("horizontal", 0));
        $vertical = wlGwUtils::getArrayValue($params, array("vertical", 1));
        $this->setParams($horizontal, $vertical);
    }

    /**
     * Sets the Fx parameters.
     * @param bool $horizontal flip horizontal
     * @param bool $vertical flip vertical
     */
    public function setParams($horizontal = false, $vertical = false) {
        if (is_array($horizontal)) {
            $this->setParamsByArray($horizontal);
            return;
        }

        $this->_horizontal = $horizontal;
        $this->_vertical = $vertical;
    }

    protected function mainRender() {
        if (!$this->_horizontal && !$this->_vertical)
            return $this->_sourceImage->bitmap;

        $bitmap = $this->_sourceImage->getSelectionBitmap();
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        if ($this->_horizontal) {
            $output = imagecreatetruecolor($width, $height);
            for ($i = 0; $i < $height; $i++)
                imagecopy($output, $bitmap, 0, ($height - $i - 1), 0, $i, $width, 1);
            imagedestroy($bitmap);
            $bitmap = $output;
        }

        if ($this->_vertical) {
            $output = imagecreatetruecolor($width, $height);
            for ($i = 0; $i < $width; $i++)
                imagecopy($output, $bitmap, ($width - $i - 1), 0, $i, 0, 1, $height);
            imagedestroy($bitmap);
            $bitmap = $output;
        }

        return $bitmap;
    }

    protected function getParamsInfo() {
        return array(
            "horizontal" => array(
                "type" => "bool",
                "description" => "Horizontal",
                "isoptional" => true,
                "default" => 0,
            ),
            "vertical" => array(
                "type" => "bool",
                "description" => "Vertical",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>