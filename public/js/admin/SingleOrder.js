function SingleOrder() {
    this.orderDetail = [];
    this.isShowDetail = false;
    this.quantity = 0;
}

SingleOrder.prototype.showDetail = function (idOrder) {
    this.getDetail(idOrder);
}

SingleOrder.prototype.hideDetail = function (idOrder) {
    var $detailContainer = $('#order_' + idOrder);
    $detailContainer.slideUp();
    setTimeout(function () {
        $detailContainer.empty();
    },500);
}


SingleOrder.prototype.getDetail = function (idOrder) {
    var $detailContainer = $('#order_' + idOrder);
        $.ajax({
            type: 'POST',
            url: '/admin/showOrderDetail',
            context: this,
            data: "idOrder=" + idOrder,
            success: function (data) {
                if(data.result === 1){
                    console.log(data);
                    this.orderDetail = [];
                    this.quantity = data.quantity;
                    for (var i = 0; i < this.quantity; i++) {
                        this.orderDetail.push(data.orderDetail[i]);
                    }

                    this.render(idOrder);
                    $detailContainer.slideDown();
                }
                else if(data.result === 0){
                    console.log("детали заказа не подгружены");
                }

            },
            dataType: 'JSON'
        });
};

SingleOrder.prototype.render = function (idOrder) {
    console.log(this.orderDetail);
    var $container = $('#order_' + idOrder);
    $container.empty();

    var $table = $('<table class="table order_table">' +
        '  <thead>' +
        '    <tr>' +
        '      <th>id товара</th>' +
        '      <th>Название товара</th>' +
        '      <th>Цена товара</th>' +
        '      <th>Количество товара</th>' +
        '      <th>Сумма</th>' +
        '      <th>Действие</th>' +
        '    </tr>' +
        '  </thead>' +
        '</table>');

    var $tbody = $('<tbody/>', {
        class: 'order_' + idOrder + '_goods'
    });

    for (var i = 0; i < this.quantity; i++) {

        $tbody.append('    <tr>' +
                       '      <th><a href="/goods/view/' + this.orderDetail[i].id_product + '">' + this.orderDetail[i].id_product + '</a></th>' +
                       '      <td><a href="/goods/view/' + this.orderDetail[i].id_product + '">' +this.orderDetail[i].title + '</a></td>' +
                       '      <td>' +(this.orderDetail[i].price / 100).toFixed(2) + '</td>' +
                       '      <td>' + this.orderDetail[i].quantity + '</td>' +
                       '      <td>' + (this.orderDetail[i].price * this.orderDetail[i].quantity / 100).toFixed(2) + '</td>' +
                       '      <td>Удалить</td>' +
                       '   </tr>');

    }
    $table.append($tbody);
    $container.append($table);
};