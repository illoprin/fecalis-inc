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
        <div class="row mt-5">
            <!-- Image section -->
            <div class="col text-center">
                <img src="/assets/img/about_01.jpg" class="rounded shadow-lg" width="400" alt="">
            </div>

            <!-- Article section -->
            <div class="col">
                <h2>Lorem, ipsum dolor.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex asperiores sed quidem hic! Deleniti, consectetur quia consequatur dolore qui quam laboriosam dolorem aut enim, esse, quibusdam ipsa. Non, delectus consequuntur.</p>
            </div>
        </div>

        <div class="row mt-5">
            <!-- Article section -->
            <div class="col">
                <h2>Lorem, ipsum dolor.</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex asperiores sed quidem hic! Deleniti, consectetur quia consequatur dolore qui quam laboriosam dolorem aut enim, esse, quibusdam ipsa. Non, delectus consequuntur.</p>
            </div>

            <!-- Image section -->
            <div class="col text-center">
                <img src="/assets/img/about_02.jpg" class="rounded shadow-lg" width="400" alt="">
            </div>
        </div>
    </div>

    <?php
        require_once $root . '/blocks/footer.html';
    ?>

</body>

</html>