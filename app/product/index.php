<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FecalisInc - Товар</title>
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

</head>

<body data-bs-theme="dark">

    <?php
        require_once $root . '/blocks/header.php';

        include_once $root . '/server/db.php';
        require_once $root . '/server/functions.php';
        // Create instance of PDO
        $pdo = Database::getInstance();

        if (!isset($_GET['id']))
            header('/app/catalogue');

        $id = $_GET['id'];
        $sql = 'SELECT * FROM product WHERE id = ?';
        $info = query($sql, [$id])[0];

        $category_name = query('SELECT name FROM category WHERE id = ?', [$info['category_id']])[0]['name'];


    ?>


    <script>
        var dynamic_data = {
            price: <? echo $info['price'] ?>,
            total: 0,
            amount: 0,
            id: <? echo $id ?>,
        };
    </script>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-auto">
                <a href="#" class="nav-link">
                    <img src="/assets/ico/back.svg" width="10" alt="">
                </a>
            </div>
            <div class="col-md-auto">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/app/catalogue?category=<? echo $info['category_id'] ?>" id="product_category"><? echo $category_name ?></a></li>
                      <li class="breadcrumb-item active" aria-current="page" id="product_title_link"><? echo $info['title'] ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="<? echo $info['img_src'] ?>" class="rounded w-100 h-100 object-fit-cover" alt="Товар" id="product_img">
            </div>
            <div class="col-md-6">

                <div class="container h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h1 class="display-4" id="product_title"><? echo $info['title'] ?></h1>
                        <p>Поставщик: <b id="product_vendor"><? echo $info['vendor'] ?></b></p>
                        <p id="product_desc"><? echo $info['description'] ?></p>
                    </div>

                    <div class="mt-3">
                        <div id="price_block">
                            <h4 id="product_price"><? echo "{$info['price']} ₽" ?> за 5 кг</h4>
                            <button id="add_to_cart_btn" class="btn btn-primary">Добавить в корзину</button>
                        </div>
                        <div id="cart_controls" class="d-none">
                            <h4 id="product_total"></h4>
                            <div class="d-flex gap-3 align-content-center">
                                <button class="btn btn-emoji" id="decrease_qty">➖</button>
                                <input type="number" class="form-control w-25" id="quantity" value="5" class="form-control d-inline" readonly>
                                <button class="btn btn-emoji" id="increase_qty">➕</button>
                            </div>
                        </div>
                        
                    </div>

                </div>


            </div>
        </div>
    </div>

    <?php
        require_once $root . '/blocks/footer.html';
    ?>

    <script src="/js/cart_controller.js"></script>
    <script src="/js/js_pages/product_controller.js"></script>
    <script>   

        handle_cart();

    </script>
</body>