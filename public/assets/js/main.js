//------------------- To Top ----------------------//
jQuery(document).ready(function($){
	var offset = 300,
		offset_opacity = 1200,
		scroll_top_duration = 500,
		$back_to_top = $('.cd-top');

	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) { 
			$back_to_top.addClass('cd-fade-out');
		}
	});

	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

});

//------------------- regis-form-step ----------------------//
jQuery(document).ready(function(){
    var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
    console.log(pgurl);
	$(".regis-form-step a").each(function(){
	if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
		$(this).addClass("active");
	});
	$(".regis-form-step a").each(function(){
	if($(this).attr("href") == 'index.html' || $(this).attr("href") == '' )
		$(this).removeClass("active");
	});
});