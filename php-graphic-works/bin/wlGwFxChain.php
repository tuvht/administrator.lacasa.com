<?php

/**
 * WiseLoop Graphic Works Fx Chain class definition<br/>
 * The wlGwFxChain object is responsible for manipulating effects in a "bulk" manner.<br/>
 * Practically, it consists of an array of wlGwImageFx objects chained together.<br/>
 * The main purpose of the effects chain is to be applied over an wlGwImage object;
 * the processing is done by applying the effects from the chain one by one over the result of the previous effect.<br/>
 * Also, the class has full support for serializing / unserializing using various data and file formats;<br/>
 * The serialization can be done to a string (human or str), JSON string, array or a file.<br/>
 * The unserialization can be done from a string (human or str), JSON string, array, $_GET, $_POST, file or an url.
 * @author WiseLoop
 */
class wlGwFxChain {
    /**
     * Human format Fx Chain constant definition
     */
    const WLGW_FXCHAIN_FORMAT_HUMAN = "human";

    /**
     * String format Fx Chain constant definition
     */
    const WLGW_FXCHAIN_FORMAT_STRING = "str";

    /**
     * JSON format Fx Chain constant definition
     */
    const WLGW_FXCHAIN_FORMAT_JSON = "json";

    /**
     * Variable names that can holds the Fx Chain data in $_GET or $_POST
     */
    const WLGW_FXCHAIN_VALID_HTTP_NAMES = "fx,fxs,fxchain";

    /**
     * Variable names that can holds the Fx Chain file path in a GET or POST request
     */
    const WLGW_FXCHAIN_VALID_PATH_NAMES = "fxpath,fxspath,fxchainpath,fxurl,fxsurl,fxchainurl,fxuri,fxsuri,fxchainuri";

    /**
     * @var array the Fx Chain
     */
    private $_chain;
    /**
     * @var string the error message if somethig went wrong
     */
    private $_error;

    /**
     * Constructor<br/>
     * Creates an FxChain object.
     * @return void
     */
    public function __construct() {
        $this->reset();
    }

    /**
     * Resets the Fx Chain object: removes all the effects from the chain and sets the error message to empty string.
     * @return void
     */
    public function reset() {
        unset($this->_chain);
        $this->_chain = array();
        $this->_error = "";
    }

    /**
     * Returns the error message.
     * @return string
     */
    public function getError() {
        return $this->_error;
    }

    /**
     * Userializes the Fx Chain from an array of wlGwImageFx.
     * @param array $array the array containing wlGwImageFx objects
     * @return bool true if unserialization was successfull, false otherwise
     */
    private function unserializeArray($array) {
        $this->_chain = $array;
        return true;
    }

    /**
     * Returns the number of effects founded in the Fx Chain.
     * @return int
     */
    public function getFxCount() {
        if (!isset($this->_chain))
            return 0;
        if (!is_array($this->_chain))
            return 0;
        return count($this->_chain);
    }

    /**
     * Attempts to unserialize the Fx Chain from a string (human or str format).<br/>
     * - example (human format) @c unserializeString("scalebyheight(30%);blur(2);rotate(15)+reflection()")
     * - example (str format) @c unserializeString("scalebyheight=30%+blur=2+rotate=15+reflection")
     * @param string $string the source string
     * @return bool true if unserialization was successfull, false otherwise
     */
    private function unserializeString($string) {
        try {
            $arr = array();

            $string = str_replace(array("\n", "\r", ";"), "", $string);
            $string = str_replace(array("+", "~", ")", "]", "}"), "&", $string);
            $string = str_replace(array("(", "[", "{"), "=", $string);

            parse_str($string, $arr);
            $arr = explode("&", $string);
            foreach ($arr as $fxDef) {
                $fxDef = trim($fxDef);
                if ($fxDef) {
                    $fxDefArr = explode("=", $fxDef);
                    $fxName = trim($fxDefArr[0]);
                    $fxParams = "";
                    if (isset($fxDefArr[1]))
                        $fxParams = trim($fxDefArr[1]);
                    if ($fxParams !== "")
                        $fxParams = @explode(",", $fxParams);
                    else
                        $fxParams = array();
                    $this->_chain[] = array($fxName => $fxParams);
                }
            }
            return true;
        } catch (Exception $ex) {
            $this->_error = $ex->getMessage();
        }
        return false;
    }

    /**
     * Attempts to unserialize the Fx Chain from a JSON string.<br/>
     * @param string $jsonString the JSON source string
     * @return bool true if unserialization was successfull, false otherwise
     */
    private function unserializeJson($jsonString) {
        try {
            $ret = wlGwUtils::jsonDecode($jsonString);
            if (!isset($ret))
                return false;

            if (is_array($ret)) {
                $this->_chain = $ret;
                return true;
            }
        } catch (Exception $ex) {
            $this->_error = $ex->getMessage();
        }
        return false;
    }

    /**
     * Serializes the Fx Chain as an array; practically it returns the fx array.
     * @return array
     */
    public function serializeArray() {
        return $this->_chain;
    }

    /**
     * Serializes the Fx Chain as a string in human format.
     * @return string
     */
    private function serializeHuman() {
        $ret = "";
        foreach ($this->_chain as $fx)
            foreach ($fx as $fxName => $fxParams) {
                $ret.= ( $fxName . "(");
                foreach ($fxParams as $fxParam)
                    $ret.= ( $fxParam . ",");
                if (wlGwUtils::stringEndsWith($ret, ","))
                    $ret = substr($ret, 0, strlen($ret) - 1);
                $ret.=");\n\r";
            }
        return $ret;
    }

    /**
     * Serializes the Fx Chain as a string in str format.
     * @return string
     */
    private function serializeString() {
        $ret = "";
        foreach ($this->_chain as $fx)
            foreach ($fx as $fxName => $fxParams) {
                $ret.= ( $fxName . "=");
                foreach ($fxParams as $fxParam)
                    $ret.= ( $fxParam . ",");
                if (wlGwUtils::stringEndsWith($ret, ","))
                    $ret = substr($ret, 0, strlen($ret) - 1);
                $ret.="+";
            }
        return $ret;
    }

    /**
     * Serializes the Fx Chain as a string in JSON format
     * @return string
     */
    private function serializeJson() {
        return wlGwUtils::jsonEncode($this->_chain);
    }

    /**
     * Serializes the Fx Chain using the specified format
     * @param string $format the output serialization format (human, str, JSON)
     * @return string
     */
    public function serialize($format = self::WLGW_FXCHAIN_FORMAT_HUMAN) {
        if ($format == self::WLGW_FXCHAIN_FORMAT_HUMAN)
            return $this->serializeHuman();
        elseif ($format == self::WLGW_FXCHAIN_FORMAT_STRING)
            return $this->serializeString();
        elseif ($format == self::WLGW_FXCHAIN_FORMAT_JSON)
            return $this->serializeJson();
        return "";
    }

    /**
     * Attempts to userialize the Fx Chain by detecting the input format (array, human, str, JSON, path to a file or url).
     * @param array|string $fxData
     * @param bool $append specifies if the unserialization process should append unserialized effects to the existing chain; if this is set to false, the chain will be reseted first
     * @return bool true if unserialization was successfull, false otherwise
     */
    public function unserialize($fxData, $append = false) {
        if (!$append) {
            unset($this->_chain);
            $this->_chain = array();
        }

        if (is_array($fxData))
            return $this->unserializeArray($fxData);
        elseif (is_string($fxData)) {
            if ($this->unserializeJson($fxData))
                return true;
            if ($this->unserializeString($fxData))
                return true;
            if (wlGwUtils::uriExists($fxData))
                return $this->load($fxData);
        }
        return false;
    }

    /**
     * Attempts to unserialize the Fx Chain directly from the $_GET http query string.<br/>
     * The GET variable name must be one of names defined in WLGW_FXCHAIN_VALID_HTTP_NAMES constant.
     * @return bool
     */
    public function unserializeGET() {
        $fxString = wlGwUtils::getArrayValue($_GET, explode(",", self::WLGW_FXCHAIN_VALID_HTTP_NAMES), "");
        return $this->unserializeString($fxString);
    }

    /**
     * Attempts to unserialize the Fx Chain directly from the $_POST http variable.<br/>
     * The POST variable name must be one of names defined in WLGW_FXCHAIN_VALID_HTTP_NAMES constant.
     * @return bool
     */
    public function unserializePOST() {
        $fxString = wlGwUtils::getArrayValue($_POST, explode(",", self::WLGW_FXCHAIN_VALID_HTTP_NAMES), "");
        return $this->unserializeString($fxString);
    }

    /**
     * Serializes the Fx Chain and saves it into a file using a specified format.<br/>
     * Extension is apended automatically depending on the format.
     * @param string $filePath
     * @param string $format the output serialization format (human, str, JSON)
     * @return bool if saving operation was succesfull or not
     */
    public function save($filePath, $format = self::WLGW_FXCHAIN_FORMAT_HUMAN) {
        if (!$format)
            return false;
        try {
            if (!wlGwUtils::stringEndsWith($filePath, $format))
                $filePath.= ( "." . $format);
            $fh = fopen($filePath, "w");
            fwrite($fh, $this->serialize($format));
            fclose($fh);
            return true;
        } catch (Exception $ex) {
            $this->_error = $ex->getMessage();
            return false;
        }
    }

    /**
     * Unserializes the Fx Chain from a file or url containing a string wich represents a serialized Fx Chain.<br/>
     * Extension of the file determines wich unserialization method will be used (human, str, JSON).
     * @param string $url the file or url wich contains the serialized string
     * @return bool if loading operation was succesfull or not
     */
    public function load($url) {
        $ret = false;
        $backup = $this->_chain;
        try {
            $this->reset();
            $fxData = wlGwUtils::getUrlContents($url);
            $type = pathinfo($url, PATHINFO_EXTENSION);

            if ($type === self::WLGW_FXCHAIN_FORMAT_HUMAN || $type === self::WLGW_FXCHAIN_FORMAT_STRING)
                $ret = $this->unserializeString($fxData);
            elseif ($type === self::WLGW_FXCHAIN_FORMAT_JSON)
                $ret = $this->unserializeJson($fxData);
            else
                $ret = $this->unserialize($fxData);
        } catch (Exception $ex) {
            $this->_error = $ex->getMessage();
            $ret = false;
        }
        if (!$ret)
            $this->_chain = $backup;
        return $ret;
    }

}

?>