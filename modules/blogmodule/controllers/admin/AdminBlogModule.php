<?php
class AdminBlogModuleController extends ModuleAdminController {
    public function __construct()
   {
        $this->table = 'blogmodule';
        $this->className = 'BlogPost';
        $this->bootstrap = true;
        $this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
        $this->context = Context::getContext();

        $this->fields_list = array(
            'blogmodule_name' => array(
                'title' => $this->l('Blog'),
            ),
            'my_module_content' => array(
                'title' => $this->l('Text'),
            ),
            'my_module_date' => array(
                'title' => $this->l('Date'),
                'type' => 'date',
                )
        );
        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('Post'),
            ),
            'input' => array(
                array(
                'label' => $this->l('Titre'),
                'type' => 'text',
                'name' => 'blogmodule_name',
                ),
                array(
                'label' => $this->l('Contenu'),
                'type' => 'textarea',
                'name' => 'my_module_content',
                ),
                array(
                'label' => $this->l('Date'),
                'type' => 'date',
                'name' => 'my_module_date',
                ),
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );
        parent::__construct();
   }
}
