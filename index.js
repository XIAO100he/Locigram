$(function() {
	var $imageSlide = $('.active');
	
	$('.fa-caret-left').click(function(){
		$imageSlide.removeClass('active');
//		$imageSlide.prev.addClass('active');
	});
	
	$('.swiper-btn_next').click(function(){
		$imageSlide.removeClass('active');
//		$imageSlide.next.addClass('active');
	});
	
})