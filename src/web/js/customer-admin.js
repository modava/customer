$(function () {
    $('#status-call').on('change', function () {
        var status = parseInt($(this).val()) || null;
        if (status_call_accept.includes(status)) {
            $('.clinic-content').slideDown();
        } else {
            console.log('b');
            $('.clinic-content').hide();
        }
    });
    /*$('#select-type').on('change', function () {
        var type = parseInt($(this).val()) || null;
        if (type === type_online) {
            $('.is-online').slideDown();
        } else {
            $('.is-online').hide();
        }
    });*/
});