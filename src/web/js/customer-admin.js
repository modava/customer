$(function(){
    $('#status_call').on('change', function(){
        var status = parseInt($(this).val()) || null;
        if(status_call_accept.includes(status)){
            console.log('a');
            $('.clinic-content').slideDown();
        } else {
            console.log('b');
            $('.clinic-content').hide();
        }
    });
});