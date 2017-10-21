<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Channel Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html channelr.png "Channel(Red)"</td>
 * <td>@image html channelg.png "Channel(Green)"</td>
 * <td>@image html channelb.png "Channel(Blue)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxChannel extends wlGwImageFx {

    /**
     * @var string the channel to be extracted (Red, Green or Blue)
     */
    private $_channel;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Channel Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $channel the channel to be extracted (Red, Green or Blue)
     */
    public function __construct($source = null, $channel = "") {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams($channel);
    }

    public function setParamsByArray($params) {
        $channel = wlGwUtils::getArrayValue($params, array("channel", 0));
        $this->setParams($channel);
    }

    /**
     * Sets the Fx parameters.
     * @param type $channel the channel to be extracted (Red, Green or Blue)
     * @return void 
     */
    public function setParams($channel = "") {
        if (is_array($channel)) {
            $this->setParamsByArray($channel);
            return;
        }

        $channel = substr(strtoupper($channel), 0, 1);

        if ($channel !== "R" && $channel !== "G" && $channel !== "B")
            $channel = "";

        $this->_channel = $channel;
    }

    protected function mainRender() {
        if ($this->_channel == "")
            return $this->_sourceImage->bitmap;

        $bitmap = $this->_sourceImage->getSelectionBitmap();
        $width = imagesx($bitmap);
        $height = imagesy($bitmap);

        for ($y = 0; $y < $height; $y++)
            for ($x = 0; $x < $width; $x++) {
                $rgb = imagecolorat($bitmap, $x, $y);
                if ($this->_channel == "R") {
                    $r = ($rgb >> 16) & 0xFF;
                    $red = imagecolorallocate($bitmap, $r, 0, 0);
                    imagesetpixel($bitmap, $x, $y, $red);
                } elseif ($this->_channel == "G") {
                    $g = ($rgb >> 8) & 0xFF;
                    $green = imagecolorallocate($bitmap, 0, $g, 0);
                    imagesetpixel($bitmap, $x, $y, $green);
                } elseif ($this->_channel == "B") {
                    $b = $rgb & 0xFF;
                    $blue = imagecolorallocate($bitmap, 0, 0, $b);
                    imagesetpixel($bitmap, $x, $y, $blue);
                }
            }
        return $bitmap;
    }

    protected function getParamsInfo() {
        return array(
            "channel" => array(
                "type" => "string",
                "description" => "Channel",
                "enum" => array("Red", "Green", "Blue"),
                "isoptional" => true,
                "default" => "",
            ),
        );
    }

}

?>