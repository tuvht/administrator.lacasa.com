<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Edge Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html edge.png "Edge()"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxEdge extends wlGwImageFx {

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
            imagefilter($bitmap, IMG_FILTER_EDGEDETECT);
            return $bitmap;
        }
        return null;
    }

}

?>