<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Mean Removal Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html meanremoval.png "MeanRemoval()"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxMeanRemoval extends wlGwImageFx {

    public function __construct($source = null) {
        parent::__construct($source);
        $this->_phpVersion = "5.0.0";
        $this->setParams();
    }

    public function setParamsByArray($params) {
        $this->setParams();
    }

    public function setParams() {
        
    }

    protected function mainRender() {
        if (function_exists("imagefilter")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            imagefilter($bitmap, IMG_FILTER_MEAN_REMOVAL);
            return $bitmap;
        }
        return null;
    }

}

?>