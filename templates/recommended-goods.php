<div class="container flex-container">
    <section class="also-like">
        <h2>you may like also</h2>
        <div class="flex-container goods" id="goods3">

            <? foreach ($content['recommended-products'] as $item): ?>
                <figure class="goods__item" data-id-product="<?=$item['id_product']?>">
                    <button class="goods__button buy_button" type="button">Add To Cart</button>
                    <button class="goods__button compare-button" type="button"></button>
                    <button class="goods__button add-to-wish-button" type="button"></button>
                    <a href="../goods/<?=$item['id_product']?>"><img src="../../<?=$item['img']?>" alt="goods photo"></a>
                    <figcaption class="goods__caption"><a href="/goods/view/<?=$item['id_product']?>"><?=$item['title']?></a>
                        <div class="goods__price">$<?=$item['price']/100?></div>
                    </figcaption>
                </figure>
            <? endforeach; ?>

        </div>
    </section>
</div>