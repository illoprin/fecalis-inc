<?php
    $root = $_SERVER['DOCUMENT_ROOT'];

    require_once $root . '/server/cart.php';
    require_once $root . '/server/db.php';
    $pdo = Database::getInstance();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FecalisInc - Каталог</title>

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
    <script src="/js/modules/toggle_view_by_radio.js"></script>
    <script src="/js/server.js"></script>
    <script src="/js/front_functions.js"></script>

</head>

<body data-bs-theme="dark">
    <?php
        require_once $root . '/blocks/header.php';
    ?>

    <!-- Sort and search -->
    <div class="container mt-4">
        <div class="row justify-content-md-center align-items-center">

            <div class="col">
                <div class="row g-3 justify-content-md-between">
                    <div class="col-3 d-flex">
                        <div class="btn-group" role="group">
                            <!-- Category Selector -->
                            <?
                                $active_category = isset($_GET['category']) ? intval($_GET['category']) : 1;

                                $sql = 'SELECT * FROM category';
                                $category_query = query($sql);
                                foreach ($category_query as $category):
                                    $checked = $active_category == intval($category['id']) ? 'checked' : '';
                            ?>
                            <input type="radio" class="btn-check" name="btnradio" id="radio_<? echo $category['id'] ?>" autocomplete="off" data-show-panel="block_<? echo $category['id'] ?>" <? echo $checked ?>>
                            <label class="btn btn-outline-primary" for="radio_<? echo $category['id'] ?>"><? echo $category['name'] ?></label>
                            <? endforeach; ?>
                        </div>
                    </div>

                    <div class="col">
                        <div class="row g-3 justify-content-md-end">
                            <div class="col-md-8">
                                <input class="form-control" placeholder="Поиск"
                                    aria-label="Поиск" id="search_field">
                            </div>
                            <div class="col-md-auto">
                                <button class="btn btn-success">🔍</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 ms-md-auto">
                <button class="btn btn-danger ml-auto" id="cart_toggle_btn" data-bs-toggle="modal" data-bs-target="#cart_modal">🛒</button>
            </div>
        </div>

    </div>

    <!-- Products Section -->
    <div class="container mt-4" id="products_section">
        <!-- Product Categories Blocks -->
        <?
        foreach ($category_query as $category):
            $display = $active_category == intval($category['id']) ? '' : 'd-none';
        ?>

        <div id="block_<? echo $category['id']?>" class="row <? echo $display ?>" data-db-id="<? echo $category['id']?>">
                
            <!-- Get product list -->
            <?
                $sql = 'SELECT id, title, price, img_src FROM product WHERE category_id = ?';
                $product_query = query($sql, [$category['id']]);
            ?>

            <? foreach ($product_query as $product): ?>
            <!-- Product -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<? echo $product['img_src'] ?>" width="300" height="300" class="card-img-top" alt="Товар" id="product_img">
                    <div class="card-body">
                        <h5 class="card-title" id="product_title"><? echo $product['title'] ?></h5>
                        <p class="card-text" id="product_price">Цена: <? echo $product['price'] ?> ₽ за тонну</p>
                        <a href="/app/product?id=<? echo $product['id'] ?>" class="btn btn-primary" id="product_more">Подробнее</a>
                    </div>
                </div>
            </div>
            <!-- Product End -->
            <? endforeach; ?>

                
        </div>

        <? endforeach; ?>

    </div>

    <?php
        require_once $root . '/blocks/footer.html';
    ?>
    

    <!-- Cart Modal Window -->
    <div class="modal fade" id="cart_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"  aria-hidden="true">
        <!-- Modal Dialog BG -->
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-black bg-opacity-50">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel">Корзина товаров</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="cart_confirm"></button>
                </div>
                <div class="modal-body">
                    <div id="cart_contents">
                        <!-- Table header -->
                        <div class="row m-2 text-center">
                            <div class="col-md-2">Позиция</div>
                            <div class="col-4">Наименование</div>
                            <div class="col-2">Цена</div>
                            <div class="col-2">Количество</div>
                            <div class="col-2">Стоимость</div>
                        </div>

                        <div id="cart_product_root">
                            <!-- GET CART INFO -->
                            <?
                                include_once $root . '/server/cart.php';
                                $cart = get_cart_info();
                                $total_cost = $cart['total_cost'];
                                unset($cart['total_cost']);
                            ?>
                            <!-- SEND CART INFO TO FRONT -->
                            <script>
                                
                            </script>
                            
                            <!-- CREATE CART VIEW -->
                            <?
                                foreach ($cart as $product):
                            ?>


                            <!-- Cart Product Element -->
                            <div class="row p-3 m-2 rounded-3 shadow-lg border bg-black bg-opacity-50" id="cart_product_<? echo $product['id'] ?>">
                                <div class="col-md-2 text-start align-content-center">
                                    <img class="rounded" src="<? echo $product['img_src'] ?>" width="120" alt="CartProductImg">
                                </div>
                                <div class="col-4 d-flex flex-column">
                                    <h4 class="fs-5 fw-bold"><? echo $product['title'] ?></h4>
                                    <p class="fw-medium"><? echo $product['vendor'] ?></p>
                                    <a href="/app/product?id=<? echo $product['id'] ?>" class="mt-auto">Подробнее</a>
                                </div>
                                <div class="col-2 text-center align-content-center">
                                    <p class="fw-medium fs-5 mb-0"><? echo $product['price'] ?> ₽</p> 
                                </div>
                                <div class="col-2 text-center d-flex justify-content-center align-items-center gap-2">
                                    <p class="fw-medium mb-0 fs-5" id="cart_product_qty"><? echo $product['qty'] ?></p>
                                </div>
                                <div class="col-2 text-center d-flex justify-content-center align-items-center">
                                    <p class="fw-medium fs-5 mb-0" id="cart_product_cost"><? echo $product['cost'] ?> ₽</p>
                                    <button type="button" class="btn p-0 fs-5 btn-emoji m-lg-auto" onclick="delete_cart_element(<? echo $product['id'] ?>, <? echo $product['cost'] ?>)">🗑</button>
                                </div>
                            </div>
                            <!-- Cart Product End -->

                            <? endforeach; ?>
                        </div>
                        

                    </div>

                    <div class="row px-4 mt-md-3 mb-md-2">
                        <div class="col text-start">
                            <h4 class="fw-medium">Общая стоимость</h4> 
                        </div>
                        <div class="col text-end">
                            <h4 class="fw-bold" id="cart_total"><? echo $total_cost ?> ₽</h4> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger" id="cart_clear" title="Очистить корзину" onclick="clear_cart_view()">❌</button>
                    <a class="btn btn-success" href="/app/purchase/" title="Оформить заказ">✅</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Modal Window -->


    <!-- Import Catalogue Controller Script -->
    <script src="/js/cart_controller.js"></script>
    <script src="/js/js_pages/catalogue.js"></script>
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
</body>

</html>