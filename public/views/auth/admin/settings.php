<?php
$title = "Ustawienia strony";

var_dump($settings['hero_image']);
?>

<article class="admin">
    <section class="admin__content">
        <div class="admin__content__main">
            <h2>Edytowanie ustawień strony</h2>
            <a href="/admin" class="back">Powrót</a>
        </div>
        <form action="save" method="POST" enctype="multipart/form-data">
            <section class="admin__content__settings">
                <div class="admin__content__settings__basic">
                    <div class="admin__content__settings__basic__hero-image">
                        <h4>Zmiana tła strony powitalnej</h4>
                        <label for="hero-image" class="admin__content__settings__basic__hero-image__image">
                            <?php if ($settings['hero_image']): ?>
                                <img src="<?= htmlspecialchars($settings['hero_image']) ?>" alt="Tło strony powitalnej">
                            <?php endif; ?>
                            <i class="fas fa-camera"></i>
                        </label>
                        <input accept="image/*" name="homepage_background" id="hero-image" type="file">
                        <span>Zaleca się zdjęcia o rozdzielczości Full HD i&nbsp;proporcjach 16:9</span>
                    </div>

                    <div class="admin__content__settings__basic__welcome">
                        <div class="admin__content__settings__basic__welcome__box-text">
                            <h4>Zmiana tekstu okna powitalnego</h4>
                            <label for="welcome-box-text" class="input">
                                <input type="text" name="welcome_box_text" id="welcome-box-text"
                                    value="<?= htmlspecialchars($settings['welcome_box_text']) ?>"
                                    placeholder="Przeglądaj wspaniałe produkty" required>
                            </label>
                        </div>

                        <div class="admin__content__settings__basic__welcome__box-button-text">
                            <h4>Zmiana tekstu przycisku okna powitalnego</h4>
                            <label for="welcome-box-button-text" class="input">
                                <input type="text" name="welcome_box_button_text" id="welcome-box-button-text"
                                    value="<?= htmlspecialchars($settings['welcome_box_button_text']) ?>"
                                    placeholder="Przeglądaj" required>
                            </label>
                        </div>
                        <button type="submit" class="button dark">Zapisz zmiany</button>
                    </div>

                </div>
            </section>
        </form>
    </section>
</article>