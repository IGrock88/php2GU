$(document).ready(function () {
    var basket = new Basket('live-card');


    $('#show_more').on('click', function () {
        goods1.showMore();
    });

    // слушатели для кнопок добавления в корзину
    $('.goods').on('click', '.buy_button', function () {
        basket.addItem($(this).parent().attr('data-id-product'));
    });

    //слушатель для кнопок удаления из корзины
    $('#live-card').on('click', '.delete__button', function () {
        basket.deleteItem($(this).attr('data-id-product'));
    });

    // TODO: доработать под движок PHP
    $('#show-quantity-goods').change(function(){ // select для выбора количества отображаемых товаров на product.html
        // goods2.render($(this).val());
    });
});