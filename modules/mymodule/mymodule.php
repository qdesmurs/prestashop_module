<?php
require_once _PS_MODULE_DIR_.'/mymodule/classes/MyModule.php';
if (!defined('_PS_VERSION_')) {
    exit;
}
// Storing a serialized array.
Configuration::updateValue('MYMODULE_SETTINGS', serialize(array(true, true, false)));

// Retrieving the array.
$configuration_array = unserialize(Configuration::get('MYMODULE_SETTINGS'));
