/**
 * Created by dmunioz on 05/10/2015.
 */
jQuery(function ($) {
    /* ----------------------------------------------------------- */
    /*  2. Fixed Top Menubar
     /* ----------------------------------------------------------- */

    // For fixed top bar
    $(window).scroll(function () {

        if (($(window).scrollTop() > 100)  /*or $(window).height()*/) {
            $(".navbar-fixed-top").addClass('past-main');
        }
        else {
            $(".navbar-fixed-top").removeClass('past-main');
        }
    });
});