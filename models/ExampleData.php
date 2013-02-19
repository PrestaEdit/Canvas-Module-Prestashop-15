<?php
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
			// Lang fields
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
