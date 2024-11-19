<?php
    $root = $_SERVER['DOCUMENT_ROOT'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FecalisInc - О компании</title>
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

    <script src="/js/toggle_view_by_radio.js"></script>
</head>

<body data-bs-theme="dark">
    <?php
        require_once $root . '/blocks/header.php';
    ?>

    <div class="container min-vh-100">
        <div class="row mt-5 h-75">
            <!-- Image section -->
            <div class="col text-center">
                <img src="/assets/img/about_01.jpg" height="500" width="600" class="rounded shadow-lg object-fit-cover" width="400" alt="">
            </div>

            <!-- Article section -->
            <div class="col">
                <h2>Наша миссия</h2>
                <p class="lh-lg">
                    <strong>Fecalis Inc.</strong>
                    – компания, которая стремится обеспечить фермеров и садоводов высококачественными удобрениями, способствующими росту здоровых растений и повышению урожайности. Мы верим, что каждый садовод и аграрий заслуживает лучшие продукты для своих культур, поэтому наша цель – предложить широкий ассортимент минеральных и органических удобрений, соответствующих высоким стандартам качества и экологичности.</p>
            </div>
        </div>

        <h2 class="mb-5 mt-5 text-center">Наши преимущества</h2>

        <div class="row mt-5">
            <!-- Article section -->
            <div class="col text-end">
                <div class="mb-3">
                    <strong> Широкий ассортимент </strong>
                    <p class="lh-lg">
                        В нашем каталоге представлены все виды удобрений – от традиционных минеральных до современных органических решений. Вы можете выбрать продукт, который идеально подойдет для ваших нужд, будь то подкормка овощных культур, декоративных растений или газонов.
                    </p>
                </div>
            </div>
            <!-- Image section -->
            <div class="col text-center">
                <img src="/assets/img/about_02.jpg" class="rounded shadow-lg object-fit-cover" height="500" width="600" alt="">
            </div>
        </div>
        <div class="row mt-5">
            <!-- Image section -->
            <div class="col text-center">
                <img src="/assets/img/about_03.jpg" class="rounded shadow-lg object-fit-cover" height="500" width="600" alt="">
            </div>

            <!-- Article section -->
            <div class="col">
                <div class="mb-3">
                    <strong> Качество продукции </strong>
                    <p class="lh-lg">
                        Все наши удобрения проходят строгий контроль качества на каждом этапе производства. Мы гарантируем эффективность наших продуктов и их безопасность для окружающей среды.
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Article section -->
            <div class="col text-end">
                <div class="mb-3">
                    <strong> Удобство покупки </strong>
                    <p class="lh-lg">
                        Наш интернет-магазин предлагает простой и удобный процесс заказа. Вы сможете быстро найти нужный товар, оформить покупку и получить его в кратчайшие сроки.
                    </p>
                </div>
            </div>
            <!-- Image section -->
            <div class="col text-center">
                <img src="/assets/img/about_04.jpg" class="rounded shadow-lg object-fit-cover" height="500" width="600" alt="">
            </div>
        </div>
    </div>

    <?php
        require_once $root . '/blocks/footer.html';
    ?>

</body>

</html>