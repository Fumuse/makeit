$(function () {
	$(document).on('click', '.news-rating--button.button-active', function () {
		$('.news-rating--button').removeClass('button-active');
		var script = $(this).find('a').data('script');
		BX.ajax({
				url: BX.message('TEMPLATE_PATH')+'/ajax/rating.php',
				data: {
					SCRIPT: script,
					IBLOCK_ID: BX.message('IBLOCK_ID'),
					ELEMENT_ID: BX.message('ELEMENT_ID'),
					RATING_IBLOCK: BX.message('RATING_IBLOCK'),
				},
				method: 'POST',
				async: true,
				start: true,
				cache: false,
				onsuccess: function(data){
					if (data != "") {
						var jsonDATA = JSON.parse(data);
						if (!!jsonDATA['error']) {
							$('.rating-error').text(jsonDATA['text']).show('slow');
							setTimeout(function () {
								$('.rating-error').hide('slow');
							}, 3000);
						}
						else
							$('.news-rating--count').text(jsonDATA['ratingCount']);
					}
				}
		});
	});
	
	$('.news-rating--count').text(BX.message('CURRENT_RATING'));
	if (!BX.message('VOTED_ARTICLE'))
		$('.news-rating--button').addClass('button-active');
});