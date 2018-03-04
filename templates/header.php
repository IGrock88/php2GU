<!DOCTYPE html>
<html>

<?php include 'head.php' ?>
<body>
<div id="dialog" title="Сообщение">
    <p id="addProduct">Товар добавлен в корзину</p>
</div>
<header class="header">
    <div class="container flex-container">
        <a href="/" class="logo header__logo">
            <img src="../../img/logo.png" alt="b"><div>BRAN<span>D</span></div>
        </a>
        <form action="#" id="search">
            <button type="button" class="drop-down-button button-gray">Browse
            </button>
                <?php include 'brause-category.php'?>
            <input class="search__input_text" type="search" placeholder="Search for Item...">
            <input class="search__button" type="submit" value=" ">
        </form>
        <div id="live-card">
            <a href="#"><img class="cart__icon" src="../../img/card-icon.svg" alt="Cart"></a>

        </div>

        <?php include 'auth-menu.php' ?>
    </div>
    <div class="flex-container">
        <?php include 'main-menu.php' ?>
    </div>
</header>
