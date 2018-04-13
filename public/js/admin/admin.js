$(document).ready(function () {

    document.querySelector('#account').addEventListener('click', function () {
        this.classList.toggle('is-active');
    });

    $('#newProduct').click(function () {

        var title = $('#title').val();
        var price = parseInt($('#price').val());
        var designerId = parseInt($('#selectDesigner').val());
        var categoryId = parseInt($('#selectCategory').val());
        var materialId = parseInt($('#selectMaterial').val());
        var shortDesc = $('#shortDesc').val();
        var fullDesc = $('#fullDesc').val();

        var addGoods = new GoodsAdmin();
        addGoods.addNewProduct(title, price, designerId, categoryId, materialId, shortDesc, fullDesc);
    });


});