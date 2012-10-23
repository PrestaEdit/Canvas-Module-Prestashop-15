<?php
/**
 * Module Example - Main file
 *
 * @category   	Module / checkout
 * @author     	PrestaEdit <j.danse@prestaedit.com>
 * @copyright  	2012 PrestaEdit
 * @version   	1.0	
 * @link       	http://www.prestaedit.com/
 * @since      	File available since Release 1.0
*/

// TODO
// Integrer les langues (champs/value) (http://www.prestashop.com/forums/index.php?/topic/189016-questions-sur-la-creation-de-modules-mvc/page__view__findpost__p__936271)
// Integrer un fichier à télécharger (http://www.prestashop.com/forums/index.php?/topic/189016-questions-sur-la-creation-de-modules-mvc/page__view__findpost__p__939093)
// Integrer des commandes sur addRowAction

// Security
if (!defined('_PS_VERSION_'))
	exit;
	
// Checking compatibility with older PrestaShop and fixing it
if (!defined('_MYSQL_ENGINE_'))
	define('_MYSQL_ENGINE_', 'MyISAM');

// Loading Models
require_once(_PS_MODULE_DIR_ . 'example/models/ExampleData.php');

class Example extends Module
{			
  public function __construct()
  {  		  	
	  $this->name = 'example';
	  $this->tab = 'others';
	  $this->version = '1.4';
	  $this->ps_versions_compliancy['min'] = '1.5.0.1'; 
		$this->author = 'PrestaEdit';
		$this->need_instance = 0;
	
	  parent::__construct();
	
		$this->displayName = $this->l('Example');
	  $this->description = $this->l('Module Example');
	  	  
		$this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');
	  
	  if ($this->active && Configuration::get('EXAMPLE_CONF') == '')
			$this->warning = $this->l('You have to configure your module');
  }
  

	public function install()
	{
		// Install SQL
		include(dirname(__FILE__).'/sql/install.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;
								
		// Install Tabs
		$parent_tab = new Tab();
		$parent_tab->name = 'Main Tab Example';
		$parent_tab->class_name = 'AdminMainExample';
		$parent_tab->id_parent = 0;
		$parent_tab->module = $this->name;
		$parent_tab->add();
		
		
		$tab = new Tab();
		$tab->name = 'Tab Example';
		$tab->class_name = 'AdminExample';
		$tab->id_parent = $parent_tab->id;
		$tab->module = $this->name;
		$tab->add();
		
		
		//Init
		Configuration::updateValue('EXAMPLE_CONF', '');	
		
		// Install Module  
   	return parent::install()
		&& $this->registerHook('actionObjectExampleDataAddAfter');					
  }    
  
  public function uninstall()
	{
		// Uninstall SQL
		include(dirname(__FILE__).'/sql/uninstall.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;
				
		Configuration::deleteByName('EXAMPLE_CONF');

		// Uninstall Tabs
		$tab = new Tab((int)Tab::getIdFromClassName('AdminExample'));
		$tab->delete();
		
		// Uninstall Module
		if (!parent::uninstall() ||
		    !$this->unregisterHook('actionObjectExampleDataAddAfter'))
			return false;

		return true;
	}
	
	public function getContent()
	{
		$output = '<h2>'.$this->displayName.'</h2>';
		if (Tools::isSubmit('submit'.ucfirst($this->name)))
		{
			$EXAMPLE_CONF = Tools::getValue('EXAMPLE_CONF');
			
			Configuration::updateValue('EXAMPLE_CONF', $EXAMPLE_CONF);
			
			if (isset($errors) && count($errors))
				$output .= $this->displayError(implode('<br />', $errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}
	
	public function displayForm()
	{		
		if(isset($errors))
			$this->context->smarty->assign('errors', $errors);
		
		$this->context->smarty->assign('request_uri', Tools::safeOutput($_SERVER['REQUEST_URI']));
		$this->context->smarty->assign('path', $this->_path);
		$this->context->smarty->assign('EXAMPLE_CONF', pSQL(Tools::getValue('EXAMPLE_CONF', Configuration::get('EXAMPLE_CONF'))));
		$this->context->smarty->assign('submitName', 'submit'.ucfirst($this->name));
		
		return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}
	
	
	public function hookActionObjectExampleDataAddAfter($params)
	{
		// Do something here...
		// ...
		return true;
	}
}
