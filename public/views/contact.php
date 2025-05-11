<?php
$title = "Kontakt";
$lazy = true;

// Przykładowy użytkownik zalogowany (np. z sesji)
// $user = [
//     'name' => 'Jan',
//     'surname' => 'Kowalski',
//     'email' => 'jan.kowalski@example.com',
//     'telephone' => '123456789'
// ];

// Jeśli użytkownik nie jest zalogowany, $user może być null
$isLoggedIn = isset($user);
?>

<article class="contact">
    <section class="contact__box">
        <h2>Skontaktuj się z nami!</h2>
        <form action="" method="POST" autocomplete="off" class="contact__box__form">
            <label for="name" class="contact__box__form__input">
                <input type="text" name="name" id="name" placeholder="Imię"
                    value="<?= $isLoggedIn ? htmlspecialchars($user['name']) : '' ?>"
                    required>
            </label>
            <label for="surname" class="contact__box__form__input">
                <input type="text" name="surname" id="surname" placeholder="Nazwisko"
                    value="<?= $isLoggedIn ? htmlspecialchars($user['surname']) : '' ?>"
                    required>
            </label>
            <label for="email" class="contact__box__form__input">
                <input type="email" name="email" id="email" placeholder="Adres email"
                    value="<?= $isLoggedIn ? htmlspecialchars($user['email']) : '' ?>"
                    required>
            </label>
            <label for="telephone" class="contact__box__form__input">
                <input type="text" name="telephone" id="telephone" placeholder="Numer telefonu"
                    value="<?= $isLoggedIn ? htmlspecialchars($user['telephone']) : '' ?>">
            </label>
            <label for="content" class="contact__box__form__input__textarea">
                <textarea name="content" id="content" placeholder="Wiadomość" required minlength="10"></textarea>
            </label>
            <button type="submit" class="dark">Wyślij wiadomość</button>
        </form>
    </section>
</article>