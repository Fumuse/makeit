<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

$arComponentDescription = array(
	'NAME' => getMessage('FILTER_SECTION_NAME'),
	'DESCRIPTION' => getMessage('FILTER_SECTION_DESCRIPTION'),
	'SORT' => 10,
	'PATH' => array(
		'ID' 	=> 	'makeitFilterSection',
		'NAME' 	=> 	getMessage('FILTER_SECTION_NAMESPACE_NAME')
	)
);