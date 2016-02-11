/**
 * Created by dmunioz on 28/12/2015.
 * Luego de 5 segundos cambiará al section about, siempre y cuando no se haya hecho un scroll > 100
 */
$(window).load(function () {
    setTimeout(function(){
        //do what you need here

    //normally you'd wait for document.ready, but you'd likely to want to wait
    //for images to load in case they reflow the page
    var ScrollTop = parseInt($(window).scrollTop());
    console.log(ScrollTop);

    if (ScrollTop < 100) {
        $('body').delay(5000) //wait 5 seconds
            .animate({
                //animate jQuery's custom "scrollTop" style
                //grab the value as the offset of #second from the top of the page
                'scrollTop': $('#about').offset().top
            }, 900); //animate over 300ms, change this to however long you want it to animate for
    }
    }, 2000);
});