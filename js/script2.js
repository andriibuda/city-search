(function ($, Drupal) {


    var test = document.getElementById("edit-hotel-location");
    var options = {
        language: 'en-GB',
        types: ['(cities)']
    };
    var autocomplete = new google.maps.places.Autocomplete(test, options);


    Drupal.behaviors.citySearchBehavior = {
        attach: function (context, settings) {
            // $(context).find('#'+mapElement).once('ajaseBehavior').each(function () {
            //     //init();
            //     init();
            // });
        }
    }

})(jQuery, Drupal);

