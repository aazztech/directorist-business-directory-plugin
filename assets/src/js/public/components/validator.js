jQuery(document).ready(function ($) {
    function to_top(top) {
        $([document.documentElement, document.body]).animate({
            scrollTop: $(top).offset().top
        }, 1000);
    }

    /* need_post = false;
    if ($("input[name='need_post']").length > 0) {
        $("input[name='need_post']").on('change', function () {
            if ('yes' === this.value) {
                need_post = true;
            }
        });
    } */

    /* ================================
        * Add listing form validation
    =================================== */
    const addListingForm = document.getElementById('directorist-add-listing-form');
    const addListingBtn = document.querySelector('.directorist-form-submit__btn');
    var addListingInputs = addListingForm.querySelectorAll('.directorist-form-element:not(select.directorist-form-element):not(.directorist-color-field-js)');
    let addListingInputColor = addListingForm.querySelectorAll('.directorist-color-field-js');
    let addListingSelect2 = addListingForm.querySelectorAll('.directorist-form-element--select2');
    let addListingInputDateTime = addListingForm.querySelectorAll('.directorist-form-element[type="date"], .directorist-form-element[type="time"]')

    if(typeof(addListingForm) != 'undefined' && addListingForm != 'null'){
        document.querySelector('html').style.scrollBehavior = "smooth";
    }
    /* Insert alert after select2 element */
    function insertAfterSelect2(elm) {
        $('<span class="directorist-alert-required">This Field is Required</span>').insertAfter($(elm).siblings('.select2-container'));
    }


    function formValidate() {
        var addListingInputs = addListingForm.querySelectorAll('.directorist-form-element:not(select.directorist-form-element):not(.directorist-color-field-js)');
        //Validate input fields
        addListingInputs.forEach((elm, ind) =>{
            console.log(elm);
            if(elm.hasAttribute('required') && elm.value === ''){
                if($(elm).siblings('.directorist-alert-required').length === 0){
                    $('<span class="directorist-alert-required">This Field is Required</span>').insertAfter(elm);
                }
            }
        })

        //validate color fields
        addListingInputColor.forEach((elm, ind)=>{
            if(elm.hasAttribute('required') && elm.value === ''){
                if($(elm).closest('.wp-picker-input-wrap').siblings('.directorist-alert-required').length === 0){
                    $('<span class="directorist-alert-required">This Field is Required</span>').insertAfter($(elm).closest('.wp-picker-input-wrap').siblings('.wp-picker-holder'));
                }
            }
        })

        //validate select2 fields
        addListingSelect2.forEach((elm, ind) =>{
            if(elm.hasAttribute('required') && elm.value === ''){
                if($(elm).siblings('.directorist-alert-required').length === 0){
                    insertAfterSelect2(elm);
                }
            }
        })
    }

    /* Toggle required notification in Input fields */
    addListingInputs.forEach((elm, ind) =>{
        elm.addEventListener('keydown', ()=>{
            if(elm.hasAttribute('required')){
                $(elm).siblings('.directorist-alert-required').remove();
            }
        })
        elm.addEventListener('keyup', ()=>{
            if(elm.hasAttribute('required') && elm.value === ""){
                if($(elm).siblings('.directorist-alert-required').length === 0){
                    $('<span class="directorist-alert-required">This Field is Required</span>').insertAfter(elm);
                }
            }
        })
    })

    /* Toggle required notification in Color fields */
    addListingInputColor.forEach((elm, ind) =>{
        elm.addEventListener('keydown', ()=>{
            if(elm.hasAttribute('required')){
                $(elm).closest('.wp-picker-input-wrap').siblings('.directorist-alert-required').remove();
            }
        })
        $(elm).closest('.wp-picker-input-wrap').siblings('.wp-picker-holder').find('.iris-square, .ui-slider, .iris-palette-container a').on('click', function(){
            $(elm).closest('.wp-picker-input-wrap').siblings('.directorist-alert-required').remove();
        })

        elm.addEventListener('keyup', ()=>{
            if(elm.hasAttribute('required') && elm.value === ""){
                $('<span class="directorist-alert-required">This Field is Required</span>').insertAfter($(elm).closest('.wp-picker-input-wrap').siblings('.wp-picker-holder'));
            }
        })
        $(elm).closest('.wp-picker-input-wrap').find('.wp-picker-clear').on('click', function(){
            if($(elm).closest('.wp-picker-input-wrap').siblings('.directorist-alert-required').length === 0){
                $('<span class="directorist-alert-required">This Field is Required</span>').insertAfter($(elm).closest('.wp-picker-input-wrap').siblings('.wp-picker-holder'));
            }
        })
    })

    /* Toggle required notification in Input=date/time Fields */
    addListingInputDateTime.forEach((elm, id) =>{
        elm.addEventListener('change', ()=>{
            $(elm).siblings('.directorist-alert-required').remove();
        })
    })

    /* Toggle required notification in Select2 fields */
    $(".directorist-form-element--select2").each(function(id, elm){
        $(elm).on('select2:select', function(){
            $(elm).siblings('.directorist-alert-required').remove();
        })
        $(elm).on('select2:unselect', function(){
            if($(this).select2('data').length === 0){
                insertAfterSelect2(elm);
            }
        })
    })

    addListingBtn.addEventListener('click', formValidate);

});