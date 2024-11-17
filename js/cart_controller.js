
function add_to_cart(id, qty) {
    const data = {
        request_type: 'add_to_cart',
        id: id,
        qty: qty
    };
    // POST request
    post_data('/server/catalogue_controller.php', data);
}


// DEBUG
const get_cart_snippet = () => {
    const data = {
        request_type: 'get_cart_snippet'
    };
    // POST request
    post_data('/server/catalogue_controller.php', data);
}
// END DEBUG


const clear_cart = () => {
    const data = {
        request_type: 'clear_cart',
    }
    // POST request
    post_data('/server/catalogue_controller.php', data);
}