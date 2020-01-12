<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

use \Bitrix\Main\Loader,
	\Bitrix\Iblock;

class testingSectionCode extends \CBitrixComponent {
	public static function getSection ($code, $cacheTime = 36000000) {
		if (empty($code))
			return false;

		$cacheId = "sectionByCode_".$code;
		$cachePath = "sectionByCode";
		$obCache = new CPHPCache();

		if ($cacheTime > 0 && $obCache->InitCache($cacheTime, $cacheId, $cachePath)) {
			 $arResult = $obCache->GetVars();
		} else
			 $arResult = array();
		
		if (empty($arResult)) {
			$section = \Bitrix\Iblock\SectionTable::getList(array(
				"select"	=>	array("*"),
				"order"		=>	array("SORT"	=>	"ASC"),
				"filter"	=>	array("=CODE"	=>	$code)
			));
			$arResult = array();
			while ($data = $section->fetch()) {
				$arResult[$data['ID']] = $data;
			}

			if ($cacheTime > 0) {
				$obCache->StartDataCache($cacheTime, $cacheId, $cachePath);
				$obCache->EndDataCache(array("arResult" => $arResult));
			}
		}
		
		return $arResult;
	}

	public function executeComponent () {
		echo "<pre>";
		var_dump(self::getSection($this->arParams['SECTION_CODE']));
		echo "</pre>";
	}
}
