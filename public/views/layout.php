<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="apple-mobile-web-app-title" content="Emptum" />

    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="shortcut icon" href="/public/img/icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/img/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/img/icons/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="256x256" href="/public/img/icons/apple-touch-icon.png" />
    <link rel="apple-touch-startup-image" href="/public/img/icons/favicon.ico" />

    <!-- Open Graph -->
    <meta property="og:title" content="Emptum - Sklep marzeń" />
    <meta property="og:description" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="../favicon.ico" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Emptum" />

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">

    <?php if (isset($title)): ?>
        <title><?= htmlspecialchars($title) . ' | Emptum' ?></title>
    <?php else: ?>
        <title>Emptum - Sklep marzeń</title>
    <?php endif; ?>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
</head>

<body>
    <?php include_once __DIR__ . '/partials/navbar.php'; ?>
    <?php include_once __DIR__ . '/partials/search.php'; ?>


    <?php if (isset($lazy)): ?>
        <div class="loader-wrapper"></div>
        </div>
        <script>
            $(window).on("load", function() {
                $(".loader-wrapper").delay(200).fadeOut(700);
            });
        </script>
    <?php endif; ?>

    <div class="container">
        <?= $content ?? '' ?>
    </div>

    <?php include_once __DIR__ . '/partials/footer.php'; ?>
</body>

</html>