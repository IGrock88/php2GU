// Класс реализующий работу корзины,
//TODO: реализовать работу на стороне PHP

function Basket(id) {
    this.id = id;
    this.items = [];
    this.countGoods = 0;
    this.totalPrice = 0;
    this.render();
    this.setQuantity();
    this.loadBasketItems();
}

Basket.prototype.loadBasketItems = function () {
    $.ajax({
        type: 'POST',
        url: '../index.php',
        data: 'typeRequest=loadBasket',
        dataType: 'json',
        context: this,
        success: function (data) {
            this.items = [];
            console.log(data);
            for (var itemKey in data.basket){
                this.items.push(data.basket[itemKey]);
            }
            this.countGoods = data.total_quantity;
            this.refreshItemList();
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
        '                         <a href="checkout.html">Checkout</a>' +
        '                         <a href="shoppingcart.html">Go to cart</a>' +
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

        var $itemImg = $('<a href="../goods/' + this.items[itemKey].id_product + '"><img  class="cart-goods-img" src="../'+ this.items[itemKey].img +'" alt="Goods photo"></a>');

        var $itemCaption = $('<div class="live-card__item-caption">' +
            '                       <h6><a href="../goods/' + this.items[itemKey].id_product + '">' + this.items[itemKey].title + '</a></h6>' +
            '                       <div class="stars"><img src="../img/stars.png" alt="stars"></div>' +
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

Basket.prototype.addItem = function (idProduct) {
    $.ajax({
        type: 'POST',
        url: '../index.php',
        data: 'typeRequest=addProduct&id_product=' + idProduct,
        dataType: 'json',
        context: this,
        success: function (data) {
            if(data.result == 1){
                this.loadBasketItems();
                var $message = $('#addProduct');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 3000);
            }
            else{
                console.log("Товар не добавлен");
            }
        }
    });


};

Basket.prototype.deleteItem = function (idProduct) {
    $.ajax({
        type: 'POST',
        url: '../index.php',
        data: 'typeRequest=delProduct&id_product=' + idProduct,
        dataType: 'json',
        context: this,
        success: function (data) {
            if(data.result == 1){
                this.loadBasketItems();
            }
            else{
                console.log("Товар не удален");
            }
        }
    });
}