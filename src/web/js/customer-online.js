$(function(){
    $('#status-call').on('change', function(){
        var status = parseInt($(this).val()) || null;
        if(status == null){
            $('.customer-status-call-success, .customer-status-call-fail').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        } else if(status_call_accept.includes(status)){
            $('.customer-status-call-success').slideDown();
            $('.customer-status-call-fail').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        } else {
            $('.customer-status-call-fail').slideDown();
            $('.customer-status-call-success').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        }
    });
    $('#remind-call').on('change', function(){
        if($(this).is(':checked')){
            $('.remind-call-time').slideDown();
        } else {
            $('.remind-call-time').hide();
        }
    });
});