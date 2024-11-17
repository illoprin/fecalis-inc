
const get_total_cost = (delta) => {
    return parseInt(get_clear_number($('#cart_total').text())) + delta;
}

function update_cart(id, delta, price) {
    const data = {
        request_type: 'get_cart_snippet'
    }
    post_data('/server/catalogue_controller.php', data,
    () => {},
    (responce) => {
        if (responce.status == 0) {
            console.log(responce);
            delete responce.message;
            delete responce.status;
            let current_qty = parseInt(responce[id]);
    
            const qty_text = $('#cart_product_qty_'+id);
            const cost_text = $('#cart_product_cost_'+id);
            
            if (!(responce[id] + delta <= 0)) {
                current_qty += delta;
    
                qty_text.text(current_qty);
                cost_text.text(price_format(current_qty * parseInt(price)));
                $('#cart_total').text(get_total_cost(delta*price) + ' ₽');
                add_to_cart(parseInt(id), current_qty);
                console.log(`Product with id = ${id} cart quantity was updated.\nCurrent quantity is qty = ${current_qty}`);
            }
        }
        
    });
}

function delete_cart_product (id) {    
    const cost = get_clear_number($('#cart_product_cost_'+id).text());
    $('#cart_total').text(get_total_cost(-cost) + ' ₽');
    
    $('#cart_product_' + id).remove();

    add_to_cart(id, 0);

    if ($('#product_root').children().length <= 0)
        redirect('/app/catalogue');
}

function purchase_action() {
    $('#purchase').on('click', (e) => {
        prevent_default_action(e);
        const values = get_data($('#purchase_form')[0]);

        if (!values) { 
            show_error('Некоторые поля не заполнены');
        }else {
            post_data('/server/action/add_purchase.php', values,
            () => {
                $(this).prop('disabled', true);
            },
            (responce) => {
                if (responce.status != 0) {
                    show_error(`Ошибка на стороне сервера. Ответ сервера: ${responce.message}`);
                }else {
                    console.log(responce);
                    redirect('/app/account?mode=order');
                }
            },
            (status, exception) => {
                show_error(get_error_message(status, exception));
                $(this).prop('disabled', false);
            })
        }

        console.log(values)
    });
}