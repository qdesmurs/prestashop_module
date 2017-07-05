<?php
require_once _PS_MODULE_DIR_.'/nbrarticles/classes/NbrArticles.php';
if (!defined('_PS_VERSION_')) {
    exit;
}
// Storing a serialized array.
Configuration::updateValue('NBRARTICLES_SETTINGS', serialize(array(true, true, false)));

// Retrieving the array.
$configuration_array = unserialize(Configuration::get('NBRARTICLES_SETTINGS'));
