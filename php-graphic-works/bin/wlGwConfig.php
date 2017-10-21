<?php
/**
 * WiseLoop Graphic Works Configuration class
 * @author WiseLoop
 */
class wlGwConfig
{
    /**
     * Cache path<br/>
     * The cache path is the path where the resulted processed images are stored,
     * so that when an image already processed with a certain wlGwFxChain is requested,
     * the image stored in the cache will be served instead of processing it again;
     * in this way the serving speed will be much faster and the server load will be kept at minimum.
     */
    const CACHE_DIR = "./cache";
}
?>
