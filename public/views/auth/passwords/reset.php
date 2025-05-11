<?php
$title = "Resetowanie hasła";
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
        <h2>Resetowanie hasła</h2>
        <form method="POST" action="reset.php" class="auth__box__form">
            <!-- CSRF -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <label for="email" class="auth__box__form__input">
                <input type="email" name="email" id="email" placeholder="Adres email"
                    class="<?= errorClass('email') ?>"
                    value="<?= old('email') ?>" required autocomplete="email" autofocus>
            </label>

            <?= errorMessage('email') ?>

            <button type="submit" class="dark">Zresetuj</button>
            <a href="/login">Jednak pamiętasz hasło?</a>
        </form>
    </section>
</article>