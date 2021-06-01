console.log('apparence');

(function ($) {

    wp.customize('header_background', function (value) {
        value.bind(function (newVal){
            $('.navbar').attr('style', 'background', newVal + '!important')
            console.log('En tête change', newVal);
        })
    })

})(jQuery)