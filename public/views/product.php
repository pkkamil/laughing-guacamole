<?php
$title = $product->name;
$lazy = true;
?>

<article class="product">
    <section class="product__content">
        <img src="<?php echo $product->image; ?>" alt="">
        <section class="product__content__informations">
            <h3><?php echo $product->name; ?></h3>
            <span class="price"><?php echo $product->price; ?> <span class="grey">zł</span></span>
            <span class="small">Cena za 1 sztukę</span>

            <?php if ($product->availability == 0): ?>
                <form autocomplete="off">
                    <span>Ilość: 0</span>
                    <h4>Produkt niedostępny</h4>
                </form>
            <?php else: ?>
                <form autocomplete="off">
                    <span>Ilość:</span>
                    <label for="items" class="product__content__informations__items">
                        <i class="fas fa-minus" onclick="decrement()"></i>
                        <input type="number" name="items" id="items" value="1" min="1" oninput="handleInput()" onchange="handleChange()">
                        <i class="fas fa-plus" onclick="increment()"></i>
                    </label>
                    <button class="bright" type="submit">Dodaj do koszyka</button>
                    <span class="button dark buy_now">Kup teraz</span>
                </form>
            <?php endif; ?>

            <section class="product__content__informations__details">
                <?php foreach (explode(',', $product->description) as $i): ?>
                    <span><?php echo $i; ?></span>
                <?php endforeach; ?>
            </section>
        </section>

        <section class="widget widget-product">
            <div class="widget__upper c">
                <i class="fas fa-check icon"></i>
                <span class="status">Dodano produkt do koszyka</span>
            </div>
            <div class="widget__product">
                <img class="miniature" src="<?php echo $product->image; ?>" alt="">
                <span><?php echo $product->name; ?></span>
            </div>
            <a href="/cart" class="bright">Przejdź do koszyka</a>
            <a href="/order" class="button dark">Zamówienie</a>
            <span class="close">Kontynuuj zakupy</span>
        </section>

        <section class="dimmer-widget"></section>
    </section>
</article>

<script>
    let items = 1;
    let quantity = 12;

    function increment() {
        if (items < quantity) {
            items++;
            updateInput();
        }
    }

    function decrement() {
        if (items > 1) {
            items--;
            updateInput();
        }
    }

    function handleInput() {
        const input = document.getElementById('items');
        items = parseInt(input.value) || 1;
        if (items > quantity) {
            items = quantity;
            updateInput();
        }
    }

    function handleChange() {
        if (items < 1) {
            items = 1;
            updateInput();
        }
    }

    function updateInput() {
        document.getElementById('items').value = items;
    }
</script>

<script>
    document.querySelector('.widget span.close').addEventListener('click', () => {
        document.querySelector('.widget-product').style.display = 'none'
        if (window.screen.width <= 768)
            document.querySelector('.dimmer-widget').style.display = 'none'
        document.querySelector('.product__content__informations form button').disabled = false
    })

    if (window.screen.width <= 768) {
        document.addEventListener('mouseup', (e) => {
            if (!document.querySelector('.widget-product').contains(e.target)) {
                document.querySelector('.widget-product').style.display = 'none'
                document.querySelector('.dimmer-widget').style.display = 'none'
                document.querySelector('.product__content__informations form button').disabled = false
            }
        })
    }
</script>