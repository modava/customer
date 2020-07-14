$(function(){
    $('#status_call').on('change', function(){
        var status = parseInt($(this).val()) || null;
        if(status_call_accept.includes(status)){
            $('.clinic-content').slideDown();
        } else {
            console.log('b');
            $('.clinic-content').hide();
        }
    });
});