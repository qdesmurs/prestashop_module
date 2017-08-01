<?php

class BlogModule extends Module{
    public function __construct(){
        $this->name = $this->l('blogmodule');
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jean-Jeannine De La Tourette';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('My blog');
        $this->description = $this->l('blog null');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        if (!Configuration::get('BLOGMODULE_NAME'))
           $this->warning = $this->l('No name provided');
    }
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        if (!parent::install()
            || !$this->registerHook('admingc')
            || !$this->registerHook('leftColumn')
            || !$this->registerHook('header')
            || !Configuration::updateValue('BLOGMODULE_NAME', 'hello world')
            || !$this->installDb()
            || !$this->installTab()
        ) {
            return false;
        }
        return true;
    }
    public function installTab()
    {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name = 'AdminBlogModule';
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Blog Module';
        }
        $tab->id_parent = 0;
        $tab->module = $this->name;
        return $tab->add();
    }
    public  function installDb()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'blogmodule` (
            `id_blogmodule` int(11) NOT NULL AUTO_INCREMENT,
            `blogmodule_name` varchar(50) NOT NULL,
            `my_module_content` varchar(200) NOT NULL,
            `my_module_date` datetime NOT NULL,
            PRIMARY KEY (`id_blogmodule`))';
        return Db::getInstance()->execute($sql);
    }
    public function uninstallDb()
    {
      $sql = 'DROP TABLE '._DB_PREFIX_.'blogmodule';
      DB::getInstance()->execute($sql);
      return true;
    }
    public function uninstall(){
        $tab = new Tab((int)Tab::getIdFromClassName('AdminBlogModule'));
        $tab->delete();
        if (!parent::uninstall()
            || !Configuration::deleteByName('blogmodule_NAME')
            || !$this->uninstallDb()
        ){
            return false;
        }
        return true;
    }
    public function hookadmingc(){

        $this->smarty->assign(array(
            'ciao' => 'hola'
        ));
        return $this->display(__FILE__, 'Admin.tpl');
    }
    public function getContent(){
    $output = null;
    if (Tools::isSubmit('submit'.$this->name)){
        $my_title = strval(Tools::getValue('Title'));
        $my_content = strval(Tools::getValue('Content'));
        $my_date = strval(Tools::getValue('Date'));
        if (!$my_title
          || empty($my_title)
          || !Validate::isGenericName($my_title)){
            $output .= $this->displayError($this->l('Invalid Configuration value'));
        }
        else{
            Configuration::updateValue('Title', $my_title);
            Configuration::updateValue('Content', $my_content);
            Configuration::updateValue('Date', $my_date);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }
    }
    return $output.$this->displayForm();
    }
    public function displayForm(){
    // Get default language
    $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');
    // Init Fields form array
    $fields_form[0]['form'] = array(
        'legend' => array(
            'title' => $this->l('Settings'),
        ),
        'input' => array(
            array(
                'type' => 'text',
                'label' => $this->l('Titre'),
                'name' => 'Title',
                'size' => 20,
                'required' => true
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Contenu'),
                'name' => 'Content',
                'size' => 250,
                'required' => true
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Date'),
                'name' => 'Date',
                'size' => 20,
                'required' => true
            )
        ),
        'submit' => array(
            'title' => $this->l('Save'),
            'Content' => $this->l('Save'),
            'Date' => $this->l('Save'),
            'class' => 'btn btn-default pull-right'
        )
    );
    $helper = new HelperForm();
    // Module, token and currentIndex
    $helper->module = $this;
    $helper->name_controller = $this->name;
    $helper->token = Tools::getAdminTokenLite('AdminModules');
    $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;
    // Language
    $helper->default_form_language = $default_lang;
    $helper->allow_employee_form_lang = $default_lang;
    // Title and toolbar
    $helper->title = $this->displayName;
    $helper->show_toolbar = true;        // false -> remove toolbar
    $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
    $helper->submit_action = 'submit'.$this->name;
    $helper->toolbar_btn = array(
        'save' =>
        array(
            'desc' => $this->l('Save'),
            'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
            '&token='.Tools::getAdminTokenLite('AdminModules'),
        ),
        'back' => array(
            'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
            'desc' => $this->l('Back to list')
        )
    );
    // Load current value
    $helper->fields_value['Title'] = Configuration::get('Title');
    $helper->fields_value['Content'] = Configuration::get('Content');
    $helper->fields_value['Date'] = Configuration::get('Date');
    return $helper->generateForm($fields_form);
    }
    public function hookDisplayHome($params)
    {
        // $productObj = new Product();
        // $products = $productObj->getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'DESC', false, true );
        // $total = count($products);


    }
    public function hookDisplayLeftColumn($params)
    {
        $this->context->smarty->assign(
            array(
            'my_module_name' => Configuration::get('BLOGMODULE_NAME'),
            'my_module_link' => $this->context->link->getModuleLink('blogmodule', 'display'),
            'my_module_message' => $this->l('This is a simple text message')
          )
      );
      return $this->display(_PS_MODULE_DIR_.$this->name, 'blogmodule.tpl');
    }
}
?>
