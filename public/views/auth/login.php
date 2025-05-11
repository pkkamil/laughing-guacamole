<?php
$title = "Logowanie";
$lazy = true;

// Symulacja błędów i starych danych
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
        <h2>Logowanie</h2>
        <form method="POST" action="login" class="auth__box__form">
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <label for="email" class="auth__box__form__input">
                <input type="email" name="email" id="email" placeholder="Adres email"
                    class="<?= errorClass('email') ?>"
                    value="<?= old('email') ?>" required autocomplete="email" autofocus>
            </label>

            <label for="password" class="auth__box__form__input">
                <input type="password" name="password" id="password" placeholder="Hasło"
                    class="<?= errorClass('password') ?>" required autocomplete="current-password">
            </label>

            <?= errorMessage('email') ?>
            <?= errorMessage('password') ?>

            <span class="auth__box__form__remember">
                <input type="checkbox" name="remember" id="remember" <?= old('remember') ? 'checked' : '' ?>>
                <label for="remember">Zapamiętaj</label>
            </span>

            <button type="submit" class="dark">Zaloguj</button>
            <a class="auth__box__form__reset" href="/reset">Zapomniałeś hasła?</a>
            <a href="/register">Nie masz jeszcze konta?</a>
        </form>
    </section>
</article>