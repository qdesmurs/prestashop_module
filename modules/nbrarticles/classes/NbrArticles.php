<?php
// namespace Yolo;

class NbrArticles extends Module
{
    public function __construct()
    {
        $this->name = 'nbrarticles';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jean-Jeannine De La Tourette';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Doge2 Module lel 8D');
        $this->description = $this->l('Gné wassup yo?');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('NBRARTICLES_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return parent::install() &&
            $this->registerHook('leftColumn') &&
            $this->registerHook('header') &&
            Configuration::updateValue('NBRARTICLES_NAME', 'my friend');
    }
    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('NBRARTICLES_NAME')
        ) {
            return false;
        }

        return true;
    }
    public function hookDisplayLeftColumn($params)
    {
        $productObj = new Product();
        $products = $productObj->getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'DESC', false, true);
        $products1 = $productObj->getProducts(Context::getContext()->language->id, 0, 0, 'id_product', 'DESC', false, true )[0];
        $total = count($products);
        $total1 = $products1['name'];
        $this->context->smarty->assign(
            array(
                'nbr_article_total' => $total,
                'last_article' => $total1
                )
        );
        return $this->display(_PS_MODULE_DIR_."nbrarticles/nbrarticles.php", 'nbrarticles.tpl');
    }

    public function hookDisplayRightColumn($params)
    {
        return $this->hookDisplayLeftColumn($params);
    }

    public function hookDisplayHeader()
    {
        $this->context->controller->addCSS($this->_path.'css/nbrarticles.css', 'all');
    }
}
