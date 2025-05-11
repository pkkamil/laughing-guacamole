<nav class="navbar">
    <div class="navbar__content">
        <i class="fas fa-bars navbar__content__menu navbar__content__menu__open"></i>
        <i class="fas fa-times navbar__content__menu navbar__content__menu__close"></i>
        <div class="navbar__content__title">
            <a href="/">Emptum</a>
        </div>

        <?php if (!isset($order_page)): ?>
            <ul class="navbar__content__links">
                <li><a href="/catalog">Katalog produktów</a></li>
                <li><a href="/contact">Kontakt</a></li>
            </ul>
            <div class="navbar__content__icons">
                <?php if (!isset($search)): ?>
                    <span class="navbar__content__icons__search"><i class="fas fa-search"></i></span>
                <?php endif; ?>

                <?php if (!isset($_SESSION['user'])): ?>
                    <a href="/login"><i class="far fa-user"></i></a>
                <?php else: ?>
                    <a href="/account"><i class="far fa-user"></i></a>
                <?php endif; ?>

                <a href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
        <?php else: ?>
            <div class="navbar__content__icons">
                <a href="/cart" class="back">Wróć do koszyka</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<nav class="navbar--mobile">
    <article class="navbar--mobile__links">
        <section class="navbar--mobile__links__single">
            <a href="/"><i class="fas fa-home"></i></a>
        </section>
        <section class="navbar--mobile__links__single">
            <a href="/catalog"><i class="fas fa-book-open"></i></a>
        </section>
        <section class="navbar--mobile__links__single">
            <a href="/contact"><i class="fas fa-phone"></i></a>
        </section>
        <section class="navbar--mobile__links__single navbar--mobile__links__single--search">
            <i class="fas fa-search"></i>
        </section>
        <section class="navbar--mobile__links__single">
            <?php if (!isset($_SESSION['user'])): ?>
                <a href="/login"><i class="far fa-user"></i></a>
            <?php else: ?>
                <a href="/account"><i class="far fa-user"></i></a>
            <?php endif; ?>
        </section>
        <section class="navbar--mobile__links__single">
            <a href="/cart"><i class="fa-solid fa-cart-shopping"></i></a>
        </section>
    </article>
</nav>