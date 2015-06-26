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

class ExampleData extends ObjectModel
{
	/** @var string Name */
	public $name;
	public $lorem;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'example_data',
		'primary' => 'id_example_data',
		'multilang' => true,
		'fields' => array(
			/* Lang fields */
			'name' => 		array('type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isGenericName', 'required' => true, 'size' => 64),
			'lorem' => 		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false, 'size' => 64),
		),
	);
	
	/*
	Si besoin d'upload d'image
	 On surcharge le constructeur afin de pouvoir bénéficier de l'upload d'image dans le controller
	 @TODO : verifier s'il est possible d'uploader directemetn dans un dossier du module en utilisant
	 fieldImageSettings dan le controler, par défaut le chemin part de _PS_IMG_DIR_ dans la fonction qui gère l'upload.
	 
	
	*/
	public function __construct($id_category = null, $id_lang = null, $id_shop = null)
	{
		parent::__construct($id_category, $id_lang, $id_shop);
		$this->id_image = ($this->id && file_exists(_PS_IMG_DIR_.'example/'.(int)$this->id.'.jpg')) ? (int)$this->id : false;
		$this->image_dir = _PS_IMG_DIR_.'example/';
		
		
	}
	
}
