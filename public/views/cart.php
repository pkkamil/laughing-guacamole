<?php
$cartItems = $cart['cartItems'] ?? [];

$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
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
                        <a href="<?= htmlspecialchars($item['link']) ?>">
                            <img src="<?= htmlspecialchars($item['image']) ?>" alt="">
                        </a>
                        <span>
                            <a href="<?= htmlspecialchars($item['link']) ?>"><?= htmlspecialchars($item['name']) ?></a>
                        </span>
                    </div>
                    <div class="td quantity">
                        <label for="items" class="product__content__informations__items">
                            <i class="fas fa-minus" onclick="decrement('<?php echo $item['id'] ?>')"></i>
                            <input
                                type="number"
                                name="items"
                                id="items-<?= $item['id'] ?>"
                                data-cart-item-id="<?= $item['id'] ?>"
                                value="<?= $item['quantity'] ?>"
                                min="1"
                                oninput="handleInput('<?= $item['id'] ?>')"
                                onchange="handleInput('<?= $item['id'] ?>')">
                            <i class="fas fa-plus" onclick="increment('<?= $item['id'] ?>')"></i>
                        </label>
                        <span class="trash-action"><i class="far fa-trash-alt trash" data-cart-item-id="<?= $item['id'] ?>"></i></span>
                    </div>
                    <div class="td price"><?= ($item['price'] * $item['quantity']) ?> <span class="grey">zł</span></div>
                <?php endforeach; ?>
            </section>

            <section class="cart__content__summary">
                <span class="grey">Łącznie</span>
                <span class="price"><?= $total ?> <p class="grey">zł</p></span>
                <span class="small">W cenie zawarto podatek VAT</span>
                <!-- <a href="/order" class="button dark">Przejdź do zamówienia</a> TODO: Develop in future -->
            </section>
        </section>
    <?php endif; ?>
</article>

<script src="/public/js/cart.js"></script>