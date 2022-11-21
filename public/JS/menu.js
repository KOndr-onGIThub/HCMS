$(function(){

    $('#menu').menu();
    $('#menu').css('display', 'none'); // mam to take v css, aby menu neblikalo, pri refresh

    $('#menu-button').click(function(e) {
        $('#menu').css('display', 'block').offset({ left: e.pageX, top: e.pageY }); // DLE POZICE MYSI
            $('html, body').click(function() {
                $('#menu').css('display', 'none');
                $('html, body').off('click');
            });
            return false;
    });



});