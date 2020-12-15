$('.office').on('click', function(){
  $('.office').addClass('location_clicked');
  $('.home').removeClass('location_clicked');
  $('#location').val('office');
});
$('.home').on('click', function(){
  $('.home').addClass('location_clicked');
  $('.office').removeClass('location_clicked');
  $('#location').val('home');
});