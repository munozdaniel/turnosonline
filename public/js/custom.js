/**
 * SinglePro HTML 2.0
 * Template Scripts
 * Created by WpFreeware Team

 Custom JS

 1. Superslides Slider
 2. Fixed Top Menubar (Utilizado en un archivo aparte.)
 3. Featured Slider
 4. Skill Circle
 5. Wow animation
 6. Project Counter
 7. TEAM SLIDER
 8. BLOG SLIDER
 9. TESTIMONIAL SLIDER
 10. CLIENTS SLIDER
 11. Google Map
 12. SCROLL TOP BUTTON
 13. PRELOADER
 14. MENU SCROLL
 15. MOBILE MENU CLOSE
 16. DISMINUIR VELOCIDAD AL HACER CLICK EN CIERTOS LINKS.

 **/

jQuery(function ($) {




    /* ----------------------------------------------------------- */
    /*  4. Skill Circle
     /* ----------------------------------------------------------- */




    /* ----------------------------------------------------------- */
    /*  5. Wow smooth animation
     /* ----------------------------------------------------------- */

    wow = new WOW(
        {
            animateClass: 'animated',
            offset: 100
        }
    );
    wow.init();




    /* ----------------------------------------------------------- */
    /*  12. SCROLL TOP BUTTON
     /* ----------------------------------------------------------- */

    //Check to see if the window is top if not then display button

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });

    //Click event to scroll to top

    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });


    /* ----------------------------------------------------------- */
    /*  13. PRELOADER
     /* ----------------------------------------------------------- */

    jQuery(window).load(function () { // makes sure the whole site is loaded
        $('#status').fadeOut(); // will first fade out the loading animation
        $('#preloader').delay(100).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(100).css({'overflow': 'visible'});
    })


    /* ----------------------------------------------------------- */
    /*  14. MENU SCROLL
     /* ----------------------------------------------------------- */

    //MENU SCROLLING WITH ACTIVE ITEM SELECTED

    // Cache selectors
    var lastId,
        topMenu = $("#top-menu"),
        topMenuHeight = topMenu.outerHeight() + 13,
    // All list items
        menuItems = topMenu.find("a.si_recorrer"),
    // Anchors corresponding to menu items
        scrollItems = menuItems.map(function () {
            var item = $($(this).attr("href"));
            if (item.length) {
                return item;
            }
        });

    // Bind click handler to menu items
    // so we can get a fancy scroll animation
    menuItems.click(function (e) {
        // Consulto si el elemento tiene el atributo href. porque el submenu no lo tiene.
        if ( $(this).attr('href') ) {
            var href = $(this).attr("href"),
                offsetTop = href === "#" ? 0 : $(href).offset().top - topMenuHeight + 1;
            $('html, body').stop().animate({
                scrollTop: offsetTop
            }, 900);
            e.preventDefault();
        }
    });

    // Bind to scroll
    $(window).scroll(function () {
        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight;

        // Get id of current scroll item
        var cur = scrollItems.map(function () {
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .parent().removeClass("active")
                .end().filter("[href=#" + id + "]").parent().addClass("active");
        }
    })


    /* ----------------------------------------------------------- */
    /*  15. MOBILE MENU ACTIVE CLOSE
     /* ----------------------------------------------------------- */

    $('.navbar-nav').on('click', 'li a', function () {
        $('.navbar-collapse').collapse('hide');
    });

    /* ----------------------------------------------------------- */
    /*  16. SCROLL LENTO PARA LOS QUE TENGAN LA CLASE <a class='slow'
     /* ----------------------------------------------------------- */
    $(function () {

        function filterPath(string) {
            return string
                .replace(/^\//, '')
                .replace(/(index|default).[a-zA-Z]{3,4}$/, '')
                .replace(/\/$/, '');
        }

        var locationPath = filterPath(location.pathname);
        var scrollElem = scrollableElement('html', 'body');

        // Any links with hash tags in them (can't do ^= because of fully qualified URL potential)
        $('a[class*="slow"]').each(function () {

            // Ensure it's a same-page link
            var thisPath = filterPath(this.pathname) || locationPath;
            if (locationPath == thisPath
                && (location.hostname == this.hostname || !this.hostname)
                && this.hash.replace(/#/, '')) {

                // Ensure target exists
                var $target = $(this.hash), target = this.hash;
                if (target) {

                    // Find location of target
                    var targetOffset = $target.offset().top;
                    $(this).click(function (event) {

                        // Prevent jump-down
                        event.preventDefault();

                        // Animate to target
                        $(scrollElem).animate({scrollTop: targetOffset}, 500, function () {

                            // Set hash in URL after animation successful
                            location.hash = target;

                        });
                    });
                }
            }

        });

        // Use the first element that is "scrollable"  (cross-browser fix?)
        function scrollableElement(els) {
            for (var i = 0, argLength = arguments.length; i < argLength; i++) {
                var el = arguments[i],
                    $scrollElement = $(el);
                if ($scrollElement.scrollTop() > 0) {
                    return el;
                } else {
                    $scrollElement.scrollTop(1);
                    var isScrollable = $scrollElement.scrollTop() > 0;
                    $scrollElement.scrollTop(0);
                    if (isScrollable) {
                        return el;
                    }
                }
            }
            return [];
        }

    });
});