$(function(){
    $('#status-dat-hen').on('change', function(){
        var status = parseInt($(this).val()) || null;
        if(status_dat_hen_den.includes(status)){
            $('.status-dat-hen-den').slideDown();
        } else {
            $('.status-dat-hen-den').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        }
    });
    $('#status_dong_y').on('change', function(){
        var status = parseInt($(this).val()) || null;
        console.log(status, status_dong_y);
        if(status !== null && !status_dong_y.includes(status)){
            $('.status-dong-y-fail').slideDown();
        } else {
            $('.status-dong-y-fail').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        }
    });
});