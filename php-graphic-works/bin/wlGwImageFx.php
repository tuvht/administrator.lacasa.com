<?php

/**
 * Wise Loop Image Fx class definition<br/>
 * @author WiseLoop
 */
abstract class wlGwImageFx {

    /**
     * @var wlGwImage the source image
     */
    protected $_sourceImage;
    /**
     * @var bool specifies if the resultig bitmap after applying the Fx will overwrite the source image bitmap; usually, this is set to true when the source image bitmap size must be modified by the Fx (ex. Stretch, Crop, Resize, Reflection)
     */
    protected $_replaceSourceImage;
    /**
     * @var string the minimum php version required by the Fx
     */
    protected $_phpVersion;
    /**
     * @var string the Fx description
     */
    protected $_description;

    /**
     * Sets the Fx parameters.
     * @return void
     */
    abstract public function setParams();

    /**
     * Sets the Fx parameters using an array.
     * @param array $params
     * @return void
     */
    abstract public function setParamsByArray($params);

    /**
     * Constructor.<br/>
     * Creates a WiseLoop image Fx object based on a source image.
     * @param string|wlGwImage $source the source image on wich the Fx will be applied
     * @return void
     */
    public function __construct($source = null) {
        $this->_replaceSourceImage = false;
        $this->_phpVersion = "5.0.0";
        $this->_description = "";
        $this->setSourceImage($source);
    }

    /**
     * Sets the source image.
     * @param string|wlGwImage $source 
     */
    private function setSourceImage($source = null) {
        if ($source) {
            if (is_string($source)) {
                $this->_sourceImage = new wlGwImage($source);
            } elseif ($source instanceof wlGwImage) {
                $this->_sourceImage = $source;
            }
        }
    }

    /**
     * Tests if the current PHP platform supports the current Fx.
     * @see $_phpVersion
     * @return type 
     */
    public function checkPhpVersion() {
        return (version_compare(phpversion(), $this->_phpVersion) >= 0);
    }

    /**
     * Returns if the resulting Fx image bitmap should replace the source image bitmap entirely.<br/>
     * This is set to true usually on the Fx-ex wich modifies the size of the image (ex. Stretch, Crop, Resize, Reflection)
     * @see $_replaceSourceImage
     * @return bool
     */
    public function getReplaceSourceImage() {
        return $this->_replaceSourceImage;
    }

    /**
     * Updates the source image by rendering the current Fx.
     * @see updateWlGwImage()
     * @return void
     */
    public function updateSource() {
        $this->_sourceImage->setType(IMAGETYPE_PNG);
        $this->_sourceImage->setMime("image/png");
        $this->_sourceImage->bitmap = $this->render();
    }

    /**
     * Renders the current Fx and returns the resulting resource image bitmap.<br/>
     * The rendering is done by calling mainRender() or aceRender() if mainRender() fails
     * @see mainRender(), aceRender()
     * @return resource image
     */
    protected function render() {;
        if (!$this->checkPhpVersion())
            return $this->_sourceImage->bitmap;

        $result = null;
        try {
            $result = $this->mainRender();
        } catch (Exception $ex) {
            
        }

        if ($result) {
            $this->_sourceImage->refreshSelection($result);
            return $this->_sourceImage->bitmap;
        }

        try {
            $result = $this->aceRender();
        } catch (Exception $ex) {
            
        }

        if ($result)
            $this->_sourceImage->refreshSelection($result);

        return $this->_sourceImage->bitmap;
    }

    /**
     * Renders the current Fx and returns the resulting resource image bitmap.
     * @return resource image
     */
    protected abstract function mainRender();

    /**
     * Renders the current Fx and returns the resulting resource image bitmap if mainRender() fails.
     * @return resource image
     */
    protected function aceRender() {
        return $this->_sourceImage->bitmap;
    }

    /**
     * Tests if passed argument $object is of wlGwImageFx type.
     * @param mixed $object
     * @return bool
     */
    public static function isWlGwImageFx($object) {
        try {
            if (is_resource($object))
                return false;
            return (is_subclass_of($object, __CLASS__) || (get_class($object) == __CLASS__));
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Returns the nice name of the Fx.
     * @return string
     */
    public function getFxName() {
        return str_replace(wlGwUtils::WLGW_IMAGEFX_CLASS_PREFIX, "", get_class($this));
    }

    /**
     * Returns the description of the fx.
     * @return string
     */
    public function getFxDescription() {
        if (!$this->_description)
            $this->_description = "WiseLoop GraphicWorks " . $this->getFxName();
        return $this->_description;
    }

    /**
     * Returns the informations about all the parameters wich defines the fx:
     * - name
     * - type
     * - range interval
     * - description
     * - isoptional
     * - default
     * @see getServiceInfo()
     * @return array
     */
    protected function getParamsInfo() {
        return array();
    }

    /**
     * Returns all the information about the fx.
     * Think of this function as an API function, very usefull when implementing a service/controller wich provides fx information to a third software product.<br/>
     * Using a service/controller based on this function, you can develop for example a JavaScript image editor wich is aware of the fx-es available for applying
     * @return array
     */
    public function getServiceInfo() {
        return array(
            "name" => $this->getFxName(),
            "description" => $this->getFxDescription(),
            "parameters" => $this->getParamsInfo(),
        );
    }

}

?>
