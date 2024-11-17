
function handle_cart_view() {

    const data = {
        request_type: 'get_cart_snippet'
    };
    const url = '/server/catalogue_controller.php'

    post_data(url, data, ()=>{}, (responce)=> {
        delete responce.status;
        delete responce.message;

        if (responce.total_qty <= 0) {
           toggle_cart_invisible();
        }else {
            $('#cart_toggle_btn').prop('disabled', false);
            $('#cart_toggle_btn').text(`${responce.total_qty} 🛒`);
        }
    });
}

function toggle_cart_invisible() {
    // Update total cost
    $('#cart_total').text("0 ₽");
    // Update btn value
    $('#cart_toggle_btn').text("🛒");
    // Disable cart btn
    $('#cart_toggle_btn').prop('disabled', true);
    // Close modal window
    $('#cart_modal').modal('hide');
}


function clear_cart_view() {
    const cart_root = $('#cart_product_root');
    clear_cart();

    // Delete all cart product elements
    cart_root.empty();

    toggle_cart_invisible();
}

function delete_cart_element(id, cost) {
    total_cost = get_clear_number($(`#cart_total`).text()) - cost;
    $(`#cart_total`).text(`${total_cost} ₽`);
    add_to_cart(id, 0);
    console.log(`Delete cart element called on id = ${id}`);
    // Delete element
    $(`#cart_product_${id}`).remove();

    if ($('#cart_product_root').children().length <= 1)
        toggle_cart_invisible();
}

