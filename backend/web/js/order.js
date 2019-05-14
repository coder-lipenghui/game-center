
function changeGame(sender) {
    // alert("submit");
    $("#myform").submit();
}
function onChange(sender) {
  selected=$("#longxiang").prop('checked');
  $(".md-checkbox").each(function () {
      if ($(this).next("label").text().indexOf("龙翔")>-1)
      {
          $(this).prop('checked',selected);
      }
  });
}