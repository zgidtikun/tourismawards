var speed = 0;
var header = 0;

$(window).scroll(function(){
    if($(document).scrollTop() > 0) {
		
		if(header == 0) {
			
           header = 1;
          //
        }
		
    } else {
        
		if(header == 1) {
			
           header = 0;
           //
        }  
    }
});

$(window).on('load',function () {   

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