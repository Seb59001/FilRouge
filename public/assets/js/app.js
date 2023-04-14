(function($){

    $('.btn-danger').on('click', function(e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');
        // $a.text('Chargement');
        $.ajax(url, {
            success: function() {
                var res = confirm("Êtes-vous sûr de vouloir supprimer?");
                if(res){
                    $a.parents('tr').fadeOut();
                }
            },
            error: function(jqxhr){
                $a.text('supprimer')
                alert(jqxhr.responseText);
            }
        });
    });

})(jQuery);