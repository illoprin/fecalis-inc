<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    $root = $_SERVER['DOCUMENT_ROOT'];

    if (!isset($_COOKIE['login'])) {
        header('Location: /app/auth?mode=login');
        exit;
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FecalisInc - Личный кабинет</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous" defer></script>


    <!-- Font Montserrat Load -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- JQuery load -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Import Main CSS file -->
    <link rel="stylesheet" href="/styles/main.css">

    <!-- Import Front-Back functions JS -->
    <script src="/js/server.js"></script>

    <!-- Import supporting functions JS -->
    <script src="/js/front_functions.js"></script>

    <!-- Import Account Controller JS Script -->
    <!-- Load User Data -->
    <script src="/js/js_pages/account.js" defer></script>

    <script src="/js/modules/toggle_view_by_radio.js"></script>
    <script src="/js/modules/image_drag_loader.js"></script>

</head>

<body data-bs-theme="dark">
    <?php
        require_once $root . '/blocks/header.php';
        
        // 1 - user_data
        // 2 - order
        // 3 - controls
        $mode = isset($_GET['mode']) ? $_GET['mode'] : 'user_data';    
    ?>

    <script>
        let mode = '<? echo $mode ?>';

        const cookie_data = {
            card_number: format('<? echo $_COOKIE['card_number'] ?>', 'xxxx xxxx xxxx xxxx'),
            phone: '+7 ' + format('<? echo $_COOKIE['phone'] ?>', '(xxx) xxx xx-xx'),
            firstname: '<? echo $_COOKIE['firstname'] ?>',
            secondname: '<? echo $_COOKIE['secondname'] ?>',
            login: '<? echo $_COOKIE['login'] ?>',
            email: '<? echo $_COOKIE['email'] ?>',
            delivery_address: '<? echo isset($_COOKIE['delivery_address']) ? $_COOKIE['delivery_address'] : 'Сделайте первый заказ ✔' ?>'
        }

    </script>


    <!-- Personal Data Control -->
    <div class="container mt-3">
        <div class="row gap-3 w-auto h-100 p-3">
            <!-- Left Column -->
            <div class="col-md-3 d-flex gap-3 flex-column">
                <div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary">
                    <div class="rounded" id="user_avatar" style="background-image: url(<? echo $_COOKIE['avatar_src'] ?>)"></div>
                </div>
                <div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary">

                    <!-- Vertical Group Selector -->
                    <div class="btn-group-vertical w-100" role="group" aria-label="Account page mode selector">
                        <input type="radio" class="btn-check" name="mode" id="radio_user_data" autocomplete="off" data-show-panel="user_data">
                        <label class="btn btn-outline-light pt-3 pb-3" for="radio_user_data">Данные
                            пользователя</label>
                        <input type="radio" class="btn-check" name="mode" id="radio_order" autocomplete="off" data-show-panel="order">
                        <label class="btn btn-outline-light pt-3 pb-3" for="radio_order">Заказы</label>
                        <!-- <input type="radio" class="btn-check" name="mode" id="radio_controls" autocomplete="off" data-show-panel="controls">
                        <label class="btn btn-outline-light pt-3 pb-3" for="radio_controls">Управление
                            аккаунтом</label> -->
                    </div>


                </div>
            </div>
            <!-- Right Column -->

            <!-- User Data Section -->
            <div class="col d-none" id="user_data">
                <div class="d-flex gap-3 flex-column">
                    <div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary">
                        <h3>Личные данные</h3>

                        <div class="mt-4">
                            <div class="row">
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">Имя</p>
                                    <h3 class="fs-4" id="user_firstname"></h3>
                                </div>
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">Фамилия</p>
                                    <h3 class="fs-4" id="user_secondname"></h3>
                                </div>
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">Логин</p>
                                    <h3 class="fs-4" id="user_login"></h3>
                                </div>
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">E-mail</p>
                                    <h3 class="fs-4" id="user_email"></h3>
                                </div>
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">Номер телефона</p>
                                    <h3 class="fs-4" id="user_phone"></h3>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary">
                        <h3>Оплата и доставка</h3>

                        <div class="mt-4">
                            <div class="row">
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">Номер карты</p>
                                    <h4 class="fs-4" id="user_card_number"></h4>
                                </div>
                                <div class="col-5">
                                    <p class="text-secondary-emphasis mb-0">Адрес доставки</p>
                                    <h4 class="fs-4" id="user_delivery_address"></h4>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Order Section -->
            <div class="col d-none" id="order">
                <div class="d-flex gap-3 flex-column">
                    <div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary">
                        <!-- Header -->
                        <div class="row justify-content-between">
                            <div class="col-md-auto">
                                <h3>Управление заказами</h3>
                            </div>
                            <div class="col-5">
                                <div class="btn-group d-flex gap-3" role="group" aria-label="Basic radio toggle button group">

                                    <input type="radio" class="btn-check" name="status_filter" id="radio_inroad" autocomplete="off" data-show-panel="orders_inroad" checked>
                                    <label class="btn btn-outline-primary rounded-5" for="radio_inroad">В пути</label>

                                    <input type="radio" class="btn-check" name="status_filter" id="radio_delivered" autocomplete="off" data-show-panel="orders_delivered">
                                    <label class="btn btn-outline-primary rounded-5" for="radio_delivered">Доставлено</label>

                                    <input type="radio" class="btn-check" name="status_filter" id="radio_cancelled" autocomplete="off" data-show-panel="orders_cancelled">
                                    <label class="btn btn-outline-danger rounded-5" for="radio_cancelled">Отменены</label>

                                </div>
                            </div>
                        </div>

                        <?
                            
                            // Connect to DB, get purchase table
                            require_once $root . '/server/db.php';
                            $pdo = Database::getInstance();

                            // Get inroad order
                            $sql = 'SELECT * FROM purchase WHERE delivery_status = ? AND client_id = ? ORDER BY time_created DESC';
                            $order_inroad = query($sql, [1, $_COOKIE['id']]);


                            // Get delivered order
                            $sql = 'SELECT * FROM purchase WHERE delivery_status = ? AND client_id = ? ORDER BY time_created DESC';
                            $order_delivered = query($sql, [0, $_COOKIE['id']]);

                            // Get cancelled order
                            $sql = 'SELECT * FROM purchase WHERE delivery_status = ? AND client_id = ? ORDER BY time_created DESC';
                            $order_cancelled = query($sql, [2, $_COOKIE['id']]);
                        ?>

                        <!-- Orders -->
                        <div class="mt-3">
                            <!-- Order inroad block -->
                            <div id="orders_inroad">

                                <?
                                if (!empty($order_inroad)):
                                foreach ($order_inroad as $order):
                                    $entries = json_decode($order['entries'], true);
                                    $date_created = date(DATETIME_FORMAT, strtotime($order['time_created']));
                                    $delivery_date = date(DATE_FORMAT, strtotime($order['delivery_date']));
                                    $order_id = str_pad($order['id'], 4, '0', STR_PAD_LEFT);
                                ?>
                                
                                <!-- Order inroad -->
                                <div class="p-3 bg-body-tertiary rounded border border-secondary-subtle w-100 mb-3">
                                    <div class="row">
                                        <div class="col text-start">
                                            <h5>Заказ №ID<? echo $order_id ?></h5>

                                        </div>
                                        <div class="col text-end">
                                            <h5 class="fs-5">от <? echo $date_created ?></h5>
                                        </div>
                                    </div>
                                    <!-- Order Entrys -->
                                    <div class="mt-3">
                                        <b class="ft-5">Состав заказа</b>
                                        <? foreach ($entries as $entry): ?>
                                        <!-- Order Entry -->
                                        <div class="row">
                                            <div class="col-7">
                                                <? echo $entry['title'] ?>
                                            </div>
                                            <div class="col-3">
                                                <? echo $entry['qty'] ?> штук
                                            </div>
                                            <div class="col-2">
                                                <? echo $entry['cost'] ?> ₽
                                            </div>
                                        </div>
                                        <!-- ======= -->
                                        <? endforeach; ?>
                                    </div>
    
                                    <div class="row mt-3">
                                        <div class="col">
                                            <h5>Общая стоимость:</h5>    
                                        </div>
                                        <div class="col-3 text-center">
                                            <h5 class="text-success w-100"><? echo $order['total_cost'] ?>₽</h5>
                                        </div>
                                    </div>
    
                                    <div class="row mt-3 d-flex justify-content-between align-items-center">
                                        <div class="col-md-auto">
                                            <h5 class="mb-0">
                                                Статус:
                                            </h5>  
                                        </div>
                                        <div class="col-md-auto">
                                            <h5 class="text-center text-success mb-0">
                                                В пути
                                            </h5>
                                        </div>
                                        <div class="col-md-auto">
                                            <p class="fs-6 text-secondary mb-0">
                                                Ожидаемая дата доставки
                                            </p>
                                            <h5 class="mb-0">
                                                <? echo $delivery_date ?>
                                            </h5>
                                        </div>
                                        <div class="col-md-auto align-self-end">
                                            <button class="btn btn-outline-danger float-end" id="cancel_order" onclick="cancel_order(<? echo $order['id'] ?>)">❌</button>
                                        </div>
                                    </div>
                                </div>

                                <? endforeach; endif; ?>
                                
                                <!-- Has no orders case -->
                                <? if (empty($order_inroad)): ?>
                                    <div class="text-center">
                                        <h2 class="w-100 h-25 text-center mt-5">Заказов нет! Закажите 😀</h2>
                                        <a href="/app/catalogue/" class="btn btn-success w-25 h-25 mt-5 mb-5">Перейти к каталогу</a>
                                    </div>
                                <? endif; ?>



                            </div>

                            <!-- Delivered order -->
                            <div class="d-none" id="orders_delivered">

                                <?
                                if (count($order_delivered) > 0):
                                foreach ($order_delivered as $order):
                                    $entries = json_decode($order['entries'], true);
                                    $date_created = date(DATE_FORMAT, strtotime($order['time_created']));
                                    $date_delivered = date(DATE_FORMAT, strtotime($order['delivery_date']));
                                    $order_id = str_pad($order['id'], 4, '0', STR_PAD_LEFT);
                                ?>

                                <div class="p-3 bg-body-tertiary rounded border border-secondary-subtle w-100 mb-3">
                                    <h5>Заказ №ID<? echo $order_id ?></h5>
                                    <!-- Order Entrys -->
                                    <div class="mt-3">
                                        <b class="ft-5">Состав заказа</b>
                                        <? foreach ($entries as $entry): ?>
                                        <!-- Order Entry -->
                                        <div class="row">
                                            <div class="col-7">
                                                <? echo $entry['title'] ?>
                                            </div>
                                            <div class="col-3">
                                                <? echo $entry['qty'] ?>
                                            </div>
                                            <div class="col-2">
                                                <? echo $entry['cost'] ?> ₽
                                            </div>
                                        </div>
                                        <!-- ======= -->
                                        <? endforeach; ?>
                                        
                                    </div>
    
                                    <div class="row mt-3">
                                        <div class="col">
                                            <h5>Общая стоимость:</h5>    
                                        </div>
                                        <div class="col-3 text-center">
                                            <h5 class="w-100"><? echo $order['total_cost'] ?> ₽</h5>
                                        </div>
                                    </div>

                                    <div class="row mt-3 d-flex justify-content-between">
                                        <div class="col-3">
                                            <p class="fs-6 text-secondary mb-0">
                                                Заказ сделан
                                            </p>
                                            <h5 class="">
                                                <? echo $date_created ?>
                                            </h5>
                                        </div>
                                        <div class="col-3 text-end">
                                            <p class="fs-6 text-secondary mb-0">
                                                Заказ доставлен
                                            </p>
                                            <h5 class="">
                                                <? echo $date_delivered ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <? endforeach; endif; ?>


                            </div>


                            <div class="d-none" id="orders_cancelled">
                                <?
                                if (count($order_cancelled) > 0):
                                foreach ($order_cancelled as $order):
                                    $entries = json_decode($order['entries'], true);
                                    $date_created = date(DATE_FORMAT, strtotime($order['time_created']));
                                    $date_delivered = date(DATE_FORMAT, strtotime($order['delivery_date']));
                                    $order_id = str_pad($order['id'], 4, '0', STR_PAD_LEFT);
                                ?>

                                <!-- Order CANCELLED -->
                                <div class="p-3 bg-body-tertiary rounded border border-secondary-subtle w-100 mb-3">
                                    <div class="row">
                                        <div class="col text-start">
                                            <h5>Заказ №ID<? echo $order_id ?></h5>

                                        </div>
                                        <div class="col text-end">
                                            <h5 class="fs-5">от <? echo $date_created ?></h5>
                                        </div>
                                    </div>
                                    <!-- Order Entrys -->
                                    <div class="mt-3">
                                        <b class="ft-5">Состав заказа</b>
                                        <? foreach ($entries as $entry): ?>
                                        <!-- Order Entry -->
                                        <div class="row">
                                            <div class="col-7">
                                                <? echo $entry['title'] ?>
                                            </div>
                                            <div class="col-3">
                                                <? echo $entry['qty'] ?> штук
                                            </div>
                                            <div class="col-2">
                                                <? echo $entry['cost'] ?> ₽
                                            </div>
                                        </div>
                                        <!-- ======= -->
                                        <? endforeach; ?>
                                    </div>
    
                                    <div class="row mt-3">
                                        <div class="col">
                                            <h5>Общая стоимость:</h5>    
                                        </div>
                                        <div class="col-3 text-center">
                                            <h5 class="w-100"><? echo $order['total_cost'] ?>₽</h5>
                                        </div>
                                    </div>
    
                                    <div class="row mt-3 d-flex justify-content-between align-items-center">
                                        <div class="col-md-auto">
                                            <h5 class="mb-0">
                                                Статус:
                                            </h5>  
                                        </div>
                                        <div class="col-md-auto">
                                            <h5 class="text-center text-danger mb-0">
                                                Отменён
                                            </h5>
                                        </div>
                                        <div class="col-md-auto text-end">
                                            <p class="fs-6 text-secondary mb-0">
                                                Дата отмены
                                            </p>
                                            <h5 class="mb-0">
                                                <? echo $date_delivered ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                


                                <? endforeach; endif; ?>



                                <!-- Has no orders case -->
                                <? if (empty($order_cancelled)): ?>
                                    <div class="text-center">
                                        <h2 class="w-100 h-25 text-center text-danger mt-5">Отменённых нет</h2>
                                        <h4 class="w-100 h-25 text-center mt-4 mb-5">И слава богу</h4>
                                    </div>
                                <? endif; ?>

                            
                                    
                            </div>


                        </div>



                    </div>
                </div>
            </div>

            <div class="col d-none" id="controls">

            </div>
        </div>
    </div>

    <?php
        require_once $root . '/blocks/footer.html';
    ?>


    
    <script>

        // JQuery required
        toggle_tabs_handler(
            [$('#radio_user_data'), $('#radio_order')],
            [$('#user_data'), $('#order')],
            'click', 'd-none'
        );

        toggle_tabs_handler(
            [$('#radio_inroad'), $('#radio_delivered'), $('#radio_cancelled')],
            [$('#orders_inroad'), $('#orders_delivered'), $('#orders_cancelled')],
            'click', 'd-none'
        );

        new ImageDragHandler(document.getElementById('user_avatar'), 'imagedragarea');


    </script>

</body>

</html>