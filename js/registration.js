$('#regBtn').click(function(event) {
    event.preventDefault();
    var regularValidEmail = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
    var email = $('#eMailReg').val();
    var pass = $('#passwordReg').val();
    var name = $('#nameId').val();
    var confirmPass = $('#confirmPasswordReg').val();
    var data = {email: email, pass: pass, name: name};

    $('#invalidPass').text(' ');
    $('#invalidEmail').text(' ');

    if (regularValidEmail.test(email)){
        if (pass == confirmPass){
            $.ajax({
                type: 'POST',
                data: data,
                url: 'registration.php',
                success:
                    function(answer) {
                        reg(answer);
                    }
            }, 'json');

            function reg(n) {
                var answer = JSON.parse(n);

                if (answer.unicue == true){
                    $('#formReg').empty();
                    $('#formReg').text('Регистрация успешна!');
                }
                else{
                    $('#invalidEmail').text('Такой пользователь существует');
                }
            };
        }
        else {
            $('#invalidPass').text('Пароли не совпадают');
        }
    }
    else{
        $('#invalidEmail').text('Неверный Email');
    }
});