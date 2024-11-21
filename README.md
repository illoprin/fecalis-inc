# FecalisInc
Интернет-магазин по продаже удобрений всех типов

![image](https://github.com/user-attachments/assets/70fb0d70-764e-4e88-ba6f-b1da302566ae)


### Использованы технологии:
- PHP 8.1
- Apache
- mySQL
- jQuery
- Bootstrap 5 (CDN)

### Cкрины прикольные
**Форма регистрации**
![image](https://github.com/user-attachments/assets/594c3d9e-53c0-40ab-988c-7b7021ab7a49)

**Форма авторизации**
![image](https://github.com/user-attachments/assets/18292dba-e37a-43ed-99e5-414e81ad813f)

**Каталог**
![image](https://github.com/user-attachments/assets/01a23255-a38b-4490-886f-3f1caaa6baf5)

**Корзина товаров**
![image](https://github.com/user-attachments/assets/6f95b2a3-42b2-4512-b80a-80de65ac99cb)

**Личный кабинет с заказами**
![image](https://github.com/user-attachments/assets/6be3afc4-f229-46c2-85ab-a09e3f9fb2d6)

Поменять аватар можно просто перетащив изображение на страницу 😁

**Админ панель - добавить новый товар**
![image](https://github.com/user-attachments/assets/2087a8f5-1e74-4a7d-be79-0ce1a3aec21b)




### Структура БД


### Таблица User
<table>
	<tr>
		<th>id</th>
		<th>login</th>
		<th>password</th>
		<th>firstname</th>
		<th>secondname</th>
		<th>phone</th>
		<th>delivery_address</th>
		<th>email</th>
		<th>payment_id</th>
		<th>avatar_src</th>
		<th>role</th>
	</tr>
</table>

### Таблица Product
<table>
	<tr>
		<th>id</th>
		<th>category_id</th>
		<th>title</th>
		<th>description</th>
		<th>vendor</th>
		<th>price</th>
		<th>img_src</th>
	</tr>
</table>

### Таблица Purchase (заказ)
<table>
	<tr>
		<th>id</th>
		<th>client_id</th>
		<th>entries</th>
		<th>time_created</th>
		<th>delivery_date</th>
		<th>total_cost</th>
		<th>delivery_status</th>
	</tr>
</table>

**entries** - содержит json в виде строки с информацией о выбранных позициях товара. Зачем, если можно хранить просто idшники. Это необходимо, например, для сохранения истории заказов. Допустим, позиция была удалена из каталога, но, при такой системе, она не пропадёт из истории.

**delivery_date** - так как сервис нихрена не доставляет, это лишь оболочка с сервером, дата доставки высчитывается случайно в диапазоне от 3 дней до 5-ти. По достижению даты доставки, в 12:00 ночи заказ считается доставленым.


Это было описание основных таблиц, есть ещё таблицы с говорящими названиями category, payment, rating. Но на них не будем заострять внимание. Они вспомогательные.


### Основные пути

**app/catalogue** - каталог с корзиной

**app/product/:id** - страница с информацией о товаре, есть кнопка добавить в корзину. Информация о корзине содержится в `$_SESSION['cart']`

**app/purchase** - страница оформления заказа. отображает все выбраные позиции с картинками и прайсом в столбик и итоговую цену. Cодержит форму ввода адреса доставки

**app/account** - личный кабинет пользователя (в случае отсутствия куки идёт редирект на страницу авторизации). на одной странице есть выбор между двума видами: Личные данные, Заказы

**app/authorization/:mode=reg|login** - выбор между регистрацией и входом в аккаунт

**app/admin/:mode=order|product** - админ панель с возможностью изменять статусы заказов, удалять или добавлять товары

**index.php** в корне - подключение к базе данных через, удаление отменённых заказов старше 30 дней, переадресация либо на лэндинг, либо на ЛК в зависимости от наличия куки

**/static/index.php** - перенаправляет либо на лендиг либо на `about` в зависимости от параметра page


### Самописные JS скрипты


#### Форматирование вводимых данных
Просто вводишь паттерн и функция сама подгоняет циферки или буковки в эти поля
```javascript
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
```
Это можно делать автоматически при вводе пользователем данных. С какаим-нибудь фреймворком, типа Vue или React это было бы проще.

```javascript
function check_card_date () {
    const input = form.elements.card_date;
    input.addEventListener('input', (e) => {
        input.value = $.trim(input.value.replace(/[^0-9]/g, ""));
        input.value = format(input.value, 'xx/xx');
    });
}
```

#### Автоматическое переключение между видами по нажатию `radio` кнопки

```javascript
const toggle_tabs_handler = (radios = [], blocks = [], event_to_handle, hide_class, on_toggle_event = (block) => {}) => {
    radios.forEach((radio) => {
        radio.on(event_to_handle, () => {
            blocks.forEach((block) => {
                if (block.attr('id') === radio.attr('data-show-panel')){
                    block.removeClass(hide_class)
                    on_toggle_event(block[0]);
                    return block[0];
                }else {
                    block.addClass(hide_class);
                }
                
            });
        });
    });
}
```

Привязка такого скрипта к блокам `div` и `radio` происходит следующим образом

```javascript
// JQuery required
toggle_tabs_handler(
    // Radio IDs
    [$('#radio_user_data'), $('#radio_order'), $('#radio_controls')],
    // div blocks IDs
    [$('#user_data'), $('#order'), $('#controls')],
    // Event to handle
    'click', 
    // Hide class to toggle
    'd-none',
);
```

Написал ещё короче кал, который тримует и удаляет спецсимволы из данных, которые ввёл пользователь. Он ещё форму в JSON объект записывает, где `name` это ключ, а `value` это значение.
Он жёстко чистит данные, удаляет даже пробелы, но это можно исправить, если добавить пробел в регулярное выражение `replace`

```javascript
// JQuery required
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
```

###### до сих пор не понимаю как именуются функции или переменные в JS вот так `funсName` или вот так `func_name`. странная привычка появилась лет 10 назад, именовать всё в JS через нижние подчёркивания


### Поливаю PHP какашками без смс и регистрации

PDO работает медленно, страшно медленно. 2 секунды на подключение к БД. Это кошмар. При чём, я не могу подключится к БД один раз на сервере и просто гонять данные туда суда. При выполнении любого скрипта, связанного с БД, необходимо новое подключение. Пиздец!


Ещё в этом коде можно увидеть такой колхоз ахахаха. ПХПшный код встроенный в JavaScript. Такое может только **PHP**.


```html
<script>
    handle_cart_view();
    // JQuery required
    toggle_tabs_handler(
        [
            <? foreach ($category_query as $category): ?>
                $('#radio_<? echo $category['id']?>'),
            <? endforeach; ?>
        ],
        [
            <? foreach ($category_query as $category): ?>
                $('#block_<? echo $category['id']?>'),
            <? endforeach; ?>
        ],
        'click', 'd-none',
    );

    // Cart modal show event listener
    const cart_modal = $('#cart_modal')[0]
    cart_modal.addEventListener('shown.bs.modal', () => {
        console.log('Front: Cart modal shown');
    })
</script>
```

PHP, кажется, не пригоден для бэка. А так, как язык, прикольный.
