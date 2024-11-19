
<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/server/functions.php';
?>

<!-- Header -->
<nav class="navbar navbar-expand-lg sticky-top bg-body-tertiary">
    <div class="container justify-content-between">
        <a class="navbar-brand mt-3 mb-3" href="/static/?view=landing">
            <img src="/assets/ico/logo_white.svg" alt="FecalisInc" width="70" height="80" fill="#ffffff">
        </a>

        <div class="container">
            <div class="row align-content-center">
                <div class="col">
                    <ul class="navbar-nav  justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" href="/static/?view=landing">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/app/catalogue/">Каталог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/static?view=about">О компании</a>
                        </li>
                    </ul>
                </div>


                <!-- Cookie  setted -->
                <?php if(check_auth()): ?>
                <div class="col-md-auto align-content-center" id="account_link_header">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false" id="fs_header">
                            <?php echo $_COOKIE['firstname'] . ' ' . $_COOKIE['secondname'] ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/app/account/?mode=user_data">Личный кабинет</a></li>
                            <li><a class="dropdown-item" href="/app/account/?mode=order">Управление заказами</a></li>
                            <? if ($_COOKIE['role'] == '1'): ?>
                            <li><a class="dropdown-item" href="/app/admin">Админ панель</a></li>
                            <? endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="/app/account/delete.php" >Удалить аккаунт</a></li>
                            <li><a class="dropdown-item bg-danger" href="/app/account/exit.php">Выйти из аккаунта</a></li>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Cookie not setted -->
                <?php if(!check_auth()): ?>
                <div class="navbar-nav col-md-auto align-content-center" id="login_link_header">
                    <li class="nav-item">
                        <a class="nav-link" href="/app/auth?mode=login">Войти в аккаунт</a>
                    </li>
                </div>
                <?php endif; ?>


            </div>
        </div>
    </div>
</nav>

