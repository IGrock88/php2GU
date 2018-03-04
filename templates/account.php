<?php if ($content['isAuth']): ?>
<main class="container account-info">
    <h1 style="text-align: center">Личный кабинет</h1>
    <p class="welcome">Здравствуйте <strong class="userLogin"><?php echo $_SESSION['name'] ?></strong></p>
    <p class="userName">Ваш логин: <?php echo $_SESSION['login'] ?></p>
</main>
<?php endif; ?>
<?php if (!$content['isAuth']): ?>
<main class="container account-info account-info__not_reg">
    <h1 style="text-align: center">Личный кабинет</h1>
    <p class="welcome">Здравствуйте вы не авторизованы, пройдите авторизацию</p>
    <form action="" method="post">
        <label for="login">Логин</label><input type="text" id="login" name="login"><br>
        <label for="pass">Пароль</label><input type="password" id="pass" name="pass"><br>
        <label for="rememberme">Запомнить: </label><input type="checkbox" name="rememberme" id="rememberme" />
        <input class="signAccount" type="submit" name="SubmitLogin" value="Войти" /> <a class="registration" href="/user/register/">Зарегистрироваться</a>
    </form>
</main>
<?php endif; ?>