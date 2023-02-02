$(document).ready(function(){
    $('.chat_list').hide();
    $('#msg_pane').hide();
});

$(document).on('click',('.ch_openX'),function(e) {
    $('.chat_list').removeAttr('hidden');
    $('.chat_list').show();
    $('.chat_list').animate({
        right: '5px',
        opacity: '1.0',
      });
});

$(document).on('click',('.ch_closeX'),function(e) {
    $('.chat_list').animate({
        right: '-5px',
        opacity: '.5',
      });
    $('.chat_list').hide();
});

$(document).on('click',('.chat_person'),function(e) {
    var chat_thisX = $(this).children(":first").val();
    
    $('#chat_this').val(chat_thisX);

    $('#chat_this_form').submit();

    var pane=parent.document.getElementById("msg_pane");
    var pane_inside=parent.document.getElementById("the_pane");
    $(pane).removeAttr('hidden');
    $(pane).show();
    var base_url = window.location.origin;

    $(pane_inside).attr("src", base_url+'/msg_pane');
});

$(document).on('click',('.close_pane'),function(e) {
    var pane=parent.document.getElementById("msg_pane");
    $(pane).hide();

    var pane_inside=parent.document.getElementById("the_pane");
    var base_url = window.location.origin;
    $(pane_inside).attr("src",'');
    
});

$(document).on('click',('.ref_pane'),function(e) {
    location.reload();
});