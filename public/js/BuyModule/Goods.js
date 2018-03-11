function Goods(id) {
    this.id = id;
    this.startIndex = 0;
    this.quantityGoods = 0;
    this.goods = [];

}

Goods.prototype.loadGoods = function (startIndex, quantityGoods) {

    this.startIndex = startIndex;
    this.quantityGoods = quantityGoods;
    $.ajax({
        type: 'POST',
        url: '/goods/featureGoods',
        data: 'featureGoods='+ quantityGoods + '&startIndex=' + startIndex,
        context: this,

        success: function (data) {
            console.log(data);
            if(data.result == 2){
                var $showMore = $('#show_more');
                $showMore.text("Больше нечего показывать");
                setTimeout(function () {
                    $showMore.hide(500);
                }, 200)
            }
            else{
                this.startIndex += this.quantityGoods;
                for (var i = 0; i < data.quantity; i++){
                    this.goods.push(data.goods[i]);
                }
                this.render(startIndex);
            }
        },
        dataType: 'JSON',
    });
}

Goods.prototype.render = function (startIndex) {
    var $container = $('#' + this.id);

    var endIndex = startIndex + this.quantityGoods;

    for(var i = startIndex; i < endIndex; i++){
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
}

Goods.prototype.showMore = function () {
    this.loadGoods(this.startIndex, this.quantityGoods);
}






