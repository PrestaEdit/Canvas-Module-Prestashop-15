<?php

	// Init
	$sql = array();

	// Create Table in Database
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
	