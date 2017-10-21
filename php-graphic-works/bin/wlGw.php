<?php
/**
 * WiseLoop Graphic Works entry point<br/>
 * It creates an Autoloader for loading the classes only when needed and checks if the current platform supports graphic manipulations.<br/>
 * You sould include only this file in you application; the Autoloader will do the rest.
 * @author WiseLoop
 */
require_once (dirname(__FILE__)."/wlGwAutoloader.php");
$autoLoader = new wlGwAutoloader();
$autoLoader->addPath(dirname(__FILE__));
$autoLoader->register();

try
{
    wlGwUtils::checkPlatform();
}catch(Exception $ex)
{
    die($ex->getMessage());
}
?>