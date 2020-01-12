<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

$arComponentParameters = Array(
	'PARAMETERS' => array(
		'IBLOCK_ID' => array(
			'NAME' => getMessage('FILTER_SECTION_IBLOCK'),
			'TYPE' => 'NUMBER'
		),
		"CACHE_TIME"  =>  array(
			"DEFAULT"	=>	36000000
		),
	)
);
