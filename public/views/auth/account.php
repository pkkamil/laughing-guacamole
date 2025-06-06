<?php
$title = "Konto";

$orders = $orders ?? [];
$addresses = $addresses ?? [];
?>

<article class="account">
    <section class="account__content">
        <div class="account__content__main">
            <h2>Twoje konto</h2>
            <a href="/logout" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                <i class="fas fa-user"></i> Wyloguj
            </a>
            <form id="frm-logout" action="/logout" method="POST" style="display: none;">
                <input type="hidden" name="_token" value="<?= htmlspecialchars($_SESSION['_token'] ?? '') ?>">
            </form>

            <?php if ($user['role'] === 'admin'): ?>
                <br>
                <a href="/admin" class="panel"><i class="fas fa-tools"></i> Panel zarządzania</a>
            <?php endif; ?>
        </div>

        <div class="account__content__bottom">
            <?php if (count($orders) > 0): ?>
                <!-- TODO: Add order history component -->
            <?php else: ?>
                <div class="account__content__bottom__orders">
                    <h4>Historia zamówień</h4>
                    <p class="nothing-ordered">Nie zamówiłeś jeszcze żadnego produktu.</p>
                    <a href="/catalog" class="button dark">Katalog</a>
                </div>
            <?php endif; ?>

            <div class="account__content__bottom__informations">
                <h4>Informacje o koncie</h4>

                <?php if (count($addresses) === 0): ?>
                    <a><i class="fas fa-home"></i> Twoje adresy (0)</a>
                <?php else: ?>
                    <?php $addr = $addresses[0]; ?>
                    <div class="account__content__bottom__informations__default">
                        <span><?= htmlspecialchars($addr->name . ' ' . $addr->surname) ?></span>
                        <span><?= htmlspecialchars($addr->street . ' ' . $addr->house_number) ?>
                            <?= $addr->apartment_number ? '/' . htmlspecialchars($addr->apartment_number) : '' ?>
                        </span>
                        <span><?= htmlspecialchars($addr->zip_code . ' ' . $addr->city) ?></span>
                    </div>
                    <a href="/adresy"><i class="fas fa-home"></i> Twoje adresy (<?= count($addresses) ?>)</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</article>