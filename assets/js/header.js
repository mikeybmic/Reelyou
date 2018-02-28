$(document).ready(function () {



//EDIT BIO DESC
    $('#edit-desc-btn').on('click', function (e) {
        e.preventDefault();
        $('#edit-desc-btn').css('visibility','hidden');
        var bioDesc = $('#bio-desc').text();
        var textArea = '<textarea class="form-control" maxlength="140" rows="3" id="updated-bio-desc" required>' + bioDesc + '</textarea>';
        $('#bio-desc').html(textArea);
        $('#confirm-bio-edit').removeClass('hide');
    })

    $('#confirm-bio-edit').on('click', function (e) {
        var bioDesc = $('#updated-bio-desc').val();
    
        if(bioDesc.length == 0){
            $('#updated-bio-desc').attr('placeholder','Must write some description.')
            return false;
        }
        $.ajax({
            type: 'POST',
            url: window.base_url + 'Profile/update_profile_desc',
            data: 'desc=' + bioDesc,
            success: function (callBack) {
                $('#edit-desc-btn').css('visibility','visible');
//            console.log(data);
                $('#confirm-bio-edit').addClass('hide');
                if (callBack.msg == 'success') {
                    $('#bio-desc').html(bioDesc);
                }else{
                   $('#updated-bio-desc').attr('placeholder','Must write some description.') 
                } 
            }
        });

    })

    jQuery.validator.addMethod("passwordCheck",
            function (value, element, param) {
                if (this.optional(element)) {
                    return true;
                } else if (!/[A-Z]/.test(value)) {
                    return false;
                } else if (!/[a-z]/.test(value)) {
                    return false;
                } else if (!/[0-9]/.test(value)) {
                    return false;
                }

                return true;
            },
            "Must contain one Uppercase and one number");

    $.validator.addMethod("noSpace", function (value, element) {
        return value.indexOf(" ") < 0;
    }, "No space allowed.");

    $('.registration-form').validate({
        igonore: [],
        rules: {
            first_name: 'required',
            last_name: 'required',
            user_email: {
                required: true,
                email: true
            },
            password: {
                noSpace: true,
                passwordCheck: true,
                required: true,
                minlength: 8

            },
            passconf: {
                required: true,
                equalTo: '#password1'
            }

        },
        messages: {
            first_name: 'First name is required',
            last_name: 'Last name is required',
            user_email: {
                required: 'Email is required'
            },
            password: {
                required: 'Password is requird'

            },
            passconf: {
                required: 'Enter the same password agian'
            }
        },
        errorPlacement: function (error, element) {
//console.log(element.attr('id'));
            error.appendTo(element.parents('.field'));

        }


    });
//    });

//email checking
    $('#user_email').on('change blur', function () {
        var cur = $(this);
        var value = $(this).val();
        if (value.length)
            check_email(cur);
        else
            return false;
    });
});

function check_email(cur) {
    var cur = cur;
    var email = $(cur).val();
    $.ajax({
        type: 'POST',
        url: window.base_url + 'Users/check_email',
        data: 'email=' + email,
        success: function (callBack) {
//            console.log(data);
            $('label[for="user_email"]').remove();
            if (callBack.msg == 'exist') {
                var msg = '<label for="user_email" class="error"> Email already taken.</label>';
                $(msg).insertAfter(cur);
                $('#registration-submit').attr('disabled', 'disabled').css('cursor', 'not-allowed');
            } else {
                $('#registration-submit').removeAttr('disabled style');

            }
        }
    });
}
