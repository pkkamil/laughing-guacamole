<article class="products">
    <?php if (isset($catalog)): ?>
        <h4>Katalog produktów</h4>
        <section class="products__list">
            <?php if (count($products) != 0): ?>
                <?php foreach ($products as $product): ?>
                    <a href="<?= htmlspecialchars($product['link']) ?>" class="products__list__single">
                        <div class="products__list__single__image">
                            <img src="<?= htmlspecialchars($product['imageUrl']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                <?php if ($product['availability'] == 0): ?> class="lack" <?php endif; ?> loading="lazy">
                        </div>
                        <span><?= htmlspecialchars($product['name']) ?></span>
                        <span><?= htmlspecialchars($product['price']) ?> <span class="grey">zł</span></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="empty">Obecnie żaden produkt nie znajduje się w sprzedaży!<br>Jak tylko zostaną dodane jakieś produkty, zobaczysz je tutaj!<br>Wróć później!</span>
            <?php endif; ?>
        </section>
    <?php else: ?>
        <h4>Najczęściej kupowane produkty</h4>
        <section class="products__list">
            <?php if (count($products) != 0): ?>
                <?php foreach ($products as $product): ?>
                    <a href="<?= htmlspecialchars($product['link']) ?>" class="products__list__single">
                        <div class="products__list__single__image">
                            <img src="<?= htmlspecialchars($product['imageUrl']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                        </div>
                        <span><?= htmlspecialchars($product['name']) ?></span>
                        <span><?= htmlspecialchars($product['price']) ?> <span class="grey">zł</span></span>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="empty">Obecnie żaden produkt nie znajduje się w sprzedaży!<br>Jak tylko zostaną dodane jakieś produkty, zobaczysz je tutaj!<br>Wróć później!</span>
            <?php endif; ?>
        </section>
    <?php endif; ?>
</article>