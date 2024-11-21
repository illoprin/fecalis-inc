<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    $root = $_SERVER['DOCUMENT_ROOT'];

    if (!isset($_COOKIE['login'])) {
        header('Location: /app/auth?mode=login');
        exit;
    }else if ($_COOKIE['role'] != '1') {
		header('Location: /app/user?mode=order');
	}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FecalisInc - Админ-панель</title>

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
</head>


<body data-bs-theme="dark">
    <!-- Header -->
    <?php
        require_once $root . '/blocks/header.php';  
    ?>

	<?
		$mode = isset($_GET['mode']) ? $_GET['mode'] : 'order';
		$order_section_class = $mode == 'order' ? '' : 'd-none';
		$product_section_class = $mode == 'product' ? '' : 'd-none';
		$order_radio_checked = $mode == 'order' ? 'checked' : '';
		$product_radio_checked = $mode == 'product' ? 'checked' : '';
	?>

	<div class="container mt-3">
        <div class="row gap-3 w-auto h-100 p-3">
            <!-- Left Column -->
            <div class="col-md-3 d-flex gap-3 flex-column">

                <div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary">
                    <!-- Vertical Group Selector -->
                    <div class="btn-group-vertical w-100" role="group" aria-label="Admin page mode selector">
                        <input type="radio" class="btn-check" name="mode" id="radio_order" autocomplete="off"
                            data-show-panel="order" <? echo $order_radio_checked ?>>
                        <label class="btn btn-outline-light pt-3 pb-3" for="radio_order">Заказы клиентов</label>
                        <input type="radio" class="btn-check" name="mode" id="radio_product" autocomplete="off" data-show-panel="product" <? echo $product_radio_checked ?>>
                        <label class="btn btn-outline-light pt-3 pb-3" for="radio_product">Товары</label>
                    </div>
                </div>

            </div>
            <!-- Right Column -->

			

            <!-- Order data Section -->
            <div class="col <? echo $order_section_class ?>" id="order">
				<div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary d-flex flex-column gap-3">
					<?php
						require_once $root . '/server/db.php';
						require_once $root . '/server/functions.php';

						$pdo = Database::getInstance();
						$sql = 'SELECT * FROM purchase ORDER BY time_created DESC';
						$order_query = query($sql);
					?>


					<?
					foreach ($order_query as $order):
						$entries = json_decode($order['entries'], true);
                        $date_created = date(DATE_FORMAT, strtotime($order['time_created']));
                        $date_delivery = date(DATE_FORMAT, strtotime($order['delivery_date']));
                        $order_id = str_pad($order['id'], 4, '0', STR_PAD_LEFT);

						$sql = 'SELECT firstname, secondname, login, avatar_src, phone FROM user WHERE id = ?';
						$user = query($sql, [$order['client_id']])[0];

						$status = '';
						$status_style = '';
						switch($order['delivery_status']) {
							case 0:
								$status = 'Доставлен';
								$status_style = '';
							break;
							case 1:
								$status = 'В пути';
								$status_style = 'text-success';
							break;
							case 2:
								$status = 'Отменён';
								$status_style = 'text-danger';
							break;
						}

						

					?>
					<!-- Order -->
					<div class="p-3 bg-body-tertiary rounded border border-secondary-subtle w-100">
						<div class="row align-items-baseline justify-content-between">
							<div class="col-4">
								<h5 class="fs-4 m-0 p-0">Заказ №ID<? echo $order_id ?></h5>
							</div>
							<div class="col-4 text-end">
								<p class="fs-5 m-0 p-0">от <? echo $date_created ?></p>
							</div>
						</div>

						<div class="row align-items-center mt-4">
							<div class="col-5">
								<div class="row">
									<div class="col-4">
										<img src="<? echo $user['avatar_src'] ?>" class="rounded-circle object-fit-cover" width="100" height="100" alt="">
									</div>
									<div class="col-7 d-flex flex-column justify-content-between">
										<div>
											<p class="m-0 fw-medium fs-5"><? echo "{$user['firstname']} {$user['secondname']}"?></p>
											<p class="text-secondary"><? echo $user['login'] ?></p>
										</div>
										<p class="m-0 fw-medium"><? echo "+7 {$user['phone']}" ?></p>
									</div>
								</div>
							</div>
							<div class="col-7">
								<div class="row text-start align-items-center">
									<div class="col-5 p-0">
										<p class="fs-6 text-secondary m-0">
											Дата доставки
										</p>
										<h5 class="mb-0">
											<? echo $date_delivery ?>
										</h5>
									</div>
									<div class="col">
										<p class="fs-6 text-secondary m-0">
											Общая цена
										</p>
										<h5 class="mb-0">
											<? echo $order['total_cost'] ?> ₽
										</h5>
									</div>
									<div class="col">
										<p class="fs-6 text-secondary m-0">
											Статус
										</p>
										<h5 class="mb-0 <? echo $status_style ?>">
											<? echo $status ?>
										</h5>
									</div>
								</div>
							</div>
						</div>

						<div class="mt-3">
							<h5 class="fw-bolder">Состав заказа</h5>
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
						
						<? if ($order['delivery_status'] == 1): ?>
						<div class="row mt-4">
							<div class="col text-start">
								<button 
									class="btn btn-danger" 
									id="cancel_order"
									onclick="set_status(<? echo $order['id'] ?>, 2)"
								>
										❌ Отменить
								</button>
							</div>
							<div class="col text-end">
								<button 
									class="btn btn-success" 
									id="cancel_order"
									onclick="set_status(<? echo $order['id'] ?>, 0)"
								>
										Доставлено ✅
								</button>
							</div>
						</div>
						<? endif; ?>

					</div>
					<? endforeach; ?>
				</div>
			</div>

			<!-- Product Section -->
            <div class="col <? echo $product_section_class ?>" id="product">
				<div class="p-3 rounded-3 border border-secondary-subtle bg-body-secondary d-flex flex-column gap-3">
					
					<button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#new_product_modal">Добавить новый товар</button>
					
					<?php
						$sql = 'SELECT * FROM product ORDER BY title';
						$product_query = query($sql);
					?>

					<? foreach($product_query as $product): ?>
					<!-- Product Section -->
					<div class="row p-3 m-0 rounded-3 shadow-lg border bg-black bg-opacity-50" id="cart_product">
						<div class="col-2 text-start align-content-center p-0">
							<img class="rounded" src="<? echo $product['img_src'] ?>" width="120" alt="Product Img">
						</div>
						<div class="col-5 d-flex flex-column p-0">
							<h4 class="fs-5 fw-bold"><? echo $product['title'] ?></h4>
							<p class="fw-medium"><? echo $product['vendor'] ?></p>
							<a href="/app/product?id=<? echo $product['id'] ?>" class="mt-auto" id="cart_product_more">Подробнее</a>
						</div>
						<div class="col-5 d-flex flex-column justify-content-between align-items-end p-0">
							<button 
								class="btn btn-primary"
								disabled 
							>
								🔧
							</button>
							<button class="btn btn-danger" onclick="remove_product(<? echo $product['id'] ?>)">❌</button>
						</div>
					</div>
					<? endforeach; ?>
					
				</div>
			</div>


			<!-- Add Product Modal Window -->
			<div class="modal fade" id="new_product_modal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"  aria-hidden="true">
				<!-- Modal Dialog BG -->
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content bg-black bg-opacity-50">
						<div class="modal-header">
							<h5 class="modal-title">Добавить новый товар</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form action="" name="np">
								<div class="form-group">
									<div class="row">
										<div class="col">
											<label for="np_image" class="form-label text-secondary">Загрузите изображение товара</label>
											<input type="file" class="form-control" name="product_img" id="np_image">
										</div>

										<?
											$sql = 'SELECT id, name FROM category';
											$categories = query($sql);
										?>

										<div class="col">
											<label for="np_category" class="form-label text-secondary">Выберете категорию</label>
											<select name="category_id" class="form-select" id="np_category">
												<option value="" selected>Выберите категорию</option>
												<? foreach($categories as $category): ?>
    											<option value="<? echo $category['id']?>"><? echo $category['name'] ?></option>
												<? endforeach; ?>
											</select>
										</div>
									</div>
									
								</div>
								<div class="form-group mt-3">
									<div class="row">
										<div class="col">
											<label for="np_title" class="form-label text-secondary">Наименование</label>
											<input type="text" maxlength="128" class="form-control" name="title" id="np_title">
										</div>
										<div class="col">
											<label for="np_vendor" class="form-label text-secondary">Поставщик</label>
											<input type="text" maxlength="128" class="form-control" name="vendor" id="np_vendor">
										</div>
									</div>
								</div>
								<div class="form-group mt-3">
									<label for="np_description" class="form-label text-secondary">Описание товара</label>
									<textarea type="text" maxlength="128" class="form-control" name="description" id="np_description"></textarea>
								</div>
								<div class="form-group mt-3">
									<label for="np_price" class="form-label text-secondary">Цена за 5 кг</label>
									<input type="number" maxlength="128" class="form-control" name="price" id="np_price">
								</div>
							</form>
						</div>
						<div class="modal-footer d-flex justify-content-between">
							<button class="btn btn-danger" onclick="clear_form()">Очистить форму</button>
							<button class="btn btn-primary" onclick="add_product()">Добавить товар</button>
						</div>
					</div>
				</div>
			</div>

		</div>	
	</div>
	
	<?php
        require_once $root . '/blocks/footer.html';
    ?>

	<script src="/js/server.js"></script>
	<script src="/js/front_functions.js"></script>
    <script src="/js/modules/toggle_view_by_radio.js"></script>
	<script src="/js/js_pages/admin.js"></script>
	<script>
		toggle_tabs_handler(
			[$('#radio_order'), $('#radio_product')],
			[$('#order'), $('#product')],
			'click', 'd-none'
		)
	</script>

</body>