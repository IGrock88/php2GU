<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hello Bulma!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>

<div class="navbar-menu">
    <div class="navbar-start">
        <div class="tabs">
            <ul>
                <li><a href="/admin">Домой</a></li>
                <li><a href="/admin/orders">Заказы</a></li>
                <li><a href="/admin/goods">Товары</a></li>
                <li><a href="/admin/users">Пользователи</a></li>
            </ul>
        </div>
    </div>

    <div class="navbar-end">
        <div class="dropdown account">
            <div class="dropdown-trigger">
                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                    <span><?php echo $_SESSION['login'] = "admin"?></span>
                    <span class="icon is-small">
                        <i class="fas fa-angle-down" aria-hidden="true"></i>
                    </span>
                </button>
            </div>
            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                <div class="dropdown-content">
                    <a href="#" class="dropdown-item">
                        Dropdown item
                    </a>
                    <a class="dropdown-item">
                        Other dropdown item
                    </a>
                    <a href="#" class="dropdown-item is-active">
                        Active dropdown item
                    </a>
                    <a href="#" class="dropdown-item">
                        Other dropdown item
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item">
                        With a divider
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
<section class="section">
    <div class="container">

    </div>
</section>
<script>
    document.querySelector('.account').addEventListener('click', function () {
        this.classList.toggle('is-active');
    });
</script>
</body>
</html>