const form_login = $('#form_login')[0];
form_login.addEventListener('submit', (e) => {
    prevent_default_action(e);
    const data = get_data(form_login);
    console.log(data);
    if (data) {
        post_data('/server/action/login.php', data, 
        () => {
            $('#login_submit').prop('disabled', true);
        },
        (responce) => {
            responce.status != 0 ? show_error(`Ответ сервера: ${responce.message}`) : redirect('/app/account?mode=user_data');
        }, 
        (status, exception) => {
            show_error(get_error_message(status, exception));
        });
        $('#login_submit').prop('disabled', false);
    } else {
        show_error('Данные введены не верно, либо присутствуют пустые поля');
    }
});