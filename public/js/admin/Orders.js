function Orders(id) {
    this.id = id;
    this.orders = [];
    this.quantity = 0;
}

Orders.prototype.load = function () {
    $.ajax({
        type: 'POST',
        url: '/admin/getOrders',
        context: this,
        data: "orders: orders",

        success: function (data) {
            this.quantity = data.orders_quantity;
            this.orders = [];
            for (var i = 0; i < data.orders_quantity; i++) {
                this.orders.push(data.orders[i]);
            }
            this.render();

        },
        dataType: 'JSON'
    });
};

Orders.prototype.render = function () {
    var $container = $('#' + this.id);
    $container.empty();
    for (var i = 0; i < this.quantity; i++){
        var $order = $('    <article class="tile notification order">' +
            '        <p class="order__title">Заказ '+ this.orders[i].id_order +'</p>' +
            '        <p class="order__user">Ид пользователя '+ this.orders[i].id_user +'</p>' +
            '        <p class="order__time">' + this.orders[i].datetime_create + '</p>' +
            '        <p class="order__amount">$' + (this.orders[i].amount / 100).toFixed(2) + '</p>' +
            '    </article>');

        var $content = $('<div class="content" data-id-order="' + this.orders[i].id_order + '">');

        if(this.orders[i].id_order_status == 2){
            $content.append('<a class="button is-warning order__disApprove">Снять одобрение</a>');
            $order.addClass('is-success');
        }
        else if(this.orders[i].id_order_status == 1){
            $content.append('<a class="button is-primary order__approve">Одобрить</a>');
        }
        $content.append('<a class="button is-link order__show">Посмотреть детали</a>', '<a class="button is-link order__hide">Скрыть детали</a>' , '<a class="button is-danger order_del">Удалить</a>');
        $order.append($content);
        $order.append('<div id="order_' + this.orders[i].id_order + '" class="show_detail" style="display: none"></div>');
        $container.append($order);

    }
};

Orders.prototype.deleteOrder = function (idOrder) {
    $.ajax({
        type: 'POST',
        url: '/admin/deleteOrder',
        context: this,
        data: "idOrder=" + idOrder,

        success: function (data) {
            console.log(data);
            if(data.result == 1){
                this.load();
            }
        },
        dataType: 'JSON'
    });
};

Orders.prototype.approveOrder = function (idOrder) {
    $.ajax({
        type: 'POST',
        url: '/admin/approveOrder',
        context: this,
        data: "idOrder=" + idOrder,

        success: function (data) {
            console.log(data);
            if(data.result == 1){
                this.load();
            }
        },
        dataType: 'JSON'
    });
};

Orders.prototype.disApproveOrder = function (idOrder) {
    $.ajax({
        type: 'POST',
        url: '/admin/cancelApproveOrder',
        context: this,
        data: "idOrder=" + idOrder,
        success: function (data) {
            console.log(data);
            if(data.result == 1){
                this.load();
            }
        },
        dataType: 'JSON'
    });
};


