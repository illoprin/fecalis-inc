<?php
$root = $_SERVER['DOCUMENT_ROOT'];
include_once $root . '/config.php';
require_once $root . '/server/functions.php';

session_start();

if (!check_auth()) {
    header('Location: /app/auth?mode=login');
    exit;
} else if (empty($_SESSION['cart'])) {
    header('Location: /app/catalogue');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FecalisInc - Оформление заказа</title>

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
    <script src="/js/server.js"></script>
    <script src="/js/front_functions.js"></script>
    <script src="/js/cart_controller.js"></script>
    <script src="/js/js_pages/purchase_page.js"></script>

</head>


<body data-bs-theme="dark">
    <div class="container vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="w-100">
            <h2 class="text-center mb-4">Оформление заказа</h2>
            <div class="align-middle bg-body-secondary p-3 rounded-3 border border-secondary-subtle">
                <div class="p-3" id="product_root">

                    <?php
                    require_once $root . '/server/cart.php';
                    require_once $root . '/server/db.php';
                    $pdo = Database::getInstance();

                    $cart = get_cart_info();


                    $total_cost = $cart['total_cost'];
                    unset($cart['total_cost']);
                    foreach ($cart as $info):
                        $id = intval($info['id']);
                        $qty = intval($info['qty']);

                        $cost = intval($info['cost']);
                    ?> 

                            <!-- Cart Product Element -->
                            <div class="row p-3 m-2 mb-4 rounded-3 shadow-lg border bg-body-secondary" id="cart_product_<?php echo $id ?>">
                                <div class="col-md-2 text-start align-content-center">
                                    <img class="rounded" src="<?php echo $info['img_src'] ?>" width="120" alt="CartProductImg" id="cart_product_img">
                                </div>
                                <div class="col-4 d-flex flex-column">
                                    <h4 class="fs-5 fw-bold" id="cart_product_title"><?php echo $info['title'] ?></h4>
                                    <p class="fw-medium" id="cart_product_vendor"><?php echo $info['vendor'] ?></p>
                                    <a href="<?php echo "/app/product?id={$id}" ?>" class="mt-auto" id="cart_product_more">Подробнее</a>
                                </div>
                                <div class="col-2 text-center align-content-center">
                                    <p class="fw-medium fs-5 mb-0" id="cart_product_price"><?php echo $info['price'] ?> ₽</p>
                                </div>
                                <div class="col-2 text-center d-flex justify-content-center align-items-center gap-2">
                                    <button type="button" class="btn btn-emoji p-0 fs-4" onclick="update_cart(<?php echo $id ?>, -1, <?php echo $info['price'] ?>)">🔻</button>
                                    <p class="fw-medium mb-0 fs-5" id="cart_product_qty_<?php echo $id ?>"><?php echo $qty ?></p>
                                    <button type="button" class="btn btn-emoji p-0 fs-4" onclick="update_cart(<?php echo $id ?>, 1, <?php echo $info['price'] ?>)">🔺</button>
                                </div>
                                <div class="col-2 text-center d-flex justify-content-between align-items-center">
                                    <p class="fw-medium fs-5 mb-0" id="cart_product_cost_<?php echo $id ?>"><?php echo $cost ?> ₽</p>
                                    <button type="button" class="btn fs-5 btn-danger" id="cart_product_del" onclick="delete_cart_product(<?php echo $id ?>, <?php echo $info['price'] ?>)">🗑</button>
                                </div>
                            </div>

                    <?php
                    endforeach;
                    ?>
                </div>

                <div class="row px-4 mb-md-4 align-top">
                    <div class="col text-start">
                        <h4 class="fw-medium">Общая стоимость</h4>
                    </div>
                    <div class="col text-end">
                        <h4 class="fw-bold" id="cart_total"><? echo $total_cost ?> ₽</h4>
                    </div>
                </div>

                <?


                // Get user data
                $user_payment_id = $_COOKIE['payment_id'];
                $sql = 'SELECT card_number FROM payment WHERE id = ?';
                $card_number = query($sql, [$user_payment_id])[0]['card_number'];


                $user_id = $_COOKIE['id'];
                $delivery_address = isset($_COOKIE['delivery_address']) ? $_COOKIE['delivery_address'] : 'null';
                $card_number =  isset($card_number) ? $card_number : 'null';
                ?>

                <script>
                    const user_data = {
                        user_id: <? echo $user_id ?>,
                        delivery_address: '<? echo $delivery_address ?>',
                        card_number: '<? echo $card_number ?>',
                    }
                </script>

                <form class="form" method="POST" action="" id="purchase_form">
                    <div class="row mb-3 g-3">
                        <div class="col">
                            <label class="form-label">Платёжная система</label>
                            <input type="text" class="form-control" id="card_number" name="card_number" placeholder=""
                                maxlength="32">
                        </div>
                        <div class="col">
                            <label class="form-label">Адрес доставки</label>
                            <input type="text" class="form-control" id="delivery_address" name="delivery_address" placeholder="" maxlength="128">
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="/app/catalogue/" class="btn btn-danger">Вернуться к каталогу</a>
                        <button class="btn btn-success" id="purchase">Оформить заказ</button>
                    </div>
                </form>

            </div>

            <!-- Error block -->
            <div class="mt-5 d-none" id="error">
                <div class="alert alert-danger" role="alert">
                    <div class="row align-items-center justify-content-start">
                        <div class="col" id="error_message">
                            Данные введены не верно
                        </div>
                        <div class="col-md-auto align-self-end">
                            <button class="btn btn-secondary bg-danger" id="hide_error">X</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    
    <script src="/js/error_block_handle.js"></script>
    <script>
        fill_field($('#card_number'), user_data.card_number == 'null' ? 'null' : format(user_data.card_number, 'xxxx xxxx xxxx xxxx'), 'XXXX XXXX XXXX XXXX');
        fill_field($('#delivery_address'), user_data.delivery_address, 'Введите адрес доставки');
        purchase_action();
    </script>
</body>