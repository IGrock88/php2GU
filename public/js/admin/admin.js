$(document).ready(function () {

    document.querySelector('#account').addEventListener('click', function () {
        this.classList.toggle('is-active');
    });

    $('#uploadImage').click(function () {
        var file_data = $('#titleImage').prop('files')[0];
        var form_data = new FormData();
        var idProduct = $(this).attr('data-id-product');
        form_data.append('titleImage', file_data);
        form_data.append('idProduct', idProduct);
        uploadFile(form_data, idProduct);
    });

    $('#newProduct').click(function () {


        var $forms = $('.checkEmpty');
        console.log(isEmpty($forms));



        if(!isEmpty($forms)){
            var title = $forms.filter('#title').val();
            var price = parseFloat($forms.filter('#price').val());
            var shortDesc = $forms.filter('#shortDesc').val();
            var fullDesc = $forms.filter('#fullDesc').val();


            var designerId = parseInt($('#selectDesigner').val());
            var categoryId = parseInt($('#selectCategory').val());
            var materialId = parseInt($('#selectMaterial').val());

            var newProductData = {
                title: title,
                price: (price.toFixed(2)) * 100,
                designerId: designerId,
                categoryId: categoryId,
                materialId: materialId,
                shortDesc: shortDesc,
                fullDesc: fullDesc
            };


            var addGoods = new GoodsAdmin();
            addGoods.addNewProduct(newProductData);
        }
        else {
            var $message = $('#emptyForms');
            $message.slideDown();
            setTimeout(function () {
                $message.slideUp();
            }, 1000);
        }

    });
    function isEmpty (inputs){
        var result = false;
        for(var i = 0; i < inputs.length; i++){
            inputs.eq(i).removeClass('is-danger')
            if(inputs.eq(i).val() == "")  {
                inputs.eq(i).addClass('is-danger');
                result = true;
            }
        }
        if(isNaN(parseInt(inputs.filter('#price').val()))) {
            inputs.filter('#price').addClass('is-danger');
            result = true;
        }

        return result;
    }
    
    function uploadFile(fileData) {
        $.ajax({
            url: '/admin/addTitleImage',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: fileData,
            type: 'post',
            success: function(data){
                console.log(data);
            }
        });
    }

});