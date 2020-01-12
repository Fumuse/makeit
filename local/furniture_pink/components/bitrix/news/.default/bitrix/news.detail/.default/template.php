<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
?>
<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>
	<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<div class="news-date"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
	<?endif;?>
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<div class="news-detail">
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
 	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=Loc::getMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	</div>
</div>
<? /* news rating */ ?>
<div class="news-rating">
	<div class="news-rating--button news-rating--minus">
		<a href="javascript:void(0);" data-script="vote-minus"><?=Loc::getMessage('RATING')?> -</a>
	</div>
	<div class="news-rating--count">
		<?=$arResult["PROPERTIES"]["NEWS_RATING"]["VALUE"];?>
	</div>
	<div class="news-rating--button news-rating--plus">
		<a href="javascript:void(0);" data-script="vote-plus"><?=Loc::getMessage('RATING')?> +</a>
	</div>	
</div>
<div class="rating-error"></div>
<? /* information for ajax */ ?>
<script type="text/javascript">
BX.message({
	TEMPLATE_PATH: '<?=$this->GetFolder(); ?>',
	IBLOCK_ID:	'<?=$arParams['IBLOCK_ID']?>',
	ELEMENT_ID:	'<?=$arParams['ELEMENT_ID']?>',
	RATING_IBLOCK:	'<?=$arParams['RATING_NEWS_IBLOCK_ID']?>',
});
</script>