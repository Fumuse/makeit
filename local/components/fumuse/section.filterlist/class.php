<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use \Bitrix\Main\Loader,
	\Bitrix\Main\Localization\Loc,
	\Bitrix\Main\Entity,
	\Bitrix\Highloadblock;

class testingSectionFilter extends \CBitrixComponent {
	public function takeHLData ($code) {
		if (Loader::includeModule("highloadblock")) {
			$hlBlocks = array();
			$hlBlock = Highloadblock\HighloadBlockTable::getList([
				'filter' => ['TABLE_NAME' => $code]
			]);
			
			while ($hlData = $hlBlock->fetch()) {
				$hlEntity = Highloadblock\HighloadBlockTable::compileEntity($hlData);
				$hlDataClass = $hlData['NAME'].'Table';
				
				$result = $hlDataClass::getList(array(
					 'select' 	=> 	array("*"),
					 'order' 	=> 	array('UF_NAME' =>	'ASC')
				));
				
				while ($row = $result->fetch()) {
					$hlBlocks[$hlData["TABLE_NAME"]][$row['ID']] = $row;
				};
			}
			
			return $hlBlocks;
		}
		return false;
	}
	
	public function executeComponent () {
		/* cached component */
		if ($this->StartResultCache()) {
			if (Loader::includeModule("iblock")) {
				/* take all properties type like list and directory */
				$arrList = array();
				/* lists */
				$propertyEnum = \CIBlockPropertyEnum::GetList(
					array(
						"SORT"	=>	"ASC", 
						"VALUE"	=>	"ASC"
					), 
					array(
						"IBLOCK_ID"			=>	$this->arParams['IBLOCK_ID']
					)
				);
				while ($propFields = $propertyEnum->GetNext()) {
					if (!isset($arrList[$propFields["PROPERTY_ID"]]))
						$arrList[$propFields["PROPERTY_ID"]] = array(
							"ID"				=>	$propFields["PROPERTY_ID"],
							"PROPERTY_CODE"		=>	$propFields["PROPERTY_CODE"],
							"PROPERTY_NAME"		=>	$propFields["PROPERTY_NAME"],
							"PROPERTY_SORT"		=>	$propFields["PROPERTY_SORT"],
							"TYPE"				=>	"L",
							"VALUE"				=>	array()
						);
						
					$arrList[$propFields["PROPERTY_ID"]]["VALUE"][$propFields["ID"]] = $propFields;
				}
				
				/* directories */
				$properties = \CIBlockProperty::GetList(
					array("SORT"	=>	"ASC"),
					array(
						"IBLOCK_ID"	=>	$this->arParams['IBLOCK_ID'],
						"USER_TYPE"	=>	"directory"
					)
				);

				$listDirectory = array();
				while ($propFields = $properties->GetNext()) {
					if ($propFields['USER_TYPE'] != "directory") continue;
					$listDirectory[$propFields["ID"]] = $propFields["USER_TYPE_SETTINGS"]["TABLE_NAME"];
					$propFields['TYPE']	=	'HL';
					$arrList[$propFields["ID"]] = $propFields;
				}
				/* take directories values */
				if (!empty($listDirectory)):
					$hlData = $this->takeHLData($listDirectory);
					if ($hlData):
						$listDirectory = array_flip($listDirectory);
						foreach ($hlData as $key => $value):
							$arrList[$listDirectory[$key]]['VALUE'] = $value;
						endforeach;
					endif;
				endif;
				
				
				$this->arResult['LISTS'] = $arrList;
				
				$this->IncludeComponentTemplate($this->template);
			}
		}
	}
}