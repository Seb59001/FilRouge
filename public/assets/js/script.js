
// TABLEAU DES COURS 
(function () {
   $("#msbo").on("click", function () {
      $("body").toggleClass("msb-x");
    });
  })();


  $('#select-all').on('change', function()
  {
      if ($(this).is(':checked')) {
          $('.class-checkboxes').attr('checked', 'checked');

      }

  });

  $(document).ready(function () {
    $("#select-all").click(function () {
        $(".class-checkboxes").prop('checked', $(this).prop('checked'));
    });
});

$('#check-button').on('change', function() {
    // var ids = [];
    var id;
    $('input[name="id"]:checked').each(function() {
        // ids.push($(this).val());
        id=$(this).val();

    });

    console.log(id);

    $.ajax({
        type: 'POST',
        url: '/cour/edit/{id}',
        data: {id: id}
    });
});

$(document).ready(function() {
    // activer la fonctionnalité d'affichage du mot de passe en clair
    $('[data-toggle="password"]').each(function() {
        var input = $(this);
        var eye = $('<i class="fa fa-eye toggle-password"></i>');
        eye.insertBefore(input);
        eye.on('click', function() {
            var type = input.attr('type');
            if (type === 'password') {  
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
});


