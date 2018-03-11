$(document).ready(function () {
    var basket = new Basket('live-card');
    basket.renderBasketMenu();

    $('#show_more').on('click', function () {
        goods1.showMore();
    });

    // слушатели для кнопок добавления в корзину
    $('.goods').on('click', '.buy_button', function () {
        basket.addItem($(this).parent().attr('data-id-product'));
    });

    //слушатель для кнопок удаления из корзины
    $('.basket_items').on('click', '.delete__button', function () {
        basket.deleteItem($(this).attr('data-id-product'));
    });


    $('#show-quantity-goods').change(function(){
        $('#goods2').empty();
        goods2.loadGoods(0, $(this).val());
    });
});