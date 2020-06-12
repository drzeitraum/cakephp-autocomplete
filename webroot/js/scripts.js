ac();
function ac() {
    $('form').unbind("keyup").on('keyup', '.ac-input', function () {
        var id_up = $(this).attr('id'); // this id
        var id_next = $(this).next().attr('id'); // next id
        var search = $(this).val(); // search word
        var where = $(this).attr('name'); // where search
        $.ajax({
            url: '/cakephp-autocomplete/autocomplete/', //change this path to the name of your Autocomplete controller
            data: ({
                search: search,
                where: where
            }),
            success: function (result) {
                $("#" + where + "_result").html(result); // print
                $('.ac-list li').click(function () {
                    $('.ac-list').addClass('ac-none'); // hide ul ac-list
                    $('#' + id_up).val($(this).text());  // insert name
                    $("#" + id_next).val($(this).attr('id')); // insert id
                });
            }
        });
    });
    // hide ul ac-list whatever
    $('body').click(function () {
        $('.ac-list').addClass('ac-none');
    });
}
