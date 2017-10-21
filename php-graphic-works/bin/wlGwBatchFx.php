<?php
/**
 * WiseLoop Graphic Works Batch Image Processor class definition<br/>
 * The BatchFx Processor applies an Fx Chain to all the images founded in a specific directory and saves the processed images into another directory (or the same directory).<br/>
 * Additionally the output format (JPG, GIF, PNG) can be specified or if the source images will be deleted or not.
 * @remark After calling run(), the getMessages() method sould be checked to see if something went wrong.
 * @author WiseLoop
 */
class wlGwBatchFx
{
    const WLGW_BATCHFX_DESTDIR_SAME = "same";
    const WLGW_BATCHFX_SAVEFORMAT_ORIGINAL = "original";

    /**
     * @var string
     */
    private $_srcDir;

    /**
     * @var string
     */
    private $_destDir;

    /**
     * @var wlGwFxChain
     */
    private $_fxChain;

    /**
     * @var bool
     */
    private $_recurse;

    /**
     * @var bool
     */
    private $_deleteOriginal;

    /**
     * @var string
     */
    private $_saveFormat;

    /**
     * @var array(string) the message queue
     */
    private $_messages;

    /**
     * Constructor<br/>
     * Creates an BatchFx object.
     * @param string $srcDir the source directory
     * @param wlGwFxChain $fxChain the Fx Chain to be applied to the images from source directory
     * @param string $destDir the destination directory (default: same as source)
     * @param bool $recurse specifies if the subdirectories of source directory should be also walked and processed
     * @param bool $deleteOriginal specifies if the original (source) images shold be deleted
     * @param string $saveFormat the result image save format (JPG, GIF, PNG, default: same as original)
     * @return void
     */
    public function __construct($srcDir, $fxChain, $destDir = self::WLGW_BATCHFX_DESTDIR_SAME, $recurse = false, $deleteOriginal = false, $saveFormat = self::WLGW_BATCHFX_SAVEFORMAT_ORIGINAL)
    {
        if(!isset($destDir))
            $destDir = self::WLGW_BATCHFX_DESTDIR_SAME;
        if(!isset($recurse))
            $recurse = false;
        if(!isset($deleteOriginal))
            $deleteOriginal = false;
        if(!isset($saveFormat))
            $saveFormat = self::WLGW_BATCHFX_SAVEFORMAT_ORIGINAL;

        if($destDir == self::WLGW_BATCHFX_DESTDIR_SAME)
            $destDir = $srcDir;

        $this->_srcDir = $srcDir;
        $this->_fxChain = $fxChain;
        $this->_destDir = $destDir;
        $this->_recurse = $recurse;
        $this->_deleteOriginal = $deleteOriginal;
        $this->_saveFormat = $saveFormat;
        $this->_messages = array();
    }

    /**
     * Starts the directory image processing.
     * @return void
     */
    public function run()
    {
        $this->runOnDir($this->_srcDir, $this->_recurse);
    }

    /**
     * Applies the Fx Chain on the images from the specified directory (and subdirectories if $recurse is set to true).<br/>
     * If the source directory could not be open, a corresponding message will be added to the message queue.
     * @param string $path the directory path
     * @param bool $recurse specifies if the subdirectories of the directory path should be also walked and processed
     * @return void
     */
    private function runOnDir($path = ".", $recurse = false)
    {
        $skip = array(".", "..", "bin", "protected", "cgi-bin");
        $dh = @opendir(realpath($path));
        if($dh)
        {
            while(false !== ($file = readdir($dh)))
            {
                if(!in_array($file, $skip))
                {
                    $fullFile = $path."/".$file;
                    if(is_dir($fullFile))
                    {
                        if($recurse)
                            $this->runOnDir($fullFile, $recurse);
                    }
                    else
                    {
                        $this->processFile($fullFile);
                    }
                }
            }
            @closedir($dh);
        }else
        {
            $this->addMessage("Could not open directory ".$path);
        }
    }

    /**
     * Applies the Fx Chain on a file.<br/>
     * If something goes wrong, a corresponding message will be added to the message queue.
     * @throws Exception
     * @param string $file the image file to process
     * @return void
     */
    private function processFile($file)
    {
        try
        {
            $this->addMessage("Processing ".$file);
            $img = new wlGwImage($file);
            $img->disableCache();
            $img->applyFxChain($this->_fxChain);
            $destFilePath = str_replace($this->_srcDir, $this->_destDir, $file);
            $dirPath = pathinfo($destFilePath, PATHINFO_DIRNAME);

            if(!is_dir($dirPath))
            {
                $result = @mkdir($dirPath);
                if(!$result)
                    throw new Exception("Directory ".$dirPath." could not be created");
            }
            $img->save($destFilePath);
            if($this->_deleteOriginal)
                if(realpath($file) != realpath($destFilePath))
                    unlink($file);

        }catch(Exception $ex)
        {
            $this->addMessage($ex->getMessage());
        }

    }

    /**
     * Adds a message to the message queue.
     * @param string $message the message to be added
     * @return void
     */
    public function addMessage($message)
    {
        $this->_messages[] = $message;
    }

    /**
     * Returns the message queue.
     * @return array(string)
     */
    public function getMessages()
    {
        return $this->_messages;
    }

    /**
     * Displays the message queue in very basic form: the messages are separated by a simple break html tag.
     * @return void
     */
    public function showMessages()
    {
        foreach($this->_messages as $message)
            echo $message."<br/>";
    }
}
?>