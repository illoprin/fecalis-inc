const form_stage_01 = $('#reg_stage_01')[0];

check_password_repeat();
check_email();
check_phone();

let user_id = null;

form_01_submit_event();

const form_stage_02 = $('#reg_stage_02')[0];

check_card_number();
check_card_date();

form_02_submit_event();


function form_01_submit_event() {
    form_stage_01.addEventListener('submit', (e) => {
        prevent_default_action(e);
        const data = get_data(form_stage_01, true);
        data.request_type = 'add_user'; 
        console.log(data);
        if (data) {
            post_data('/server/action/user_entry_control.php', data,
            () => {
                // Before send
                $('#reg_stage_01_submit').prop('disabled', true);
            },
            (responce) => {
                // After send
                if ((responce.status != 0) || !responce.user_id)
                    show_error(`Ошибка на стороне сервера. ${responce.message}`);
                else {
                    user_id = responce.user_id;
                    switch_forms();
                }
            }, (jqXHR, exception) => {
                // Error
                show_error(get_error_message(jqXHR, exception));
            });
            $('#reg_stage_01_submit').prop('disabled', false);
        }
        else {
            show_error('Некоторые поля не заполнены');
        }
    });
}

function form_02_submit_event() {
    form_stage_02.addEventListener('submit', (e) => {
        prevent_default_action(e);
        let data = get_data(form_stage_02, true);
        data['user_id'] = user_id;
        console.log(data);
        if (data) {
            post_data('/server/action/add_payment.php', data,
            () => {
                $('#reg_stage_02_submit').prop('disabled', true);
            },
            (responce) => {
                // After send
                responce.status != 0 ? show_error(`Ошибка на стороне сервера. ${responce.message}`) : window.location.href = '/static/?view=landing';
            },
            (jqXHR, exception) => {
                // Error
                show_error(get_error_message(jqXHR, exception));
                $('#reg_stage_02_submit').prop('disabled', false);
            });
            $('#reg_stage_02_submit').prop('disabled', false);
        } else {
            show_error('Некорректный ввод или присутствуют пустые поля');
        }
    });
}

function check_password_repeat() {
    const password_input = form_stage_01.elements.password;
    const password_repeat_input = form_stage_01.elements.password_repeat;
    password_repeat_input.addEventListener('input', (e) => {
        console.log('password repeat input')
        if (password_input.value != password_repeat_input.value) {
            $('#password_invalid_message').show();
            $('#reg_stage_01_submit').prop('disabled', true);
        } else {
            $('#password_invalid_message').hide();
            $('#reg_stage_01_submit').prop('disabled', false);
        }
    });
}

function check_phone() {
    const phone_input = form_stage_01.elements.phone;
    phone_input.addEventListener('input', () => {
        phone_input.value = $.trim(phone_input.value.replace(/[^0-9]/g, ""));
        phone_input.value = format(phone_input.value, '(xxx) xxx xx-xx');
    });
}

function check_email() {
    const email_input = form_stage_01.elements.email;
    email_input.addEventListener('input', (e) => {
        const invalid = !email_input.value.includes('@');
        if (invalid) {
            $('#email_invalid_message').show();
            $('#reg_stage_01_submit').prop('disabled', true);
        } else {
            $('#email_invalid_message').hide();
        }
    });
}

function check_card_number () {
    const card_number_input = form_stage_02.elements.card_number;
    card_number_input.addEventListener('input', (e) => {
        card_number_input.value = $.trim(card_number_input.value.replace(/[^0-9]/g, ""));
        card_number_input.value = format(card_number_input.value, 'xxxx xxxx xxxx xxxx');
    });
}

function check_card_date () {
    const card_date_input = form_stage_02.elements.card_date;
    card_date_input.addEventListener('input', (e) => {
        card_date_input.value = $.trim(card_date_input.value.replace(/[^0-9]/g, ""));
        card_date_input.value = format(card_date_input.value, 'xx/xx');
    });
}



function switch_forms() {
    form_stage_01.classList.add('d-none');
    form_stage_02.classList.remove('d-none');
}