function handle_cart() {
    const data = {
        request_type: 'get_cart_snippet'
    };
    const url = '/server/action/catalogue_controller.php';

    post_data(url, data, () => {}, (responce) => {
        if (responce.status == 0) {
            delete responce.message;
            delete responce.status;
            
            const cart = responce;
            const incart = Array.from(Object.keys(cart).map((elem) => parseInt(elem))).includes(dynamic_data.id);
            if (incart && cart[dynamic_data.id] > 0) {
                enable_cart();
                $('#quantity')[0].value = cart[dynamic_data.id];
                dynamic_data.amount = cart[dynamic_data.id];
                dynamic_data.total = dynamic_data.amount * dynamic_data.price;
                $('#product_total').text(`Общая стоимость: ${price_format(dynamic_data.total)}`);
            }
        }
    });


    $('#decrease_qty').on('click', () => {
        update_amount(-1);
    });

    $('#increase_qty').on('click', () => {
        update_amount(1);
    });

    $('#add_to_cart_btn').on('click', () => {
        enable_cart();
        update_amount(1);
        $('#quantity')[0].value = dynamic_data.amount;
        add_to_cart(dynamic_data.id, dynamic_data.amount);
    });
}

function enable_cart() {
    $('#price_block').addClass('d-none');
    $('#cart_controls').removeClass('d-none');
}

function close_cart() {
    $('#price_block').removeClass('d-none');
    $('#cart_controls').addClass('d-none');
    $('#quantity')[0].value = 0;
    add_to_cart(dynamic_data.id, 0);
}

function update_amount(delta) {
    if ((dynamic_data.amount + delta) <= 0) {
        close_cart();
    }else {
        dynamic_data.amount += delta;
        $('#quantity')[0].value = dynamic_data.amount;
        $('#product_total').text(`Общая стоимость: ${price_format(dynamic_data.amount * dynamic_data.price)}`);
        add_to_cart(dynamic_data.id, dynamic_data.amount);
    }
}
