function GoodsAdmin() {
    
}

GoodsAdmin.prototype.addNewProduct = function (newProductData) {
    $.ajax({
        type: 'POST',
        url: '/admin/addNewProduct',
        data: ({newProductData: newProductData}),
        context: this,

        success: function (data) {
            if(data.result = 1){
                var $message = $('#successNewProduct');
                $message.slideDown();
                setTimeout(function () {
                    $message.slideUp();
                }, 1000)

            }
        },
        dataType: 'JSON',
    });
}

GoodsAdmin.prototype.addImageFile = function (idProduct) {

    var file_data = $('#addNewImage').prop('files')[0];

    var form_data = new FormData();

    form_data.append('file', file_data);

    $.ajax({
        url: '/admin/addNewImage',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response);
        }
    });
}