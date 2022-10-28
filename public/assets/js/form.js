//------------------- regis-form-step ----------------------//
jQuery(document).ready(function(){
var screen_w = $(window).width();
var screen_h = $(window).height();

var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
    // alert(pgurl);
	$(".regis-form-step a").each(function(){
	if($(this).attr("href") == pgurl || $(this).attr("href") == '' ){
		$(this).addClass("active");}
	});

	if(screen_w < 768 && screen_h > screen_w){
$("html , body").animate({scrollTop : $('a[name = pageform]').offset().top},500);

			// hide a other and show only a thispage
					var datatab = $('.regis-form-step a[href="'+pgurl+'"]').attr('data-tab');
					var datalink = $('.btn-form-step').length;
					var datalinkaray = [];
					for(var i = 1 ; i <= datalink;){
  datalinkaray[i] = $('.btn-form-step[data-tab="'+i+'"]').attr('data-tab');
  i++
}
var maxvaldatalink = datalinkaray.reduce(function(a, b) { return Math.max(a, b); });

					$('.regis-form-step a').css("display","none");
					$(".regis-form-step a").each(function(){
										if($(this).attr("href") == pgurl){
										
											$(this).css({"display":"inline-flex","z-index":"1"});

								// first page prev don't click
												if(datatab == 1){
												$('.mobileprev').css({"opacity":"0.25","visibility":"visible","z-index":"0","cursor": "not-allowed"});
												$('.regis-form-step a[data-tab="'+ datatab +'"]').attr('href', "javascript:void(0)");
												$('.regis-form-step a').removeClass("btn-prev");
												}

								// first page prev don't click
												if(datatab == maxvaldatalink){
												$('.mobilenext').css({"opacity":"0.25","visibility":"visible","z-index":"0","cursor": "not-allowed"});
												$('.regis-form-step a[data-tab="'+ datatab +'"]').attr('href', "javascript:void(0)");
												$('.regis-form-step a').removeClass("btn-next");
												}

										}
		});

$('.btn-prev').click(function(){
datatab--;
var prevPage = $('.regis-form-step a[data-tab="'+ datatab +'"]').attr("href");
location.href = prevPage;
});

$('.btn-next').click(function(){
datatab++;
var nextPage = $('.regis-form-step a[data-tab="'+ datatab +'"]').attr("href");
location.href = nextPage;
});

}

});

jQuery(document).ready(function(){ //input value hide label
$('.btn-inpreset').hide();
    $('.regis-form-data input').keypress(function(){
    var datatab = $(this).attr('data-tab');
        $('.btn-inpreset[data-tab="'+datatab+'"]').show();
    });
    $('.regis-form-data textarea').keypress(function(){
    var datatab = $(this).attr('data-tab');
        $('.btn-inpreset[data-tab="'+datatab+'"]').show();
    });
    $('.btn-inpreset').click(function(){
    var datatab = $(this).attr('data-tab');
        $('.inputfield input[data-tab="'+datatab+'"]').val('');
        $('.inputfield textarea[data-tab="'+datatab+'"]').val('');
        $(this).hide();
    });

});