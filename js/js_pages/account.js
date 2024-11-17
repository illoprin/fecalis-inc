

// Set active tab based on url mode value
document.getElementById(mode).classList.remove('d-none');
document.getElementById(`radio_${mode}`).setAttribute('checked', true);

// Add cookie data on USER DATA page
Object.keys(cookie_data).map((key) => {
    $(`#user_${key}`).text(cookie_data[key] == '' ? 'Неизвестен' : cookie_data[key]);
});


function cancel_order(id) {
    console.log (`Order with id = ${id} marked for cancel`);
    alert('Заказ помечен на отмену. Подтвердите...');
    const data = {
        id: id,
        status: 2
    }
    post_data('/server/action/change_purchase_status.php', data, () => {}, () => {
        console.log(`Status id = ${id} changed succesfully!`);
        // Cancel order - successs
        redirect('/app/account?mode=order');
    });
}

