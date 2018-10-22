$(document).ready(function () {
    var DEFAULT_QUANTITY_PRODUCT_ADD_TO_BASKET = 1;
    var basket = new Basket('live-card');
    basket.renderBasketMenu();

    $('#show_more').on('click', function () {
        goods1.showMore();
    });

    // слушатели для кнопок добавления в корзину в фигурах
    $('.goods').on('click', '.buy_button', function () {
        basket.addItem($(this).parent().attr('data-id-product'), DEFAULT_QUANTITY_PRODUCT_ADD_TO_BASKET, $(this));
    });

    $('#buy_button').on('click', function () {
        var quantity = $('#quantity').val();
        basket.addItem($(this).attr('data-id-product'), quantity);
    })
    //слушатель для кнопок удаления из корзины
    $('.basket_items').on('click', '.delete__button', function () {
        basket.deleteItem($(this).attr('data-id-product'));
    });

    $('#final-checkout').on('click', function () {
        basket.checkout();
    });

    $('#show-quantity-goods').change(function(){
        $('#goods2').empty();
        var quantity = parseInt($(this).val());

        pagination.setQuantityOnPage(quantity);
        pagination.loadGoodsByCategory(0);
        pagination.initPaginator();

    });

    $('.basket_items').on('change', '.item-quantity', function () {
        var quantity = parseInt($(this).val());
        if(quantity > 0){

            basket.changeQuantity($(this).attr('data-id-product'), quantity);
        }
        else if(quantity === 0){
            basket.deleteItem($(this).attr('data-id-product'));
        }
        else {
            var $message = $('#negativeQuantity');
            $message.slideDown();
            setTimeout(function () {
                $message.slideUp();
            }, 500);
            basket.loadBasketItems();
        }
    });

    $('#showAll').on('click', function () {
       pagination.loadGoodsAll();
        $(this).hide();
        $('#quantitySort').hide();

    });

});