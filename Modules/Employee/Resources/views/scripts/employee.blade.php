{{--<script src="{{asset('assets/vendors/select2/select2.min.js')}}"></script>--}}
<script type="text/javascript">
    ;(function ($, window, document) {
        /**Auto Execute Part*/
        $(document).ready(function () {
            //Ajax get dependent dropdown
            /*$("#parent_id").on('change', function () {

                let childId = $('#parent_id').data('child-id');
                let link = $('#parent_id').data('link');
                $('#' + childId).empty();

                $.ajax({
                    url: link + '?id=' + $(this).val(),
                    contentType: 'application/json',
                    method: 'get',
                    success: function (data) {
                        if (Array.isArray(data)) {
                            for (i = 0; i < data.length; i++) {
                                $('#' + childId).append('<option value="' + data[i].id + '">' + data[i].text + '</option>');
                            }
                        } else {
                            $('#' + childId).append('<option value="' + data.id + '">' + data.text + '</option>');
                        }
                    },
                });
            });*/


            //Check if employee crerate User
            $('#createUser').on('click', function () {

                if ($('#createUser').is(':checked')) {

                    $('#createUserInfo').removeClass('hide');
                    $('#createUserInfo').addClass('show');
                } else {
                    $('#createUserInfo').addClass('hide');
                }

            });


            $('#password_confirmation').keyup(function () {

                let password = $('#password').val();

                if (this.value !== password) {
                    $('#alert_confirm').text('Password does not match');
                    $('#submitButton').attr('disabled', true)
                } else {
                    $('#alert_confirm').text('');
                    $('#submitButton').removeAttr('disabled')
                }

            });

        });

    }(window.jQuery, window, document));

    function hideshow() {
        var password = document.getElementById("password");
        var slash = document.getElementById("slash");
        var eye = document.getElementById("eye");

        if (password.type === 'password') {
            password.type = "text";
            slash.style.display = "block";
            eye.style.display = "none";
        } else {
            password.type = "password";
            slash.style.display = "none";
            eye.style.display = "block";

        }
    }
</script>
