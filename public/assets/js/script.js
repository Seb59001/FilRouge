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
