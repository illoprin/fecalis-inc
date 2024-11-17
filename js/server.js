function post_data(url, data, before_send_func = () => {}, success_func = (responce) => {}, error_func = (status, exception) => {}) {
    $.ajax({
        url: url,
        async: false,
        cache: true,
        type: 'post',
        dataType: 'json',
        data: {data: data},
        beforeSend: () => {
            console.log(`Data sent to server by url = ${url}\nData composition is:`);
            console.log(data);
            console.log(`Waiting for responce...`);
            before_send_func();
        },
        success: (responce) => {
            console.log(`A response was received from url = ${url}`);
            if (responce.status != 0)
                console.log(`Something went wrong. Server responce: ${responce.message}`);
            else {
                console.log(responce);
            }
            success_func(responce);
        },
        error: (status, exception) => {
            console.log(`Error was received from url = ${url}`);
            console.error(get_error_message(status, exception));
            error_func(status, exception);
        }
    })
}

const get_error_message = (jqXHR, exception) => {
    console.log('Request error...');
    if (jqXHR.status == 0) {
        return 'Нет соединения с сервером!';
    }else {
        return `Ошибка на стороне сервера. Код ${jqXHR.status}`;
    }
};



// Handle file upload
function handle_data_transfer (event, on_success = (responce) => {}, url) {
    const dt = event.dataTransfer;
    const files = dt.files;

    if (files.length > 0) {
        upload_file(files[0], on_success, url);
    }
}

function upload_file(file, on_success = (responce) => {}, url) {
    const formData = new FormData();
    formData.append('upload', file);
    fetch(url, {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        on_success(data)
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
