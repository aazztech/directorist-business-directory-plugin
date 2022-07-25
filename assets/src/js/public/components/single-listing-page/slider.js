document.addEventListener('DOMContentLoaded', () => {
    let $ = jQuery;
    // Plasma Slider Initialization
    if($('.plasmaSlider').length !==0){
        var single_listing_slider = new PlasmaSlider({
            containerID: "directorist-single-listing-slider",
        });
        single_listing_slider.init();
    }

    /* Related listings slider */
    var rtl = Boolean(directorist.rtl);
    const relLis = document.querySelector('.directorist-related-carousel');
    if (relLis !== null) {
        const relLisCol = relLis.getAttribute('data-columns');
        $('.directorist-related-carousel').slick({
            dots: false,
            arrows: true,
            prevArrow: '<a class="directorist-slc__nav directorist-slc__nav--left"><span class="las la-angle-left"></span></a>',
            nextArrow: '<a class="directorist-slc__nav directorist-slc__nav--right"><span class="las la-angle-right"></span></a>',
            infinite: true,
            speed: 300,
            slidesToShow: relLisCol,
            slidesToScroll: 1,
            autoplay: false,
            rtl: rtl,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: relLisCol,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 575,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    }
})