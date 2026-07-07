/*
* Primary JS Libs
* Written by Fathur Rachman W
* contact : fathur.rachman@mobileforce.mobi
*/

$(document).ready(function() {

	// menu bold fix
	// $('.mainmenu > li').each(function(){
	// 	wid = $(this).width();
	// 	$(this).css('width', wid+'px');
	// });

	var slidebar = new slidebars();
	slidebar.init();

	$(".gotop").click(function() {
		$('html, body').animate({scrollTop:0}, 600);
	})

	$(".openmobilemenu").click(function() {
		slidebar.toggle('id-1');
	})

})

function openPopup(id)
{
    var closep = closePopup();
    if(closep==true) {
        $('#popup-overlay').fadeIn(function(){
            $('#'+id).fadeIn();
            scroller(id);
            $('body').css('overflow', 'hidden');
        });
    }
}

function closePopup() {
    $('#popup-overlay').fadeOut(function(){
        $('.popup').fadeOut();
		$('body').css('overflow', 'visible');
    });
    return true;
}

function scroller(id) {
    var $target = $('#'+id);

    console.log("#"+id);
    console.log($target.offset().top);

    $("html, body").stop().animate({
        'scrollTop' : $target.offset().top
    }, 900, 'swing', function() {
        // window.location.hash = target;
    })
}

function whichTransitionEvent(){
    var t;
    var el = document.createElement('fakeelement');
    var transitions = {
      'transition':'transitionend',
      'OTransition':'oTransitionEnd',
      'MozTransition':'transitionend',
      'WebkitTransition':'webkitTransitionEnd'
    }

    for(t in transitions){
        if( el.style[t] !== undefined ){
            return transitions[t];
        }
    }
}