(function () {
   $("#msbo").on("click", function () {
      $("body").toggleClass("msb-x");
    });
  })();


  $('#select-all').on('change', function()
  {
      if ($(this).is(':checked')) {
          $('.class-checkboxes').attr('checked', 'checked')
      }
  });

  $(document).ready(function () {
    $("#select-all").click(function () {
        $(".class-checkboxes").prop('checked', $(this).prop('checked'));
    });
});

  