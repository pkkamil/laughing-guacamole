<?php
$title = "Kontakt";

$errors = $errors ?? [];
$isLoggedIn = isset($user);

function old($key)
{
    global $old;
    return htmlspecialchars($old[$key] ?? '');
}
?>

<article class="contact">
    <section class="contact__box">
        <h2>Skontaktuj się z nami!</h2>
        <?php if (isset($success)): ?>
            <p>Twoja wiadomość została wysłana!.</p>
        <?php else: ?>
            <form action="submit" method="POST" autocomplete="off" class="contact__box__form">
                <label for="firstName" class="contact__box__form__input">
                    <input type="text" name="firstName" id="firstName" placeholder="Imię"
                        value="<?= $isLoggedIn ? htmlspecialchars($user['firstName']) : '' ?>"
                        required>
                </label>
                <label for="lastName" class="contact__box__form__input">
                    <input type="text" name="lastName" id="lastName" placeholder="Nazwisko"
                        value="<?= $isLoggedIn ? htmlspecialchars($user['lastName']) : '' ?>"
                        required>
                </label>
                <label for="email" class="contact__box__form__input">
                    <input type="email" name="email" id="email" placeholder="Adres email"
                        value="<?= $isLoggedIn ? htmlspecialchars($user['email']) : '' ?>"
                        required>
                </label>
                <label for="phone" class="contact__box__form__input">
                    <input type="text" name="phone" id="phone" placeholder="Numer telefonu" value="<?= old('phone') ?>">
                </label>
                <label for="message" class="contact__box__form__input__textarea">
                    <textarea name="message" id="message" placeholder="Wiadomość" required minlength="10">
                        <?= old('message') ?>
                    </textarea>
                </label>
                <button type="submit" class="dark">Wyślij wiadomość</button>
            </form>
        <?php endif; ?>
    </section>
</article>