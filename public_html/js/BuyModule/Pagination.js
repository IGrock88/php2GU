function Pagination(id, idCategory) {
    this.id = id;
    this.quantityGoods = 0;
    this.quantityOnPage = 0;
    this.idCategory = idCategory;
    this.totalQuantity;
    this.goods = [];
    this.isSuccessAjax = false;
}

Pagination.prototype.setQuantityOnPage = function (quantityOnPage) {
    this.quantityOnPage = quantityOnPage;
}

Pagination.prototype.loadGoodsByCategory = function (startIndex) {

    $.ajax({
        type: 'POST',
        url: '/category/ajaxLoadGoodsByCategory',
        data: 'quantityGoods='+ this.quantityOnPage + '&startIndex=' + (startIndex * this.quantityOnPage) + '&idCategory=' + this.idCategory,
        context: this,
        async: false,
        success: function (data) {
            this.goods = [];

            this.quantityGoods = data.quantity;
            this.totalQuantity = data.totalQuantity;

            if(data.result == 1){
                this.isSuccessAjax = true;
                for(var i = 0; i < data.quantity; i++){
                    this.goods.push(data.goods[i]);
                }
                this.render();
            }
            else{

            }
        },
        dataType: 'JSON',
    });
    return this.isSuccessAjax;
};

Pagination.prototype.loadGoodsAll = function () {
    this.quantityOnPage = this.totalQuantity;
    this.loadGoodsByCategory(0);
    $("#light-pagination").hide();

};

Pagination.prototype.render = function () {

    var $container = $('#' + this.id);
    $container.empty();
    for(var i = 0; i < this.quantityGoods; i++){
        if(this.goods[i] === undefined) break;
        var $item = $('<figure />', {
            class: 'goods__item',
            'data-id-product': this.goods[i].id_product,
            'data-index': i
        });

        var $buyButton = $('<button class="goods__button buy_button" type="button">Add To Cart</button>');
        var $compareButton = $('<button class="goods__button compare-button" type="button"></button>');
        var $addWishButton = $('<button class="goods__button add-to-wish-button" type="button"></button>');
        var $addImg = $('<a href="/goods/'+ this.goods[i].id_product +'"><img src="../../' + this.goods[i].img
            + '" alt="goods photo"></a>');
        var $goodsCaption = $('<figcaption class="goods__caption"><a href="/goods/view/'+ this.goods[i].id_product +'">' + this.goods[i].title +
            '</a><div class="goods__price">$' + (this.goods[i].price / 100).toFixed(2) + '</div></figcaption>');

        $item.append($buyButton, $compareButton, $addWishButton, $addImg, $goodsCaption);
        $container.append($item);
    }
};

Pagination.prototype.initPaginator = function initPaginator() {
    $("#light-pagination").pagination({
        items: this.totalQuantity,
        itemsOnPage: this.quantityOnPage,
        cssStyle: 'light-theme'
    });
};