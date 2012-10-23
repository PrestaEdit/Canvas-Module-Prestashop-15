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
}