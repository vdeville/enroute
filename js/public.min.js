jQuery(document).ready(function($){
	$('#faqss-modern .faqss-aside ul li a').click(function(e){
		e.preventDefault();
		var faqssElement = $(this).attr('href');
		$('.faqss-section').hide();
		$(faqssElement).show();
		$('#faqss-modern .faqss-aside ul li a').removeClass('active');
		$(this).addClass('active');
	});

	$('#faqss-modern .faqss-section .faqss-item h6 a').click(function(e){
		e.preventDefault();
		if( $(this).hasClass('faqss-fullitems') ){
			var faqssElement = $(this).parents('.faqss-section').attr('class');
			$('.' + faqssElement + ' .faqss-item .faqss-content').hide();
		} else {
			var faqssElement = $(this).parents('.faqss-section').attr('id');
			$('#' + faqssElement + ' .faqss-item .faqss-content').hide();
		}
		$(this).parent().next().show();
	});
});
