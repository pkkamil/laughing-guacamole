<?php
$title = "Rejestracja";
$lazy = true;

// Symulacja błędów i starych danych (zazwyczaj pochodzi z walidacji po POST)
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];

// Wyczyść sesję błędów po użyciu
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
        <form method="POST" action="register.php" class="auth__box__form">
            <!-- CSRF token -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>">

            <div class="auth__box__form__two">
                <label for="name" class="auth__box__form__two__input-small">
                    <input type="text" name="name" id="name" placeholder="Imię"
                        class="<?= errorClass('name') ?>"
                        value="<?= old('name') ?>" required autofocus>
                </label>
                <label for="surname" class="auth__box__form__two__input-small">
                    <input type="text" name="surname" id="surname" placeholder="Nazwisko"
                        class="<?= errorClass('surname') ?>"
                        value="<?= old('surname') ?>" required>
                </label>
            </div>
            <?= errorMessage('name') ?>
            <?= errorMessage('surname') ?>

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

            <label for="password_confirmation" class="auth__box__form__input">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Potwierdzenie hasła"
                    class="<?= errorClass('password') ?>" required autocomplete="new-password">
            </label>
            <?= errorMessage('password') ?>

            <button type="submit" class="dark">Stwórz</button>
            <a href="/login">Posiadasz już konto?</a>
        </form>
    </section>
</article>