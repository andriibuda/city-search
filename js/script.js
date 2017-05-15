(function ($, Drupal) {

    function ajax() {
        console.log('Stp!');
    }

    function init() {
        console.log('Op!');
    }

    var searchInput = document.getElementsByName("search_country");
    console.log(searchInput);
    searchInput.onclick = function () {
        //console.log('Yoi');
        alert('kldsjf');
    };

    var test = document.getElementById("edit-search-country");
    var options = {
        language: 'en-GB',
        types: ['(cities)']
    };
    var autocomplete = new google.maps.places.Autocomplete(test, options);


    // test.onkeyup = function () {
    //     var text = test.value;
    //     $.ajax({
    //         type: "POST",
    //         url: '/city-search/ajax',
    //         data: { 'message': text }
    //         //timeout: 10000
    //     })
    //         .done(function( data ) {
    //             // var mes = JSON.stringify(data);
    //             var result = document.getElementById("result-list");
    //             var str = test.value;
    //             if (str.length == 0) {
    //                 result.innerHTML = "";
    //             } else {
    //                 // var resultArea = document.getElementsByClassName("form-item-search-country");
    //                 // var resultList = document.createElement('div');
    //                 // resultList.appendChild(document.createTextNode('Jojo'));
    //                 // resultArea.appendChild(resultList);
    //
    //                 //result.innerHTML = '<pre>'+data+'</pre>';
    //                 result.innerHTML = data.list;
    //             }
    //
    //             console.log( "Data Loaded: " + data.list);
    //         });
    //
    //
    // };

    Drupal.behaviors.citySearchBehavior = {
        attach: function (context, settings) {
            // $(context).find('#'+mapElement).once('ajaseBehavior').each(function () {
            //     //init();
            //     init();
            // });
            init();
        }
    }

})(jQuery, Drupal);
