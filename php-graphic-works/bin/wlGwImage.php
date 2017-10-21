<?php

/**
 * WiseLoop Image class definition<br/>
 * @author WiseLoop
 */
class wlGwImage {

    /**
     * @var string the universal resource identifier (local file or url) from where to load the image data
     */
    private $_uri;
    /**
     * @var string last error message
     */
    private $_error;
    /**
     * @var array the information returned by the php getimagesize function: width, height, IMAGETYPE_XXX, MIME type
     */
    private $_imageInfo;
    /**
     * @var array current rectangular selection: four elements wich represents the coordinates of the two points wich defines the selection (x1, y1, x2, y2)
     */
    private $_selection;
    /**
     * @var wlGwImageFx last effect that was applied over the image
     */
    private $_lastFx;
    /**
     * @var bool if memory freeing (the php imagedestroy function) should be done manually by calling the destroy() method
     */
    private $_manualDestroy;
    /**
     * @var bool if caching is enabled
     */
    private $_cacheEnabled;
    /**
     * @var resource the bitmap image data
     */
    public $bitmap;

    /**
     * Contructor<br/>
     * Creates an WiseLoop Image object based on the URI (universal resource identifier) path given as parameter.<br/>
     * The actual loading of the image bitmap data will be executed later, when the image data will be needed for processing or displaying.
     * @param string $uri the image path (local file or url)
     * @param bool $manualDestroy
     * @see load()
     * @return void
     */
    public function __construct($uri = null, $manualDestroy = false) {
        $this->_error = "";
        $this->_selection = array();
        $this->_lastFx = null;
        $this->_manualDestroy = $manualDestroy;
        $this->_cacheEnabled = false;
        $this->bitmap = null;
        $this->_uri = $uri;
    }

    /**
     * Destructor<br/>
     * Destroys the WiseLoop Image object and freeups the memory if $_manualDestroy is not set to true.
     * @see $_manualDestroy
     * @return void
     */
    public function __destruct() {
        if (!$this->_manualDestroy)
            $this->destroy();
    }

    /**
     * Destroys the WiseLoop Image object and freeups the memory.
     * @see __destruct()
     * @return void
     */
    public function destroy() {
        if (isset($this->bitmap))
            @imagedestroy($this->bitmap);
    }

    /**
     * Enables the caching.
     * @return void
     */
    public function enableCache() {
        $this->_cacheEnabled = true;
    }

    /**
     * Disablse the caching.
     * @return void
     */
    public function disableCache() {
        $this->_cacheEnabled = false;
    }

    /**
     * Attempts to load the image.<br/>
     * @param string $uri the image path (local file or url); if equals the default null value, the loading is done from the object's $_uri wich was allready set at construction time
     * @param bool $forced if set to true forces the loading without any validation of the uri
     * @see $_uri, $_error, setError(), getError()
     * @return bool if loading was successfull; if not, the $_error will be filled with the corresponding message
     */
    public function load($uri = null, $forced = false) {
        if ($uri === $this->_uri) {
            if ($this->getError())
                return false;
            return true;
        }

        if (isset($uri))
            $this->_uri = $uri;

        if ($forced)
            return true;

        if ($this->getError())
            return false;

        if (!wlGwUtils::uriExists($this->_uri)) {
            $this->setError("Cannot load source image " . $this->_uri);
            return false;
        }

        $this->_imageInfo = getimagesize($this->_uri);
        if ($this->_imageInfo === false) {
            $this->setError("Cannot access image data.");
            return false;
        }

        $type = $this->getType();

        if ($type == IMAGETYPE_GIF)
            $bitmap = imagecreatefromgif($this->_uri);
        elseif ($type == IMAGETYPE_JPEG)
            $bitmap = imagecreatefromjpeg($this->_uri);
        elseif ($type == IMAGETYPE_PNG)
            $bitmap = imagecreatefrompng($this->_uri);
        else {
            $this->setError("Image format not supported.");
            return false;
        }
        imagealphablending($bitmap, false);
        imagesavealpha($bitmap, true);
        $this->bitmap = $bitmap;
        return true;
    }

    /**
     * Returns if the image bitmap data is available, so the image was loaded.
     * $see load()
     * @return bool if the image bitmap data is available
     */
    public function isLoaded() {
        return isset($this->bitmap);
    }

    /**
     * Returns the uri path of the image.
     * @see $_uri
     * @return string the uri path of the image
     */
    public function getUri() {
        return $this->_uri;
    }

    /**
     * Sets the last error message.
     * @param string $err the error message
     * @return void
     */
    private function setError($err) {
        if (!$this->_error)
            $this->_error = $err;
    }

    /**
     * Returns the last error message if set, or false if there is no error message set.
     * @return string|bool the last error message or false if there is no error message
     */
    public function getError() {
        if ($this->_error === "")
            return false;
        return $this->_error;
    }

    /**
     * Returns the width of the image.
     * @return int the width of the image
     */
    public function getWidth() {
        if (isset($this->bitmap))
            return imagesx($this->bitmap);
        return 0;
    }

    /**
     * Returns the height of the image.
     * @return int the height of the image
     */
    public function getHeight() {
        if (isset($this->bitmap))
            return imagesy($this->bitmap);
        return 0;
    }

    /**
     * Returns the MIME type of the image.
     * @return string the MIME type of the image
     */
    public function getMime() {
        if ($this->_imageInfo)
            if (isset($this->_imageInfo["mime"]))
                return $this->_imageInfo["mime"];
        return null;
    }

    /**
     * Sets the MIME type of the image.
     * @param string $mime the new MIME type of the image
     * @return void
     */
    public function setMime($mime) {
        if (!$this->_imageInfo)
            $this->_imageInfo = array();
        $this->_imageInfo["mime"] = $mime;
    }

    /**
     * Returns the image type.
     * @return int the image type
     */
    public function getType() {
        if ($this->_imageInfo) {
            if (isset($this->_imageInfo["type"]))
                return $this->_imageInfo["type"];
            if (isset($this->_imageInfo[2]))
                return $this->_imageInfo[2];
        }
        return null;
    }

    /**
     * Sets the image type.
     * @param int $type the new image type
     * @return void
     */
    public function setType($type) {
        if (!$this->_imageInfo)
            $this->_imageInfo = array();
        $this->_imageInfo["type"] = $type;
    }

    /**
     * Returns basic information about the image (an array with the following keys: width, height, mime, type).
     * @return array basic information about the image
     */
    public function getInfo() {
        return array(
            "width" => $this->getWidth(),
            "height" => $this->getHeight(),
            "mime" => $this->getMime(),
            "type" => $this->getType(),
        );
    }

    /**
     * Returns the resource image bitmap data of the image.
     * @return resource the image bitmap data
     */
    public function getBitmap() {
        return $this->bitmap;
    }

    /**
     * Returns a clone of the image bitmap data.
     * @return resource the image bitmap data clone
     */
    public function getBitmapClone() {
        $width = $this->getWidth();
        $height = $this->getHeight();
        $output = imagecreatetruecolor($width, $height);
        imagealphablending($output, false);
        imagesavealpha($output, true);
        imagecopy($output, $this->bitmap, 0, 0, 0, 0, $width, $height);
        return $output;
    }

    /**
     * Sets the current rectangular selection.<br/>
     * Any subsequent Fx Chains or singular effects will be applied only on the surface designated by the selection where applicable.<br/>
     * @param int $x1 x-coordinate of the rectangle left-top point
     * @param int $y1 y-coordinate of the rectangle left-top point
     * @param int $x2 x-coordinate of the rectangle right-bottom point
     * @param int $y2 y-coordinate of the rectangle right-bottom point
     * @param bool $limitToBoundaries if set to true, the selection will be limited to the image boundaries
     * @return void
     */
    public function setSelection($x1 = 0, $y1 = 0, $x2 = 0, $y2 = 0, $limitToBoundaries = true) {
        $width = $this->getWidth();
        $height = $this->getHeight();

        wlGwUtils::makeNumber($x1);
        wlGwUtils::makeNumber($y1);
        wlGwUtils::makeNumber($x2);
        wlGwUtils::makeNumber($y2);

        if ($limitToBoundaries) {
            wlGwUtils::limitByInterval($x1, 0, $width);
            wlGwUtils::limitByInterval($x2, 0, $width);
            wlGwUtils::limitByInterval($y1, 0, $height);
            wlGwUtils::limitByInterval($y2, 0, $height);
        }

        if ($x2 < $x1)
            wlGwUtils::swap($x1, $x2);

        if ($y2 < $y2)
            wlGwUtils::swap($y1, $y2);

        $this->_selection["x1"] = $x1;
        $this->_selection["y1"] = $y1;
        $this->_selection["x2"] = $x2;
        $this->_selection["y2"] = $y2;
    }

    /**
     * Tests if the current rectangular selection in between the image boundaries.
     * @return bool
     */
    public function isSelectionLimitedToBoundaries() {
        $width = $this->getWidth();
        $height = $this->getHeight();

        $x1 = isset($this->_selection["x1"]) ? $this->_selection["x1"] : 0;
        $y1 = isset($this->_selection["y1"]) ? $this->_selection["y1"] : 0;
        $x2 = isset($this->_selection["x2"]) ? $this->_selection["x2"] : 0;
        $y2 = isset($this->_selection["y2"]) ? $this->_selection["y2"] : 0;

        return ($x1 >= 0 && $x1 <= $width && $x2 >= 0 && $x2 <= $width && $y1 >= 0 && $y1 <= $height && $y2 >= 0 && $y2 <= $height);
    }

    /**
     * Tests if the current rectangular selection in valid:
     * - it is set
     * - it has all the four values (x1, y1, x2, y2) specified in the array
     * - the width and the height of the rectangular selection are greater than zero
     * @see $_selection
     * @return bool
     */
    public function isSelectionValid() {
        if (!isset($this->_selection))
            return false;

        if (!count($this->_selection))
            return false;

        $x1 = isset($this->_selection["x1"]) ? $this->_selection["x1"] : 0;
        $y1 = isset($this->_selection["y1"]) ? $this->_selection["y1"] : 0;
        $x2 = isset($this->_selection["x2"]) ? $this->_selection["x2"] : 0;
        $y2 = isset($this->_selection["y2"]) ? $this->_selection["y2"] : 0;

        $selWidth = $x2 - $x1;
        $selHeight = $y2 - $y1;

        if ($selWidth == 0 || $selHeight == 0)
            return false;

        return true;
    }

    /**
     * Returns the current rectangular selection bitmap data.
     * @return resource bitmap data
     */
    public function getSelectionBitmap() {
        if (!$this->isSelectionValid())
            return $this->bitmap;

        $x1 = $this->_selection["x1"];
        $y1 = $this->_selection["y1"];
        $x2 = $this->_selection["x2"];
        $y2 = $this->_selection["y2"];

        $selWidth = $x2 - $x1;
        $selHeight = $y2 - $y1;

        if ($selWidth == 0 || $selHeight == 0)
            return $this->bitmap;

        $output = wlGwUtils::createTCBitmap($selWidth, $selHeight);
        imagecopy($output, $this->bitmap, 0, 0, $x1, $y1, $selWidth, $selHeight);
        imagealphablending($output, false);
        imagesavealpha($output, true);

        return $output;
    }

    /**
     * Refreshes (redraws) the selection rectangular area with a new bitmap usually returned by an effect render result.
     * @param resource $bitmap the new bitmap to be drawn over the current rectangular selection
     * @return void
     */
    public function refreshSelection($bitmap) {
        if (!$this->isSelectionValid()) {
            if ($this->bitmap !== $bitmap)
                if (isset($this->bitmap))
                    @imagedestroy($this->bitmap);
            $this->bitmap = $bitmap;
            return;
        }

        $x1 = $this->_selection["x1"];
        $y1 = $this->_selection["y1"];
        $x2 = $this->_selection["x2"];
        $y2 = $this->_selection["y2"];

        $selWidth = $x2 - $x1;
        $selHeight = $y2 - $y1;

        if ($this->bitmap !== $bitmap) {
            if ($this->_lastFx->getReplaceSourceImage()) {
                if (isset($this->bitmap))
                    @imagedestroy($this->bitmap);
                $this->bitmap = $bitmap;
            }else {
                imagecopy($this->bitmap, $bitmap, $x1, $y1, 0, 0, $selWidth, $selHeight);
                if (isset($bitmap))
                    @imagedestroy($bitmap);
            }
        }
    }

    /**
     * Outputs the image to the browser.
     * @return void
     */
    public function draw() {
        if (!$this->isLoaded())
            $this->load();

        $mime = $this->getMime();
        $type = $this->getType();

        header('Content-type: ' . $mime);
        header('Content-transfer-encoding: binary');

        if ($type == IMAGETYPE_GIF)
            imagegif($this->bitmap);
        elseif ($type == IMAGETYPE_JPEG)
            imagejpeg($this->bitmap, null, 100);
        elseif ($type == IMAGETYPE_PNG)
            imagepng($this->bitmap, null, 0);
    }

    /**
     * Saves the image back to the $_uri provided that the $_uri is a writable local file.
     * @throws Exception
     * @param string $filePath a new file path to save the image; if not null (default), a Save As procedure will be executed
     * @return void
     */
    public function save($filePath = null) {
        if (!$this->isLoaded())
            $this->load();

        if (!isset($filePath)) {
            $filePath = $this->_uri;
            if (!file_exists($filePath))
                throw new Exception(sprintf("File %s is invalid.", $filePath));
        }

        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if (!in_array($ext, explode(",", wlGwUtils::WLGW_VALID_IMAGE_TYPES))) {
            $type = $this->getType();
            $ext = image_type_to_extension($type);

            if (!wlGwUtils::stringEndsWith($filePath, $ext))
                $filePath.=$ext;
        }

        $ext = strtolower($ext);

        try {
            $ret = true;
            if ($ext == "gif")
                $ret = @imagegif($this->bitmap, $filePath);
            elseif ($ext == "jpg" || $ext == "jpeg")
                $ret = @imagejpeg($this->bitmap, $filePath, 100);
            elseif ($ext == "png") 
                $ret = @imagepng($this->bitmap, $filePath, 9);
            if (!$ret)
                throw new Exception("Image could not be saved to " . $filePath);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Tests if the image cache for the specified parameters is up to date.
     * @param string $params the cache parameters: usually an Fx Chain
     * @see wlGwFxChain
     * @return bool if image cache is up to date
     */
    private function isCacheUpdated($params = null) {
        $cacheFilePath = $this->getCacheFilePath($params);
        if (!$cacheFilePath)
            return false;

        if (file_exists($cacheFilePath) && filemtime($cacheFilePath) >= wlGwUtils::getRemoteFileMTime($this->_uri))
            return true;

        return false;
    }

    /**
     * Generates an unique cache file name for the specified parameters.
     * @param mixed $params the cache parameters: usually an Fx Chain
     * @see wlGwFxChain
     * @return string the cache file name
     */
    private function getCacheFileName($params = null) {
        if (!isset($this->_cacheEnabled))
            return false;

        if (!$this->_cacheEnabled)
            return false;

        $ret = $this->_uri;

        if (isset($params)) {
            if (is_array($params)) {
                $ret.=serialize($params);
            }
        }

        return md5($ret) . ".png";
    }

    /**
     * Returns the image cache path for the specified parameters using the CACHE_DIR from the configuration file.
     * @param mixed $params the cache parameters: usually an Fx Chain
     * @see wlGwConfig
     * @return string the cache file path
     */
    private function getCacheFilePath($params = null) {
        $cacheFileName = $this->getCacheFileName($params);
        if (!$cacheFileName)
            return false;
        return wlGwConfig::CACHE_DIR . "/" . $cacheFileName;
    }

    /**
     * Applyes an Fx to the current selection.
     * @param string|wlGwImageFx $fx the Fx name or an wlGwImageFx object
     * @param array $fxParams the Fx parameters (only when $fx is a string)
     * @see wlGwFxChain, setSelection()
     * @return void
     */
    public function applyFx($fx, $fxParams = null) {
        if (!$this->isLoaded())
            $this->load();

        if (is_string($fx)) {
            if (!wlGwUtils::stringStartsWith($fx, wlGwUtils::WLGW_IMAGEFX_CLASS_PREFIX))
                $fx = wlGwUtils::WLGW_IMAGEFX_CLASS_PREFIX . $fx;

            if (class_exists($fx)) {
                $fx = new $fx($this, $fxParams);
                $this->_lastFx = $fx;
                $fx->updateSource();
            }
        } elseif (wlGwImageFx::isWlGwImageFx($fx)) {
            $this->_lastFx = $fx;
            $fx->updateSource();
        }
    }

    /**
     * Applyes an Fx Chain to the current selection.
     * @param wlGwFxChain $fxChain the Fx Chain object
     * @see wlGwFxChain, setSelection()
     * @return void
     */
    public function applyFxChain($fxChain) {
        $fxChain = $fxChain->serializeArray();

        $cacheFilePath = $this->getCacheFilePath($fxChain);
        if ($this->isCacheUpdated($fxChain)) {
            $this->load($cacheFilePath);
        } else {
            foreach ($fxChain as $fxName => $fxParams) {
                if (is_numeric($fxName)) {
                    foreach ($fxParams as $fxName => $fxParams) {
                        $this->applyFx($fxName, $fxParams);
                    }
                } else {
                    $this->applyFx($fxName, $fxParams);
                }
            }
            if ($cacheFilePath)
                $this->save($cacheFilePath);
        }
    }

    /**
     * Tests if an object is of wlGwImage type.
     * @param $object the tested object
     * @return bool if $object is of wlGwImage type.
     */
    public static function isWlGwImage($object) {
        try {
            if (is_resource($object))
                return false;
            return (is_subclass_of($object, __CLASS__) || (get_class($object) == __CLASS__));
        } catch (Exception $ex) {
            return false;
        }
    }

}

?>
