<?php

require_once 'wlGwImageFx.php';

/**
 * WiseLoop PHP Graphic Works Gamma Filter Effect class definition<br/>
 * <table border="0"><tr>
 * <td>@image html _before.jpg "Original"</td>
 * <td>@image html gamma1.png "Gamma(100, 400)"</td>
 * <td>@image html gamma2.png "Gamma(200, 75)"</td>
 * </tr></table>
 * @author WiseLoop
 */
class wlGwImageFxGamma extends wlGwImageFx {

    /**
     * @var int gamma input value (interval: [1, 1000])
     */
    private $_input;
    /**
     * @var int gamma output value (interval: [1, 1000])
     */
    private $_output;

    /**
     * Constructor<br/>
     * Creates a WiseLoop Image Gamma Fx object.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @param int $input gamma input value (interval: [1, 1000])
     * @param int $output gamma output value (interval: [1, 1000])
     */
    public function __construct($source = null, $input = 100, $output = 100) {
        parent::__construct($source);
        $this->setParams($input);
    }

    public function setParamsByArray($params) {
        $input = wlGwUtils::getArrayValue($params, array("input", 0), 100);
        $output = wlGwUtils::getArrayValue($params, array("amount", 1), 100);
        $this->setParams($input, $output);
    }

    /**
     * Sets the Fx parameters.
     * @param type $input gamma input value (interval: [1, 1000])
     * @param type $output gamma output value (interval: [1, 1000])
     * @return type 
     */
    public function setParams($input = 100, $output = 100) {
        if (is_array($input)) {
            $this->setParamsByArray($input);
            return;
        }

        wlGwUtils::limitByInterval($input, 1, 1000);
        wlGwUtils::limitByInterval($output, 1, 1000);
        $this->_input = $input;
        $this->_output = $output;
    }

    protected function mainRender() {
        if ($this->_input == 0 || $this->_output == 0 || $this->_input == $this->_output)
            return $this->_sourceImage->bitmap;

        if (function_exists("imagegammacorrect")) {
            $bitmap = $this->_sourceImage->getSelectionBitmap();
            imagegammacorrect($bitmap, $this->_input / 100, $this->_output / 100);
            return $bitmap;
        }
        return null;
    }

    protected function getParamsInfo() {
        return array(
            "input" => array(
                "type" => "int",
                "range" => array("from" => 1, "to" => 1000),
                "description" => "Input",
                "isoptional" => true,
                "default" => 100,
            ),
            "output" => array(
                "type" => "int",
                "range" => array("from" => 1, "to" => 1000),
                "description" => "Output",
                "isoptional" => true,
                "default" => 100,
            ),
        );
    }

}

?>