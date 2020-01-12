<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Service\GeoIp\Manager;
\Bitrix\Main\Loader::includeModule('iblock');

/* take news current rating and update cached block */ 
$property = \CIBlockElement::getProperty($arParams['IBLOCK_ID'], $arParams['ELEMENT_ID'], array("sort", "asc"), array('CODE' => 'NEWS_RATING'));
$currentRatingCount = 0;
if ($arData = $property->GetNext())
	$currentRatingCount = !empty($arData['VALUE']) ? $arData['VALUE'] : 0;

/* check user vote for ip */
$userIPAdress = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();
$votes = \CIBlockElement::GetList(
	array("SORT" => "ASC"),
	array("IBLOCK_ID" => $arParams['RATING_NEWS_IBLOCK_ID'], "PROPERTY_NEWS_ID" => $arParams['ELEMENT_ID'], "NAME" => $userIPAdress),
	false,
	false,
	array("ID")
);

$votedArticle = false;
if ($arVote = $votes->Fetch())
	$votedArticle = true; 
?>
<script type="text/javascript">
	BX.message({
		CURRENT_RATING:	'<?=$currentRatingCount?>',
		VOTED_ARTICLE:	'<?=$votedArticle?>',
	});
</script>