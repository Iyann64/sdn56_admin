<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($title ?? 'Dashboard') ?> – Admin SDN 56</title>
<link rel="icon" type="image/png" href="<?= $logo_url ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/admin-style.css') ?>?v=2">
</head>
<body>

    <div class="admin-layout active" id="adminLayout">

    <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;z-index:199;background:rgba(0,0,0,.5);backdrop-filter:blur(2px)"></div>
    <style>#sidebarOverlay.show{display:block!important}</style>

    <?= view('partials/sidebar') ?>

    <div class="main-area" id="mainArea">
        <?= view('partials/topbar') ?>
        <main class="page-content">
            <?= view('partials/alert') ?>
            <?= view($content_view) ?>
        </main>
    </div>

    </div>

    <?= view('partials/modals') ?>
    <div class="toast-container" id="toastContainer"></div>
<script src="<?= base_url('assets/js/admin-script.js') ?>"></script>
</body>
</html>