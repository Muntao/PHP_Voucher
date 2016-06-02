$(function () {
    $("#send").click(function (event) {
        event.preventDefault();
        $(this).attr('disabled', true);
        var checkedName = checkName();
        var checkedEmail = checkEmail();
        var checkedRecipient = checkRecipient();
        var checkedRecipientEmail = checkRecipientEmail();
        var checkedMessage = checkMessage();

        if (checkedName && checkedEmail && checkedRecipient && checkedRecipientEmail && checkedMessage) {
            $("form:first").submit();

        } else {
            $(this).attr('disabled', false);
        }
    });
});

function checkName() {
    var val = $('#from').val();
    var length = val.length;
    if ((length < 5) || (length > 50)) {
        $('#fromError').html('Name is too short or too long!').show();
        return false;
    }
    if (!(/^[a-zA-Z]+$/.test(val))) {
        $('#fromError').html('Name can contain only letters!').show();
        return false;
    }
    $('#fromError').html('').hide();
    return true;
}

function checkEmail() {
    var val = $('#email').val();
    if (!(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(val))) {
        $('#emailError').html('This is not an email!').show();
        return false;
    }
    var length = val.length;
    if ((length < 5) || (length > 100)) {
        $('#emailError').html('Email is too short or too long!').show();
        return false;
    }
    $('#emailError').html('').hide();
    return true;
}

function checkRecipient() {
    var val = $('#to').val();
    var length = val.length;
    if ((length < 5) || (length > 100)) {
        $('#toError').html('Name is too short or too long!').show();
        return false;
    }
    if (!(/^[a-zA-Z]+$/.test(val))) {
        $('#toError').html('Name can contain only letters!').show();
        return false;
    }
    $('#toError').html('').hide();
    return true;
}

function checkRecipientEmail() {
    var val = $('#recipient_email').val();
    if (!(/^[0-9]+$/.test(val))) {
        $('#remailError').html('This field can contain only numbers!').show();
        return false;
    }
    $('#remailError').html('').hide();
    return true;
}

function checkMessage() {
    var val = $('#message').val();
    var length = val.length;
    if (length > 255) {
        $('#messageError').html('Message is too long!').show();
        return false;
    }
    $('#messageError').html('').hide();
    return true;
}