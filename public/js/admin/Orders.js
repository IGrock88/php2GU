function Orders(id) {
    this.id = id;
    this.orders = [];
    this.quantity = 0;
    this.load();
}

Orders.prototype.load = function () {
    $.ajax({
        type: 'POST',
        url: '/admin/getOrders',
        context: this,
        data: "orders: orders",

        success: function (data) {
            console.log(data);
            this.quantity = data.orders_quantity
            for (var i = 0; i < data.orders_quantity; i++) {
                this.orders.push(data.orders[i]);
            }
            this.render();

        },
        dataType: 'JSON',
    });
}

Orders.prototype.render = function () {
    var $container = $('#' + this.id);

    for (var i = 0; i < this.quantity; i++){
        var $order = $('    <article class="tile notification order">' +
            '        <p class="order__title">Заказ '+ this.orders[i].id_order +'</p>' +
            '        <p class="order__user">Ид пользователя '+ this.orders[i].id_user +'</p>' +
            '        <p class="order__time">' + this.orders[i].datetime_create + '</p>' +
            '        <p class="order__amount">$' + (this.orders[i].amount / 100).toFixed(2) + '</p>' +
            '        <div class="content">' +
            '            <a class="button is-primary button__approve">Одобрить</a>' +
            '            <a class="button is-link">Посмотреть заказ</a>' +
            '            <a class="button is-danger">Удалить</a>' +
            '        </div>' +
            '    </article>');
        if(this.orders[i].id_order_status == 2){
            $order.addClass('is-success');
        }

        $container.append($order);

    }
}
