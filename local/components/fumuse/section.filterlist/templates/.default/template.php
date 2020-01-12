<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
$page = $APPLICATION->GetCurPage();
?>
<div class="flex-box">
	<? if (!empty($arResult['LISTS'])): 
		foreach ($arResult['LISTS'] as $property): ?>
		<div class="inner-box">
			<ul>
			<? foreach ($property['VALUE'] as $key => $value): ?>
				<li><a href="<?=$page?>?<?=
				($property['TYPE'] == "L") ? 
					"filter_field={$property["PROPERTY_CODE"]}_VALUE&filter_value={$value["VALUE"]}" 
					: 
					"filter_field={$property["CODE"]}&filter_value={$value["UF_XML_ID"]}"
				?>"><?=(isset($value["VALUE"]) ? $value["VALUE"] : $value["UF_NAME"])?></a></li>
			<? endforeach;?>
			</ul>
		</div>
	<? 	endforeach;
	endif; ?>
</div>
