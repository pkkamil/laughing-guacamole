<?php
$title = "Lista produktów";
?>

<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Zarządzanie listą produktów</h2>
            <a href="/admin" class="back">Powrót</a>
        </div>

        <div class="admin__content__products">
            <section class="table">
                <div class="th id">#</div>
                <div class="th name">Nazwa produktu</div>
                <div class="th quantity">Ilość</div>
                <div class="th price">Cena</div>
                <div class="th date">Data dodania</div>
                <div class="th right">Operacje</div>

                <?php foreach ($products as $index => $product): ?>
                    <div class="td id"><?= $index + 1 ?></div>
                    <div class="td name"><?= htmlspecialchars($product['name']) ?></div>
                    <div class="td quantity"><?= htmlspecialchars($product['stock']) ?></div>
                    <div class="td price"><?= htmlspecialchars($product['price']) ?> <span class="grey">zł</span></div>
                    <div class="td date"><?= htmlspecialchars($product['createdAt']) ?></div>
                    <div class="td right">
                        <span class="delete"><i class="far fa-trash-alt delete" data-product-id="<?= $product['id'] ?>"></i></span>
                        <a href="/admin/products/edit/<?= $product['id'] ?>"><i class="far fa-eye"></i></a>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>

        <section class="confirmation" style="display:none;">
            <section class="confirmation__box">
                <h4>Czy na pewno chcesz usunąć ten produkt?</h4>
                <form id="product-delete" action="/admin/products/delete" method="POST">
                    <button type="submit" class="button-small dark danger">Tak</button>
                    <span class="button button-small dark cancel">Nie</span>
                </form>
            </section>
        </section>
    </section>
</article>

<script>
    document.querySelectorAll('.td.right .delete').forEach(el => {
        el.addEventListener('click', () => {
            console.log(el);
            document.getElementById('product-delete').setAttribute('action', '/admin/products/' + el.querySelector('.delete').getAttribute('data-product-id') +
                '/delete');
            document.querySelector('.confirmation').style.display = 'flex';
        });
    });

    document.querySelector('.cancel').addEventListener('click', () => {
        document.querySelector('.confirmation').style.display = 'none';
    });
</script>