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

/* Init */
$sql = array();

/* Create Table in Database */
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'example_data` (
	`id_example_data` int(10) NOT NULL AUTO_INCREMENT,
	`lorem` varchar(50) NOT NULL,
	PRIMARY KEY (`id_example_data`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'example_data_lang` (
	`id_example_data` int(10) NOT NULL AUTO_INCREMENT,
	`id_lang` int(10) NOT NULL,
	`name` varchar(64) NOT NULL,
	UNIQUE KEY `example_data_lang_index` (`id_example_data`,`id_lang`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';