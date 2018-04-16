$(document).ready(function () {

    document.querySelector('#account').addEventListener('click', function () {
        this.classList.toggle('is-active');
    });

    $('#newProduct').click(function () {


        var $forms = $('.checkEmpty');
        console.log(isEmpty($forms));



        if(!isEmpty($forms)){
            var title = $forms.filter('#title').val();
            var price = parseInt($forms.filter('#price').val());
            var shortDesc = $forms.filter('#shortDesc').val();
            var fullDesc = $forms.filter('#fullDesc').val();


            var designerId = parseInt($('#selectDesigner').val());
            var categoryId = parseInt($('#selectCategory').val());
            var materialId = parseInt($('#selectMaterial').val());

            var newProductData = {
                title: title,
                price: price,
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
            alert('Есть пустые формы');
        }

    });
    function isEmpty (inputs){

        if(isNaN(parseInt(inputs.filter('#price').val()))) return true;

        for(var i = 0; i < inputs.length; i++){
            if(inputs.eq(i).val() == "")  return true;
        }
        return false;
    }

});