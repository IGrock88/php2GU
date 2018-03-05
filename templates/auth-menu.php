
<?php if (!$content['isAuth']): ?>
    <button id="showAuthMenu" class="drop-down-button button-red">Sign in</button>
    <div id="auth">
    <form action="" method="post">
        <label for="login">Логин</label><input type="text" id="login" name="login"><br>
        <label for="pass">Пароль</label><input type="password" id="pass" name="pass"><br>
        <label for="rememberme">Запомнить: </label><input type="checkbox" name="rememberme" id="rememberme" />
        <input class="signAccount" type="submit" name="SubmitLogin" value="Войти" /> <a class="registration" href="/user/registration/">Зарегистрироваться</a>
    </form>
<?php endif; ?>


    <br>

<?php if ($content['isAuth']): ?>
        <button id="showAuthMenu" class="drop-down-button button-red"><?php echo $_SESSION['login'] ?></button>
        <div id="auth">
    <form action="/" method="post">
        <p>Вы авторизованы под логином</p>
        <strong class="userName"><?php echo $_SESSION['login'] ?></strong>
        <a class="account" href="/user/account/">Личный кабинет</a>
        <?php if ($content['userRole'] == 2): ?>
            <a class="account" href="/admin/">Админка</a>
        <?php endif; ?>
        <input class="exitAcount" type="submit" name="ExitLogin" value="log out" />
    </form>
<?php endif; ?>
</div>
