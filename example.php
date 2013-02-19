<?php
/**
 * Module Example - Main file
 *
 * @category   	Module / checkout
 * @author     	PrestaEdit <j.danse@prestaedit.com>
 * @copyright  	2012 PrestaEdit
 * @version   	1.5
 * @link       	http://www.prestaedit.com/
 * @since      	File available since Release 1.0
*/

//
// NOTES
//
/*
 	// Know if the module is enabled or not
 	Module::isEnabled($this->name); 
 
 	// Know if the module is install or not
	Module::isInstalled($this->name); 

	// Know if the module is registerd in one particular hook
	$this->isRegisteredInHook('hook_name');
	
	// Use the cache
	$this->isCached($template);
	
	//	Check if the module is transplantable on the hook in parameter
	$this->isHookableOn('hook_name');
	
	// Get errors, warning, ...
	$this->getErrors();
	$this->getConfirmations();
	
	// add a warning message to display at the top of the admin page
	$this->adminDisplayWarning('message');
	
	// add a info message to display at the top of the admin page
	adminDisplayInformation('message');
	
	// You don't need to call this one BUT, if you want to make an override in 
	// a new version of your module, you will need to call this one (it's call
	// only in install, at first)
	$this->installOverrides();
	
	// You can disable the module for one shop (the actual in context)
	$this->disable();
	// ... or for all shop
	$this->disabel(true);
*/

// TODO
// Integrer les langues (champs/value) (http://www.prestashop.com/forums/index.php?/topic/189016-questions-sur-la-creation-de-modules-mvc/page__view__findpost__p__936271)
// Integrer un fichier � t�l�charger (http://www.prestashop.com/forums/index.php?/topic/189016-questions-sur-la-creation-de-modules-mvc/page__view__findpost__p__939093)
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
		// Author of the module
		$this->author = 'PrestaEdit'; 
  	// Name of the module ; the same that the directory and the module ClassName
	  $this->name = 'example';
	  // Tab where it's the module (administration, front_office_features, ...)
	  $this->tab = 'others';	
	  // Current version of the module
	  $this->version = '1.5';
	  
	  // Min version of PrestaShop wich the module can be install
	  $this->ps_versions_compliancy['min'] = '1.5';
	  // Max version of PrestaShop wich the module can be install
	  $this->ps_versions_compliancy['max'] = '1.6';
	  // OR $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
		
		// 	The need_instance flag indicates whether to load the module's class when displaying the "Modules" page 
		//	in the back-office. If set at 0, the module will not be loaded, and therefore will spend less resources 
		//	to generate the page module. If your modules needs to display a warning message in the "Modules" page, 
		//	then you must set this attribute to 1.
		$this->need_instance = 0; 
		
		// Modules needed for install
		$this->dependencies = array();
		// e.g. $this->dependencies = array('blockcart', 'blockcms');
		
		// Limited country 
		$this->limited_countries = array(); 
		// e.g. $this->limited_countries = array('fr', 'us');
					
	  parent::__construct();
		
		// Name in the modules list
		$this->displayName = $this->l('Example');
		// A little description of the module
	  $this->description = $this->l('Module Example');
	  	  
	  // Message show when you wan to delete the module	  
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
		$parent_tab->id_parent = 0; // Home tab
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
		// In this part, you don't need to add a hook in database, even if it's a new one. 
		// The registerHook method will do it for your !		
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
		$tabMain = new Tab((int)Tab::getIdFromClassName('AdminMainExample'));
		$tabMain->delete();
		
		// Uninstall Module
		if (!parent::uninstall())
			return false;
			
		// You don't need to call this one because uninstall do it for you
		// !$this->unregisterHook('actionObjectExampleDataAddAfter')

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
		
		// You can return html, but I prefer this new version: use smarty in admin, :)
		return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}
	
	
	public function hookActionObjectExampleDataAddAfter($params)
	{
		// Do something here...
		// ...
		return true;
	}
}
