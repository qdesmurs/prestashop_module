<?php
if (!defined('_PS_VERSION_')) {
    exit;
}
require_once _PS_MODULE_DIR_.'/blogmodule/classes/BlogModule.php';
require_once _PS_MODULE_DIR_.'/blogmodule/classes/BlogPost.php';
// Storing a serialized array.
Configuration::updateValue('BLOGMODULE_SETTINGS', serialize(array(true, true, false)));

// Retrieving the array.
$configuration_array = unserialize(Configuration::get('BLOGMODULE_SETTINGS'));
