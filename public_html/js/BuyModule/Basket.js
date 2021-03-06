// Класс реализующий работу корзины,

function Basket(id) {
    this.id = id;
    this.items = [];
    this.countGoods = 0;
    this.totalPrice = 0;
}

Basket.prototype.renderBasketMenu = function () {
    this.render();
    this.setQuantity();
    this.loadBasketItems();
}

Basket.prototype.renderBasketPage = function () {
    var $container = $('#basketItems');
    $container.empty();
    for(var itemKey in this.items){
        var goodsPrice = (this.items[itemKey].price / 100).toFixed(2);
        $container.append('<tr>' +
            '                <td>' +
            '                    <figure class="item-characteristics flex-container">' +
            '                        <a href="/goods/view/' + this.items[itemKey].id_product + '"><img src="../../'+ this.items[itemKey].img +'" alt="photo"></a>' +
            '                        <figcaption>' +
            '                            <h6><a href="/goods/view/' + this.items[itemKey].id_product + '">' + this.items[itemKey].title + '</a></h6>' +
            '                        </figcaption>' +
            '                    </figure>' +
            '                </td>' +
            '                <td><div class="item-price">$' + (this.items[itemKey].price / 100).toFixed(2) + '</div></td>' +
            '                <td><input class="item-quantity" type="number" min="0" value="' + this.items[itemKey].quantity + '" data-id-product="'+ this.items[itemKey].id_product +'"></td>' +
            '                <td class="hide-515px">' +
            '                    <output class="ship">FREE</output>' +
            '                </td>' +
            '                <td><output class="subtotal-price">$ ' + (this.items[itemKey].price * this.items[itemKey].quantity / 100).toFixed(2) + '</output></td>' +
            '                <td><button class="delete__button" data-id-product='+ this.items[itemKey].id_product +'></button></td>' +
            '             </tr>');
    }
}

Basket.prototype.loadBasketItems = function () {
    $.ajax({
        type: 'POST',
        url: '/basket/loadBasket',
        data: 'basket:basket',
        dataType: 'json',
        context: this,
        success: function (data) {
            this.items = [];
            for (var itemKey in data.basket){
                this.items.push(data.basket[itemKey]);
            }
            this.countGoods = data.total_quantity;
            this.refreshItemList();
            this.renderBasketPage();
        }
    });
};

Basket.prototype.render = function () {
    var $container = $('#' + this.id);
    $container.append('<div class="cart-menu menu">' +
        '                         <ul id="goods-in-cart"></ul>' +
        '                         <div class="total">' +
        '                              <span>TOTAL</span>' +
        '                              <div id="total-price"></div>' +
        '                         </div>' +
        '                         <a href="/basket/checkout">Checkout</a>' +
        '                         <a href="/basket/cart">Go to cart</a>' +
        '                     </div>')
                    .append('<div id="' + this.id + '__quantity-items"></div>');

};

Basket.prototype.renderClearBacket = function () {
    $('#' + this.id).empty()
                    .append('<h6>Корзина пуста</h6>')
};

Basket.prototype.refreshItemList = function () {
    var $container = $('#goods-in-cart');
    $container.empty();
    for (var itemKey in this.items){
        var $item = $('<li> /', {
            class: 'live-card__item'
        });

        var $itemImg = $('<a href="/goods/view/' + this.items[itemKey].id_product + '"><img  class="cart-goods-img" src="../../'+ this.items[itemKey].img +'" alt="Goods photo"></a>');

        var $itemCaption = $('<div class="live-card__item-caption">' +
            '                       <h6><a href="/goods/view/' + this.items[itemKey].id_product + '">' + this.items[itemKey].title + '</a></h6>' +
            '                       <div class="stars"></div>' +
            '                       <div class="goods-quantity">' + this.items[itemKey].quantity + '</div> X' +
            '                       <div class="goods-price">$' + (this.items[itemKey].price / 100).toFixed(2) + '</div>' +
            '                 </div>');
        var $delete = $('<div class="delete"><button type="button" class="delete__button" data-id-product="' + this.items[itemKey].id_product
            + '"></button></div>');

        $item.append($itemImg, $itemCaption, $delete);
        $container.append($item);
    }
    this.calculateTotalPriceAndQuantity();
};

Basket.prototype.calculateTotalPriceAndQuantity = function () {
    this.totalPrice = 0;

    for (var itemKey in this.items){
        this.totalPrice += this.items[itemKey].price * this.items[itemKey].quantity;
    }
    this.setTotalPrice();
    this.setQuantity();
};

Basket.prototype.setTotalPrice = function () {
    $('#total-price').text('$' + (this.totalPrice / 100).toFixed(2));
    $('#subtotalPrice').text('$' + (this.totalPrice / 100).toFixed(2));
    $('#totalPrice').text('$' + (this.totalPrice / 100).toFixed(2));
};

Basket.prototype.setQuantity = function () {

    var $quantity = $('#live-card__quantity-items');
    if(this.countGoods === 0){
        $quantity.hide();
    }else{
        $quantity.text(this.countGoods);
        $quantity.show();
    }
};

Basket.prototype.addItem = function (idProduct, productQuantity, button) {
    if(productQuantity > 0){


    $.ajax({
        type: 'POST',
        url: '/basket/addProduct',
        data: 'id_product=' + idProduct + '&productQuantity=' + productQuantity,
        dataType: 'json',
        context: this,
        beforeSend: function(){
            button.addClass('active');
            button.text('Подождите');
        },
        success: function (data) {
            console.log(data);
            button.text('Add to cart');
            button.removeClass('active');
            if(data.result == 1){
                this.loadBasketItems();
                var $message = $('#addProduct');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 1000);
            }
            else if(data.result == 2){
                var $message = $('#notAuth');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 1000);
            }
            else {
                console.log("товар не добавлен");
            }
        }
    });
    }
    else {
        var $message = $('#negativeQuantity');
        $message.slideDown();
        setTimeout(function () {
            $message.slideUp();
        }, 500);
    }


};

Basket.prototype.deleteItem = function (idProduct) {
    $.ajax({
        type: 'POST',
        url: '/basket/deleteProduct',
        data: 'id_product=' + idProduct,
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data);
            if(data.result == 1){
                this.loadBasketItems();
                var $message = $('#deleteProduct');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 1000);
            }
            else{
                console.log("Товар не удален");
            }
        }
    });
}

Basket.prototype.checkout = function () {
    $.ajax({
        type: 'POST',
        url: '/user/ajaxCheckout',
        data: 'basket: basket',
        dataType: 'json',
        context: this,
        beforeSend: function () {

        },
        success: function (data) {
            console.log(data);
            if(data.result == 1){
                this.loadBasketItems();
                var $message = $('#successCheckout');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 3000);
            }
            else{
                alert("Что то пошло не так заказ не оформлен повторите попозже");
            }
        }
    });
}

Basket.prototype.changeQuantity = function (idProduct, productQuantity) {
    console.log(idProduct, productQuantity);

    $.ajax({
        type: 'POST',
        url: '/basket/ajaxChangeQuantity',
        data: 'id_product=' + idProduct + '&productQuantity=' + productQuantity,
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data);
            if(data.result == 1){
                this.loadBasketItems();
                var $message = $('#changeQuantity');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 500);
            }
            else if(data.result == 2){
                var $message = $('#negativeQuantity');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 500);
            }
            else {
                console.log("Количество не изменено");
            }
        }
    });


};