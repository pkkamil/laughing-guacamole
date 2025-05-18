<?php
$title = "Edycja produktu o ID " . htmlspecialchars($product['id']);
?>

<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Zarządzanie produktem o&nbsp;ID&nbsp;<span class="grey"><?php echo $product['id'] ?></span></h2>
            <a href="/admin/products" class="back">Powrót</a>
        </div>
        <form class="admin__content__new-product" id="product-form" autocomplete="off" method="POST" enctype="multipart/form-data" action="/admin/products/<?php echo $product['id']; ?>">
            <div class="admin__content__new-product__single">
                <label for="image" class="admin__content__new-product__single__image">
                    <?php if (!empty($product['imageUrl'])): ?>
                        <img id="preview" src="<?php echo htmlspecialchars($product['imageUrl']); ?>" style="display:block;" />
                    <?php else: ?>
                        <img id="preview" style="display:none;" />
                    <?php endif; ?>
                    <i class="fas fa-camera"></i>
                </label>
                <input accept="image/*" name="image" id="image" type="file">
                <?php if (!empty($errors['image'])): ?>
                    <div class="error"><?= htmlspecialchars($errors['image']) ?></div>
                <?php endif; ?>
            </div>

            <div class="admin__content__new-product__single">
                <label class="admin__content__new-product__single__input">
                    <input type="text" name="name" id="name" placeholder="Nazwa produktu" required value="<?= htmlspecialchars($product['name'] ?? '') ?>">
                </label>
                <?php if (!empty($errors['product_name'])): ?>
                    <div class="error"><?= htmlspecialchars($errors['product_name']) ?></div>
                <?php endif; ?>
                <div class="admin__content__new-product__single__two">
                    <label class="admin__content__new-product__single__two__input-small">
                        <input type="number" name="stock" id="stock" placeholder="Ilość sztuk" required value="<?= htmlspecialchars($product['stock'] ?? '') ?>">
                    </label>
                    <label class="admin__content__new-product__single__two__input-small">
                        <input type="text" name="price" id="price" placeholder="Cena [zł]" required value="<?= htmlspecialchars($product['price'] ?? '') ?>">
                    </label>
                </div>
            </div>

            <div class="admin__content__new-product__single">
                <label class="admin__content__new-product__single__textarea">
                    <textarea name="description" id="description" placeholder="Opis produktu" required><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                </label>
                <button type="submit" class="button-small dark">Zapisz zmiany</button>
            </div>

            <section class="widget" id="widget" style="display:none;">
                <div class="widget__upper">
                    <i class="fas" id="icon"></i>
                    <span class="status" id="message"></span>
                    <i class="fas fa-times close" onclick="document.getElementById('widget').style.display='none';"></i>
                </div>
            </section>
        </form>
    </section>
</article>

<script>
    const preview = document.getElementById('preview');
    const imageInput = document.getElementById('image');

    imageInput.addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>