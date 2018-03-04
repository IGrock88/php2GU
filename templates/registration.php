<main class="container">
    <h1>Регистрация</h1>
    <form class="flex-container registrationForm" action="" method="post">
        <label>Введите Login<input type="text" name="regLogin" required></label>
        <label>Введите имя<input type="text" name="regName" required></label>
        <label>Введите пароль<input type="text" name="regPass" required></label>
        <input type="submit" name="regNewUser" value="Зарегистрироваться">
        <?php
        if($content['regStatus'] == 1){
            echo "Регистрация успешна";
        }
        elseif ($content['regStatus'] == 2){
            echo "Пользователь с таким логином уже существует";
        }
        ?>
    </form>

</main>