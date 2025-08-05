<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Titre et Icon -->
    <title><?= $title ?></title>
    <link rel="icon" href="Assets/Picture/cookie.png">

    <!-- StylesHeet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/devicons/devicon@v2.15.1/devicon.min.css">
    <link rel="stylesheet" href="Assets/Css/style.css">
    <link rel="stylesheet" href="Assets/Css/sections.css">
    <link rel="stylesheet" href="Assets/Css/responsive.css">
    <link rel="stylesheet" href="Assets/Css/navigation.css">
    <link rel="stylesheet" href="Assets/Css/footer.css">
    <link rel="stylesheet" href="Assets/Css/animation.css">
    <link rel="stylesheet" href="Assets/Css/loginForm.css">
    <link rel="stylesheet" href="Assets/Css/dashboard.css">
</head>
<body>
    <!-- navbar -->
    <?php if (!empty($navbar)) require_once($navbar); ?>

    <!-- main -->
    <?php if (!empty($template)) require_once($template); ?>

    <!-- modals -->
    <?php if (!empty($modal[0])) require_once($modal[0]); ?>
    <?php if (!empty($modal[1])) require_once($modal[1]); ?>

    <!-- footer -->
    <?php if (!empty($footer)) require_once($footer); ?>

    <!-- Scripts -->
    <script src="Assets/Script/script.js"></script>
    <script src="Assets/Script/scriptModal.js"></script>
    <script src="Assets/Script/adminNav.js"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>