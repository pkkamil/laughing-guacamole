<?php
$title = "Dodawanie nowego produktu";
?>

<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Dodawanie nowego produktu</h2>
            <a href="/admin" class="back">Powrót</a>
        </div>
        <form class="admin__content__new-product" id="product-form" autocomplete="off" method="POST" enctype="multipart/form-data" action="/admin/products">
            <div class="admin__content__new-product__single">
                <label for="image" class="admin__content__new-product__single__image">
                    <img id="preview" style="display:none;" />
                    <i class="fas fa-camera"></i>
                </label>
                <input accept="image/*" name="image" id="image" type="file">
                <?php if (!empty($errors['image'])): ?>
                    <div class="error"><?= htmlspecialchars($errors['image']) ?></div>
                <?php endif; ?>
            </div>

            <div class="admin__content__new-product__single">
                <label class="admin__content__new-product__single__input">
                    <input type="text" name="product_name" id="product_name" placeholder="Nazwa produktu" required>
                </label>
                <?php if (!empty($errors['product_name'])): ?>
                    <div class="error"><?= htmlspecialchars($errors['product_name']) ?></div>
                <?php endif; ?>
                <div class="admin__content__new-product__single__two">
                    <label class="admin__content__new-product__single__two__input-small">
                        <input type="number" name="stock" id="stock" placeholder="Ilość sztuk" required>
                    </label>
                    <label class="admin__content__new-product__single__two__input-small">
                        <input type="text" name="price" id="price" placeholder="Cena [zł]" required>
                    </label>
                </div>
            </div>

            <div class="admin__content__new-product__single">
                <label class="admin__content__new-product__single__textarea">
                    <textarea name="description" id="description" placeholder="Opis produktu" required></textarea>
                </label>
                <button type="submit" class="button-small dark">Dodaj produkt</button>
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

<script src="/public/js/product-form.js"></script>