<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

$arComponentParameters = Array(
	'PARAMETERS' => array(
		'SECTION_CODE' => array(
			'NAME' => getMessage('SECTION_CODE_ID'),
			'TYPE' => 'STRING'
		),
		"CACHE_TIME"  =>  array(
			"DEFAULT"	=>	36000000
		),
	)
);
