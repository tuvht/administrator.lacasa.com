<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Blur Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html blur.png "Blur(20)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxBlur extends wlGwImageFx {

    /**
     * @var int amount of blur to be applied (interval: [0, 50])
     */
    private $_amount;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Blur Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $amount amount of blur to be applied (interval: [0, 50])
     */
    public function __construct($source = null, $amount = 0) {
        parent::__construct($source);
        $this->setParams($amount);
    }

    public function setParamsByArray($params) {
        $amount = wlGwUtils::getArrayValue($params, array("amount", 0));
        $this->setParams($amount);
    }

    /**
     * Sets the Fx parameters.
     * @param int $amount the amount of blur to be applied (interval: [0, 50])
     * @return void 
     */
    public function setParams($amount = 0) {
        if (is_array($amount)) {
            $this->setParamsByArray($amount);
            return;
        }
        wlGwUtils::limitByInterval($amount, 0, 50);
        $this->_amount = $amount;
    }

    protected function mainRender() {
        if ($this->_amount == 0)
            return $this->_sourceImage->bitmap;

        if (function_exists("imagefilter")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            for ($i = 0; $i < $this->_amount; $i++)
                imagefilter($bitmap, IMG_FILTER_SELECTIVE_BLUR);
            return $bitmap;
        }
        return $this->_sourceImage->bitmap;
    }

    protected function getParamsInfo() {
        return array(
            "amount" => array(
                "type" => "int",
                "range" => array("from" => 0, "to" => 50),
                "description" => "Blur level",
                "isoptional" => true,
                "default" => 0,
            ),
        );
    }

}

?>