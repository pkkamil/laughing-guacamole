<?php
$title = "Rejestracja";

global $errors, $old;

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

unset($_SESSION['errors'], $_SESSION['old']);

function old($key)
{
    global $old;
    return htmlspecialchars($old[$key] ?? '');
}

function errorClass($key)
{
    global $errors;
    return isset($errors[$key]) ? 'incorrect' : '';
}

function errorMessage($key)
{
    global $errors;
    return isset($errors[$key]) ? '<span class="auth__box__form__incorrect" role="alert">' . htmlspecialchars($errors[$key]) . '</span>' : '';
}
?>

<article class="auth">
    <section class="auth__box">
        <h2>Rejestracja</h2>
        <form method="POST" action="register" class="auth__box__form">
            <!-- CSRF token -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <div class="auth__box__form__two">
                <label for="firstName" class="auth__box__form__two__input-small">
                    <input type="text" name="firstName" id="firstName" placeholder="Imię"
                        class="<?= errorClass('firstName') ?>"
                        value="<?= old('firstName') ?>" required autofocus>
                </label>
                <label for="lastName" class="auth__box__form__two__input-small">
                    <input type="text" name="lastName" id="lastName" placeholder="Nazwisko"
                        class="<?= errorClass('lastName') ?>"
                        value="<?= old('lastName') ?>" required>
                </label>
            </div>
            <?= errorMessage('firstName') ?>
            <?= errorMessage('lastName') ?>

            <label for="email" class="auth__box__form__input">
                <input type="email" name="email" id="email" placeholder="Adres email"
                    class="<?= errorClass('email') ?>"
                    value="<?= old('email') ?>" required autocomplete="email">
            </label>
            <?= errorMessage('email') ?>

            <label for="password" class="auth__box__form__input">
                <input type="password" name="password" id="password" placeholder="Hasło"
                    class="<?= errorClass('password') ?>" required autocomplete="new-password">
            </label>

            <label for="confirmedPassword" class="auth__box__form__input">
                <input type="password" name="confirmedPassword" id="confirmedPassword" placeholder="Potwierdzenie hasła"
                    class="<?= errorClass('password') ?>" required autocomplete="new-password">
            </label>
            <?= errorMessage('password') ?>

            <button type="submit" class="dark">Stwórz</button>
            <a href="/login">Posiadasz już konto?</a>
        </form>
    </section>
</article>