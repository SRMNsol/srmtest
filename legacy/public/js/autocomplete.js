$(document).ready(function() {
    $('#nav-search-form').submit(function(event) {
        event.preventDefault();

        window.location = '/search?q=' + window.keyword;
    });

    $("#autocomplete").select2({
        placeholder: {name: "Enter keyword"},
        minimumInputLength: 2,
        allowClear: true,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "/product/autocomplete",
            data: function (term, page) {
                return {
                    q: term, // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {results: JSON.parse(data)};
            }
        },
        formatResult: function(object) {
            var markup = "<table class='movie-result'><tr>";
            markup += "<td>" +  object.name + "</td>";
            markup += "</tr></table>";
            return markup;

        },
        formatSelection: function(store) {
            window.keyword = store.name
            return store.name;
        }
    });
});