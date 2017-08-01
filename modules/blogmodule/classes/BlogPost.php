<?php

class BlogPost extends ObjectModel {
    public $id_blogmodule;
    public $my_module_date;
    public $blogmodule_name;
    public $my_module_content;
    public static $definition = array(
        'table' => 'blogmodule',
        'primary' => 'id_blogmodule',
        'fields' => array(
            'my_module_date' => array('type' => self::TYPE_DATE, 'validate' => 'isString'),
            'blogmodule_name' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'my_module_content' => array('type' => self::TYPE_STRING, 'validate' => 'isString')
        ),
    );
}

?>
