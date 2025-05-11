<?php
// Przykładowe dane koszyka (możesz je pobrać z bazy lub sesji)
$cartItems = [
    (object)[
        'id' => 1,
        'name' => 'Opony BRIDGESTONE Blizzak 205/55R16',
        'image' => '/public/img/products/product2.jpg',
        'link' => '/produkt/1',
        'price' => 360.00,
        'quantity' => 4,
        'max' => 10,
    ],
    (object)[
        'id' => 2,
        'name' => 'Kierownica samochodowa',
        'image' => '/public/img/products/product1.jpg',
        'link' => '/produkt/2',
        'price' => 324.00,
        'quantity' => 1,
        'max' => 5,
    ]
];

$total = 0;
foreach ($cartItems as $item) {
    $total += $item->price * $item->quantity;
}
?>

<article class="cart">
    <?php if (empty($cartItems)): ?>
        <section class="cart__content">
            <h4 class="cart__content__information">Twój koszyk jest pusty</h4>
            <a href="/katalog" class="button dark">Kontynuuj zakupy</a>
            <?php include_once __DIR__ . '/products.php'; ?>
        </section>
    <?php else: ?>
        <section class="cart__content not-empty">
            <h2>Twój koszyk</h2>
            <section class="table">
                <div class="th">Produkt</div>
                <div class="th">Ilość</div>
                <div class="th price">Wartość</div>

                <?php foreach ($cartItems as $item): ?>
                    <div class="td imgname">
                        <a href="<?= htmlspecialchars($item->link) ?>">
                            <img src="<?= htmlspecialchars($item->image) ?>" alt="">
                        </a>
                        <span>
                            <a href="<?= htmlspecialchars($item->link) ?>"><?= htmlspecialchars($item->name) ?></a>
                        </span>
                    </div>
                    <div class="td quantity">
                        <label for="items" class="product__content__informations__items">
                            <i class="fas fa-minus" onclick="decrement(<?php echo $item->id ?>)"></i>
                            <input type="number" name="items" id="items-<?php echo $item->id ?>" value="1" min="1" oninput="handleInput(<?php echo $item->id ?>)" onchange="handleChange(<?php echo $item->id ?>)">
                            <i class="fas fa-plus" onclick="increment(<?php echo $item->id ?>)"></i>
                        </label>
                        <i class="far fa-trash-alt trash" onclick="remove(<?php echo $item->id ?>)"></i>
                    </div>
                    <div class="td price"><?= number_format($item->price * $item->quantity, 2) ?> <span class="grey">zł</span></div>
                <?php endforeach; ?>
            </section>

            <section class="cart__content__summary">
                <span class="grey">Łącznie</span>
                <span class="price"><?= number_format($total, 2) ?> <p class="grey">zł</p></span>
                <span class="small">W cenie zawarto podatek VAT</span>
                <!-- <a href="/order" class="button dark">Przejdź do zamówienia</a> TODO: Develop in future -->
            </section>
        </section>
    <?php endif; ?>
</article>

<script>
    let items = 1; // Example initial quantity, replace with actual value from the server
    let quantity = 12; // Example maximum quantity, replace with actual value from the server

    function increment(id) {
        if (items < quantity) {
            items++;
            updateInput(id);
        }
    }

    function decrement(id) {
        if (items > 1) {
            items--;
            updateInput(id);
        }
    }

    function handleInput(id) {
        const input = document.getElementById('items');
        items = parseInt(input.value) || 1;
        if (items > quantity) {
            items = quantity;
            updateInput(id);
        }
    }

    function handleChange(id) {
        if (items < 1) {
            items = 1;
            updateInput(id);
        }
    }

    function updateInput(id) {
        document.getElementById('items-' + id).value = items;
    }

    function remove(id) {
        // Implement the logic to remove the item from the cart
        console.log('Remove item with ID:', id);
    }
</script>