<?php
$title = "Panel zarządzania";

$orders = $orders ?? 0;
$products = $products ?? 0;

?>

<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Panel zarządzania</h2>
            <a href="/account" class="back">Powrót</a>
        </div>
        <div class="admin__content__start">
            <div class="admin__content__start__single">
                <h4>Dodaj nowy produkt</h4>
                <a href="/admin/products/new" class="button button-small dark">Nowy produkt</a>
            </div>

            <?php if ($products > 0): ?>
                <div class="admin__content__start__single">
                    <h4>Zarządzaj listą produktów</h4>
                    <a href="/admin/products" class="button button-small dark">Lista produktów</a>
                </div>
            <?php endif; ?>

            <?php if ($orders > 0): ?>
                <div class="admin__content__start__single">
                    <h4>Przejrzyj listę zamówień</h4>
                    <a href="/admin/orders" class="button button-small dark">Lista zamówień</a>
                </div>
            <?php endif; ?>

            <div class="admin__content__start__single">
                <h4>Zmień ustawienia strony</h4>
                <a href="/admin/settings" class="button button-small dark">Ustawienia strony</a>
            </div>
        </div>
    </section>
</article>