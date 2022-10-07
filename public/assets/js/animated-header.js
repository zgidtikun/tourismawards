jQuery(document).ready(function( $ ) {

var screen_w = $(window).width();

if(screen_w > 1024){
var speed = 0;
var header = 0;

$(window).scroll(function(){
    if($(document).scrollTop() > 0) {
		
		if(header == 0) {
			
           header = 1;
            $("#header").css({"top":'-50px'});
            $(".header-box img").css({"height":"40px"});
            $(".header-box-col.logo").css({"padding":"0 0 10px 0"});
            $(".header-box-col.menu ul").css({"align-items":"baseline"});
            $(".header-box-col.menu li").css({"padding-bottom":"15px"});
          //
        }
		
    } else {
        
		if(header == 1) {
			
           header = 0;
            $("#header").css({"top":'0px'});
            $(".header-box img").css({"height":"5vw"});
            $(".header-box-col.logo").css({"padding":"0 0 20px 0"});
            $(".header-box-col.menu ul").css({"align-items":"initial"});
            $(".header-box-col.menu li").css({"padding-bottom":"0"});
           //
        }  
    }
});

$(window).on('load',function () {   

if($(document).scrollTop() > 0) {
					
           header = 1;
            $("#header").css({"top":'-50px'});
            $(".header-box img").css({"height":"40px"});
            $(".header-box-col.logo").css({"padding":"0 0 10px 0"});
            $(".header-box-col.menu ul").css({"align-items":"baseline"});
            $(".header-box-col.menu li").css({"padding-bottom":"15px"});
          //
}

$('*[data-button]').click(function() {
    $('html, body').animate({
        scrollTop: $('*[data-section="'+$(this).attr('data-button')+'"]').offset().top
    }, speed);
});

function resize(){
	
    $('.tab').height(window.innerHeight);

	$('.tab-headline').each(function(index, element) {
	
	$(this).css('margin-left',-$(this).width()/2);
	$(this).css('margin-top',-$(this).height()/2);	
	
	});	
	
	}

$( window ).resize(function() {
resize();
});

resize();

});
}
});