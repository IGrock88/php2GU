function GoodsAdmin() {
    
}

GoodsAdmin.prototype.addNewProduct = function (title, price, designerId, categoryId, materialId, shortDesc, fullDesc) {
    $.ajax({
        type: 'POST',
        url: '/admin/addNewProduct',
        data: ({title:title, price:price, designerId:designerId, categoryId:categoryId, materialId:materialId, shortDesc:shortDesc, fullDesc:fullDesc}),
        context: this,

        success: function (data) {
            console.log(data);
        },
        dataType: 'JSON',
    });
}