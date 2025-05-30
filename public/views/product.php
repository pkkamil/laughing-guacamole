<?php
$title = $product['name'];
$lazy = true;
?>

<article class="product">
    <section class="product__content">
        <img src="<?php echo $product['imageUrl']; ?>" alt="">
        <section class="product__content__informations">
            <h3><?php echo $product['name']; ?></h3>
            <span class="price"><?php echo $product['price']; ?> <span class="grey">zł</span></span>
            <span class="small">Cena za 1 sztukę</span>

            <?php if ($product['availability'] == 0): ?>
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
                <span><?php echo $product['description']; ?></span>
            </section>
        </section>

        <section class="widget widget-product">
            <div class="widget__upper c">
                <i class="fas fa-check icon"></i>
                <span class="status">Dodano produkt do koszyka</span>
            </div>
            <div class="widget__product">
                <img class="miniature" src="<?php echo $product['imageUrl']; ?>" alt="">
                <span><?php echo $product['name']; ?></span>
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
    let quantity = <?php echo $product['stock']; ?>;

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

    // POST
    document.querySelector('.product__content__informations form button').addEventListener('click', (e) => {
        e.preventDefault()
        $.ajax('/cart/addToCart', {
            type: 'POST',
            data: {
                "productId": "<?php echo $product['id']; ?>",
                quantity: parseInt(document.getElementById('items').value) || 1,
            },
            success: function(data, status, xhr) {
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget__upper .icon').classList.remove('fa-info-circle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-exclamation-triangle')
                if (data.status == 200) {
                    document.querySelector('.widget__upper .status').textContent = 'Dodano produkt do koszyka';
                    document.querySelector('.widget__upper .icon').classList.add('fa-check')
                } else if (data.status == 'error') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                } else if (data.status == 'warning') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-info-circle')
                } else if (data.status == 'tryAgain') {
                    document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                }
                document.querySelector('.widget-product').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
                document.querySelector('.widget-product').style.display = 'block'
                document.querySelector('.product__content__informations form button').disabled = true
            },
            error: function(data, error) {
                document.querySelector('.widget-product').style.right = (window.screen.width - document.querySelector('.navbar__content').offsetWidth + 100) / 2 + 'px'
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
                document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget-product').style.display = 'block'
                document.querySelector('.product__content__informations form button').disabled = true
            }
        });
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

    document.querySelector('.product__content__informations form .buy_now').addEventListener('click', (e) => {
        e.preventDefault()
        $.ajax('/cart/addToCart', {
            type: 'POST',
            data: {
                "productId": "<?php echo $product['id']; ?>",
                quantity: parseInt(document.getElementById('items').value) || 1,
            },
            success: function(data, status, xhr) {
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget__upper .icon').classList.remove('fa-info-circle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-exclamation-triangle')
                if (data.status == 200) {
                    window.location.href = '/zamowienie'
                } else if (data.status == 'error') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                    document.querySelector('.widget-product').style.display = 'block'
                    document.querySelector('.product__content__informations form button').disabled = true
                } else if (data.status == 'warning') {
                    document.querySelector('.widget__upper .status').textContent = data.message;
                    document.querySelector('.widget__upper .icon').classList.add('fa-info-circle')
                    document.querySelector('.widget-product').style.display = 'block'
                    document.querySelector('.product__content__informations form button').disabled = true
                } else if (data.status == 'tryAgain') {
                    document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                    document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                    document.querySelector('.widget-product').style.display = 'block'
                    document.querySelector('.product__content__informations form button').disabled = true
                }
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
            },
            error: function(data, error) {
                document.querySelector('.widget__upper .status').textContent = 'Wystąpił błąd! Spróbuj ponownie później!';
                document.querySelector('.widget__upper .icon').classList.add('fa-exclamation-triangle')
                document.querySelector('.widget__upper .icon').classList.remove('fa-check')
                document.querySelector('.widget-product').style.display = 'block'
                if (window.screen.width <= 768)
                    document.querySelector('.dimmer-widget').style.display = 'block'
                document.querySelector('.product__content__informations form button').disabled = true
            }
        });
    })
</script>