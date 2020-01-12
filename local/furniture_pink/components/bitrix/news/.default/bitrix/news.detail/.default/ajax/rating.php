<?
define("NO_KEEP_STATISTIC", true);
define("PUBLIC_AJAX_MODE", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use \Bitrix\Main\Service\GeoIp\Manager,
	\Bitrix\Main\Localization\Loc;
	
Loc::loadMessages(__FILE__);

$data = $_POST;

if (empty($data) || empty($data['RATING_IBLOCK']) || empty($data['IBLOCK_ID']) || empty($data['ELEMENT_ID'])) {
	echo json_encode(array(
		"error"	=>	true,
		"text"	=>	Loc::getMessage('RATING_ERROR')
	));
	die();
}

if (\Bitrix\Main\Loader::includeModule('iblock')):
	/* check user vote for ip */
	$userIPAdress = \Bitrix\Main\Service\GeoIp\Manager::getRealIp();
	$votes = \CIBlockElement::GetList(
		array("SORT" => "ASC"),
		array("IBLOCK_ID" => $data['RATING_IBLOCK'], "PROPERTY_NEWS_ID" => $data['ELEMENT_ID'], "NAME" => $userIPAdress),
		false,
		false,
		array("ID")
	);
	
	if ($arVote = $votes->Fetch()) {
		echo json_encode(array(
			"error"	=>	true,
			"text"	=>	Loc::getMessage('RATING_IP_ERROR')
		));
		die();	
	}
	/* ==================== */

	/* add user vote to IB */	
	$element = new \CIBlockElement;
	if (!$element->Add(
		array(
			"IBLOCK_ID"			=>	$data['RATING_IBLOCK'],
			"NAME"				=>	$userIPAdress,
			"PROPERTY_VALUES"	=>	array(
				"NEWS_ID"		=>	$data['ELEMENT_ID'],
				"VOTE_COUNT"	=>	($data['SCRIPT'] == "vote-minus") ? -1 : 1
			)
		))) {
		echo json_encode(array(
			"error"	=>	true,
			"text"	=>	Loc::getMessage('RATING_ERROR')
		));
		die();	
	}
	/* ==================== */
	
	/* take news current rating */ 
	$property = \CIBlockElement::getProperty($data['IBLOCK_ID'], $data['ELEMENT_ID'], array("sort", "asc"), array('CODE' => 'NEWS_RATING'));
	$currentRatingCount = 0;
	if ($arData = $property->GetNext())
		$currentRatingCount = !empty($arData['VALUE']) ? $arData['VALUE'] : 0;

	if ($data['SCRIPT'] == "vote-minus")
		$currentRatingCount--;
	else
		$currentRatingCount++;
	/* ==================== */
	
	/* update news current rating */ 
	\CIBlockElement::SetPropertyValuesEx(
	   $data['ELEMENT_ID'],
	   $data['IBLOCK_ID'],
	   array("NEWS_RATING"	=>	$currentRatingCount)
	);
	/* ==================== */
	
	echo json_encode(array(
		"success"		=>	true,
		"text"			=>	Loc::getMessage('RATING_SUCCESS'),
		"ratingCount"	=>	$currentRatingCount
	));
	die();
else:
	echo json_encode(array(
		"error"	=>	true,
		"text"	=>	Loc::getMessage('RATING_ERROR')
	));
	die();	
endif;