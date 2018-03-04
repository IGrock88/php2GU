<?php
    $item = $content['selected-goods'];
?>


<article id=slider class="product">
    <input type=radio name=slider id=slide1>
    <input checked type=radio name=slider id=slide2>
    <input type=radio name=slider id=slide3>
    <div id=slides>
        <div id=overflow>
            <div class=inner>
                <figure>
                    <img src="../../<?php echo $item['img'] ?>" alt="">
                </figure>
                <figure>
                    <img src="../../<?php echo $item['img'] ?>" alt="">
                </figure>
                <figure>
                    <img src="../../<?php echo $item['img'] ?>" alt="">
                </figure>
            </div>
        </div>
    </div>
    <div id=controls>
        <label for=slide1></label>
        <label for=slide2></label>
        <label for=slide3></label>
    </div>
    <div class="container goods-info flex-container">
        <h5>WOMEN COLLECTION</h5>
        <div id=active>
            <label for=slide1></label>
            <label for=slide2></label>
            <label for=slide3></label>
            <div id="caret"></div>
        </div>
        <h4><?php echo $item['title'] ?></h4>
        <p><?php echo $item['description'] ?>
        </p>
        <div class="goods-chars flex-container">
            <div>MATERIAL: <span><?php echo $item['material_name'] ?></span></div>
            <div>DESIGNER: <span><?php echo $item['designer_name'] ?></span></div>
        </div>
        <output id="goods-price">$<?php echo $item['price']/100 ?></output>
        <form action="#" id="add-to-cart" class="flex-container">
            <div class="choose-color">
                <h5>CHOOSE COLOR</h5>
                <button id="show-color-menu" type="button" class="red-color add-to-cart_options dropable"><i
                        class="fa fa-angle-down" aria-hidden="true"></i></button>
                <div class="color-menu">
                    <button type="button" class="button-menu" id="red-color">Red</button>
                    <button type="button" class="button-menu" id="black-color">Black</button>
                    <button type="button" class="button-menu" id="white-color">White</button>
                </div>
            </div>
            <div class="choose-size">
                <h5>CHOOSE SIZE</h5>
                <button id="show-size-menu" type="button" class="add-to-cart_options dropable">XS</button>
                <div class="size-menu">
                    <button type="button" class="button-menu size-menu-button" id="xxl-size">XXL</button>
                    <button type="button" class="button-menu size-menu-button" id="xs-size">XS</button>
                    <button type="button" class="button-menu size-menu-button" id="xl-size">XL</button>
                    <button type="button" class="button-menu size-menu-button" id="s-size">S</button>
                </div>
            </div>
            <div>
                <h5>QUANTITY</h5>
                <input id="quantity" type="number" class="add-to-cart_options" value="1" min="1">
            </div>
            <button id="buy_button" type="submit" style="width: 100%">Add to Cart</button>
        </form>
    </div>
</article>