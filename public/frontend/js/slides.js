jQuery(function() {
	
	var topBtn = jQuery('#page-top');	
	topBtn.hide();
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 100)
			topBtn.fadeIn();
		else
			topBtn.fadeOut();
	});
	//スクロールしてトップ
    topBtn.click(function() {
		jQuery('body,html').animate({ scrollTop:0 }, 500);
		return false;
    });
});


$(function(){
	$('a[href^=\\#]').click(function(){
		var speed = 500;
		var href= $(this).attr("href");
		var target = $(href == "#" || href == "" ? 'html' : href);
		var position = target.offset().top;
		$("html, body").animate({scrollTop:position}, speed, "swing");
		return false;
	});
});

jQuery(function() {
	
	var topBtn = jQuery('#h-reg');	
	topBtn.hide();
	jQuery(window).scroll(function() {
		if (jQuery(this).scrollTop() > 100)
			topBtn.fadeIn();
		else
			topBtn.fadeOut();
	});

});
