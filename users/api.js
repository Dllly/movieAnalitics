$(function() {
  $('body').on('click', 'button[data-btn-type=ajax]', function(e) {
    console.log('click btn');
    var send_data;
    send_data = {
      user_type : $('input').val()
    };
    console.log(send_data);
    $.ajax({
      url: 'api/users.php',
      dataType: "json",
      data:send_data,
      success: function(response){
        if (response.result === "OK" ) {
          console.log(response);
          $('div[data-result=""]').html(JSON.stringify(response));
        } else {
          console.log(response);
          $('div[data-result=""]').html(JSON.stringify(response));
        }
        return false;
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest);
        console.log(textStatus);
        console.log(errorThrown);
        $('div[data-result=""]').html(JSON.stringify(" Error is Occured in getting data"));
        return false;
      }
  });

  $('input').focus();

  return false;
});
});
