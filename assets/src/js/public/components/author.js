// author sorting
(function ($) {
    /* Masonry layout */
    function authorsMasonry() {
        let authorsCard = document.querySelectorAll('.directorist-authors__cards');
        authorsCard.forEach(elm=>{
            let authorsCardRow = elm.querySelector('.directorist-row');
            let msnry = new Masonry(authorsCardRow, {
                percentPosition: true
            })
        })
    }
    authorsMasonry();

    $('body').on( 'click', '.directorist-alphabet', function(e) {
        e.preventDefault();
        var alphabet   = $(this).attr("data-alphabet");
        $('body').addClass('atbdp-form-fade');
        $.ajax({
            method: 'POST',
            url: atbdp_public_data.ajaxurl,
            data: {
                action   : 'directorist_author_alpha_sorting',
                _nonce   : $(this).attr("data-nonce"),
                alphabet : $(this).attr("data-alphabet")
            },
            success( response ) {
               $('#directorist-all-authors').empty().append( response );
               $('body').removeClass('atbdp-form-fade');
               $( '.' + alphabet ).parent().addClass('active');
               authorsMasonry();
            },
            error(error) {
                console.log(error);
            },
        });
    });

    $('body').on( 'click', '.directorist-authors-pagination a', function(e) {
        e.preventDefault();
        var paged = $(this).attr('href');
        paged = paged.split('/page/')[1];
        paged = parseInt(paged);
        console.log(paged)
        paged = paged !== undefined ? paged : 1;
        $('body').addClass('atbdp-form-fade');
        var alphabetValue = $('.directorist-authors__nav li.active').attr('data-alphabet');
        console.log(alphabetValue);
        $.ajax({
            method: 'POST',
            url: atbdp_public_data.ajaxurl,
            data: {
                action   : 'directorist_author_pagination',
                paged    : paged
            },
            success( response ) {
                $('body').removeClass('atbdp-form-fade');
                $('#directorist-all-authors').empty().append( response );
                authorsMasonry();
            },
            error(error) {
                console.log(error);
            },
        });
    });
})(jQuery)