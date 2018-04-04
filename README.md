# php2GU
shop for education
Реализованный функционал.
1. Вывод товаров на главной, сортировка по популярности. По кнопке show more можно до гружать по 8 товаров.
2. Вывод товаров для двух категорий мужчины и женщины. Товары подгружаются по AJAX, можно выбрать количество товаров на странице,
работает пагинация, количество страниц расчитывается автоматически от общего количества товаров и количества товара на странице.
3. Вывод карточка товара
4. Добавление товара в корзину, по кнопкам в блоках товаров на страницах, каждое нажатие +1.
5. Добавление товара через карточку, можно ввести количество.
6. Корзина выводится в выпадающем меню, либо на странице cart, ссылка в выпадающем меню go to cart. Производится расчёт суммы(сумма в бд 
хранится в центах, расчёты все идут в центах и перед выводом для пользователя преобразуются в доллары) и количества.
7. В выпадающем меню корзины можно удалять товар.
8. На странице с корзиной(cart) можно редактировать количество, удалять товар либо введя 0, либо нажав на кнопку.
9. По кнопке proceed to checkout происходит оформление заказа.
10. В личном кабинете пользователя можно посмотреть свои заказы, детали по заказам, статус заказы (сделал два статуса, чтобы сильно не 
заморачиваться одобрен/не одобрен), удалить заказ(спорный момент, возможно нужно сделать доп статус, а удалять заказ всё таки должен админ).
11. Для всех действий по AJAX пользователем, выводятся сообщения, после того как сервер дал успешный запрос. Если пользователь пытается заказать отрицательное количество товара, выводится соотвествущее сообщение. Проверка в этом случае происходит и во фронтенде и в бэкенде.
12. Реализована авторизация пользователя и две роли админ и юзер.
13. Реализована часть функционала админа, просмотр заказов, удаление заказов, одобрение / не одобрение заказов, просмотр деталей по заказам
14. В админ панель можно войти по ссылке из выпадающего меню авторизации. Пользователь admin пароль root без пробелов.
15. Страница с ошибкой 404

Что ещё хотел бы сказать....
Реализовано:
1. Фреймворк написан используя парадигму MVC
2.Подключен шаблонизатор TWIG, шаблоны наследуются от базового шаблона, на страницах переназначаются блоки content и head. 
Для легкой замены шаблонизатора создан интерфейс IRender, контроллер в конструторе ожидает экземпляр IRender, тем самым в него можно подать любой объект реализующий интерфейс IRender.
3. Роутер, подгружаются классы по определенному правилу. Пример localhost/goods/viev будет подгружен контроллер GoodsController
метод view(). Для создания новых страниц сайт в роутере делать ничего не нужно, нужно лишь добавлять контроллеры и методы по опеределенным правилам. Правила прописаны в файле с классом Роутер.
4. Автолоадер работает от композера, смотрит в папку Engine, соблюдение namespace обязательно, подгружаются классы namespace которых начинается на engine.
5. Отдельный класс для обработки запросов от пользователь, пока три метода, один не используется)) По необходимости можно до писывать.
6. Класс для бд, учебный, создан абстрактный класс, модели ожидают экземпляр абстрактного класса, тем самым можно легко внедрить работу с бд с помощью PDO унаследовавшить от AbstractDb
