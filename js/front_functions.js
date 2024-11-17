
// Handle Events
function prevent_default_action (e) {
    e.preventDefault();
    e.stopPropagation();
}

const get_clear_number = (str) => {
    return parseInt(str.replace(/[^0-9]/g, ""));
}

const get_data = (form, trim = false) => {
    let hasEmpty = 0;
    const values = Object.fromEntries(new Map(Array.from(form.elements)
        .filter((item) => ((!item.getAttribute('readonly')) && (item.name)))
        .map((element) => {
            let {name, value} = element;
            value != "" ? value = value.replace(/[^a-zA-z0-9а-яА-Я@.,&?]/g, "") : hasEmpty = true;
            value = trim ? $.trim(value) : value;
            return [ name, value ]
    })));

    return hasEmpty ? false : values;
};

function redirect(url) {
    window.location.href = url;
}

const get_url_attr = (sParam) => {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};


const format = (clear_str, pattern = 'xxx xxx xx xx') => {
    let new_str = "";
    let offset = 0;
    for (let i = 0; i < pattern.length; i++) {
        if (pattern.charAt(i) === 'x')
            new_str += clear_str.charAt(i - offset) ? clear_str.charAt(i - offset) : ''; 
        else{
            new_str += pattern.charAt(i);
            offset++;
        }
    }

    return new_str;
};


const real_time_format = (clear_str, pattern = 'xxx xxx xx xx') => {
    return null;
};

const price_format = (price) => {
    return price + " ₽";
};

function fill_field(field, data, placeholder) {
    if (data === 'null')
        field.attr('placeholder', placeholder)
    else {
        field.val(data);
        field.attr('readonly', true);
    }
};
