<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

$arComponentDescription = array(
	'NAME' => getMessage('SECTION_CODE_NAME'),
	'DESCRIPTION' => getMessage('SECTION_CODE_DESCRIPTION'),
	'SORT' => 10,
	'PATH' => array(
		'ID' 	=> 	'makeit',
		'NAME' 	=> 	getMessage('SECTION_CODE_NAMESPACE_NAME')
	)
);