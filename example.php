<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * Module Example - Main file
 *
 * @category   	Module / documentation
 * @author     	PrestaEdit <j.danse@prestaedit.com>
 * @copyright  	2012-2013 PrestaEdit
 * @version   	1.5.1
 * @link       	http://www.prestaedit.com/
 * @since      	File available since Release 1.0
*/

/**
 * Module Example - Notes
*/
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

/**
 * Module Example - Todo
 * Integrer les langues (champs/value) (http://www.prestashop.com/forums/index.php?/topic/189016-questions-sur-la-creation-de-modules-mvc/page__view__findpost__p__936271)
 * Integrer un fichier � t�l�charger (http://www.prestashop.com/forums/index.php?/topic/189016-questions-sur-la-creation-de-modules-mvc/page__view__findpost__p__939093)
 * Integrer des commandes sur addRowAction
*/

/* Security */
if (!defined('_PS_VERSION_'))
	exit;

/* Checking compatibility with older PrestaShop and fixing it */
if (!defined('_MYSQL_ENGINE_'))
	define('_MYSQL_ENGINE_', 'MyISAM');

/* Loading Models */
require_once(_PS_MODULE_DIR_.'example/models/ExampleData.php');

class Example extends Module
{
	private $errors = null;

	public function __construct()
	{
		// Author of the module
		$this->author = 'PrestaEdit';
		// Name of the module ; the same that the directory and the module ClassName
		$this->name = 'example';
		// Tab where it's the module (administration, front_office_features, ...)
		$this->tab = 'others';
		// Current version of the module
		$this->version = '1.6.1';

		//	Min version of PrestaShop wich the module can be install
		$this->ps_versions_compliancy['min'] = '1.5';
		// Max version of PrestaShop wich the module can be install
		$this->ps_versions_compliancy['max'] = '1.6';
		// OR $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');

		//	The need_instance flag indicates whether to load the module's class when displaying the "Modules" page
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

		$this->errors = array();
	}

	public function install()
	{
		// Install SQL
		$sql = array();
		include(dirname(__FILE__).'/sql/install.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;

		// Install Tabs
		$parent_tab = new Tab();
		// Need a foreach for the language
		$parent_tab->name[$this->context->language->id] = $this->l('Main Tab Example');
		$parent_tab->class_name = 'AdminMainExample';
		$parent_tab->id_parent = 0; // Home tab
		$parent_tab->module = $this->name;
		$parent_tab->add();

		$tab = new Tab();
		// Need a foreach for the language
		$tab->name[$this->context->language->id] = $this->l('Tab Example');
		$tab->class_name = 'AdminExample';
		$tab->id_parent = $parent_tab->id;
		$tab->module = $this->name;
		$tab->add();

		//Init
		Configuration::updateValue('EXAMPLE_CONF', '');

		// Install Module
		// In this part, you don't need to add a hook in database, even if it's a new one.
		// The registerHook method will do it for your !
		return parent::install() && $this->registerHook('actionObjectExampleDataAddAfter');
	}

	public function uninstall()
	{
		// Uninstall SQL
		$sql = array();
		include(dirname(__FILE__).'/sql/uninstall.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;

		Configuration::deleteByName('EXAMPLE_CONF');

		// Uninstall Tabs
		$tab = new Tab((int)Tab::getIdFromClassName('AdminExample'));
		$tab->delete();

		$tab_main = new Tab((int)Tab::getIdFromClassName('AdminMainExample'));
		$tab_main->delete();

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
		if (Tools::isSubmit('submit'.Tools::ucfirst($this->name)))
		{
			$example_conf = Tools::getValue('EXAMPLE_CONF');

			Configuration::updateValue('EXAMPLE_CONF', $example_conf);

			if (isset($this->errors) && count($this->errors))
				$output .= $this->displayError(implode('<br />', $this->errors));
			else
				$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		return $output.$this->displayForm();
	}

	public function displayForm()
	{
		$this->context->smarty->assign('request_uri', Tools::safeOutput($_SERVER['REQUEST_URI']));
		$this->context->smarty->assign('path', $this->_path);
		$this->context->smarty->assign('EXAMPLE_CONF', pSQL(Tools::getValue('EXAMPLE_CONF', Configuration::get('EXAMPLE_CONF'))));
		$this->context->smarty->assign('submitName', 'submit'.Tools::ucfirst($this->name));
		$this->context->smarty->assign('errors', $this->errors);

		// You can return html, but I prefer this new version: use smarty in admin, :)
		return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}


	public function hookActionObjectExampleDataAddAfter($params)
	{
		/* Do something here... */
		$params = $params;

		return true;
	}
}
