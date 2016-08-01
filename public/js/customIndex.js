/**
 * Created by dmunioz on 03/02/2016.
 */

/* ----------------------------------------------------------- */
/*  1. Superslides Slider
 /* -----------------------------------------------------------
jQuery('#slides').superslides({
    animation: 'slide',
    play: '5000'
});*/
/* ----------------------------------------------------------- */
/*  11. Google Map
 /* ----------------------------------------------------------- */

var zoom = $('#map_canvas').gmap('option', 'zoom');

$('#map_canvas').gmap().bind('init', function (ev, map) {
    $('#map_canvas').gmap('addMarker', {'position': '-38.951900, -68.068931', 'bounds': true});
    $('#map_canvas').gmap('option', 'zoom', 16);
});




/* ----------------------------------------------------------- */
/*  3. Featured Slider Promociones
 /* ----------------------------------------------------------- */


$('.featured_slider').slick({
    dots: true,
    infinite: true,
    speed: 800,
    arrows: false,
    slidesToShow: 1,
    slide: 'div',
    autoplay: true,
    fade: true,
    autoplaySpeed: 10000,
    cssEase: 'linear'
});
/* ----------------------------------------------------------- */
/*  7. TEAM SLIDER Prestaciones
 /* ----------------------------------------------------------- */

$('.team_slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

/* ----------------------------------------------------------- */
/*  8. BLOG SLIDER
 /* ----------------------------------------------------------- */


$('.blog_slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 3,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});


/* ----------------------------------------------------------- */
/*  9. TESTIMONIAL SLIDER SIN USAR
 /* -----------------------------------------------------------

$('.testimonial_slider').slick({
    dots: true,
    infinite: true,
    speed: 800,
    arrows: false,
    slidesToShow: 1,
    slide: 'li',
    autoplay: true,
    fade: true,
    autoplaySpeed: 3000,
    cssEase: 'linear'
});*/


/* ----------------------------------------------------------- */
/*  10. CLIENTS SLIDER Información de Contacto
 /* ----------------------------------------------------------- */

$('.clients_slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    responsive: [
        {
            breakpoint: 1199,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

/*Novedades*/

$('.responsive').slick({
    dots: false,
    infinite: true,
    speed: 9000,
    slidesToShow: 3,
    autoplay: true,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1199,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});