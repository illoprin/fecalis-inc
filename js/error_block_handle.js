
// block - error
// message - error_message
// toggler - hide_error

// Error block handle
const error_block = $('#error')[0];
const error_message = error_block.querySelector('#error_message');
$('#hide_error').on('click', () => error_block.classList.toggle('d-none'));

function show_error(message) {
    error_message.textContent = message;
    error_block.classList.toggle('d-none');
}