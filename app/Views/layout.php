<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($page['title']) ?></title>
  <meta name="description" content="<?= e($page['description']) ?>">
  <meta name="theme-color" content="#173e2e">
  <meta name="color-scheme" content="light">
<?php if ($status === 200): ?>
  <link rel="canonical" href="<?= e($canonical) ?>">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Luana Nanu">
  <meta property="og:locale" content="en_US">
  <meta property="og:title" content="<?= e($page['title']) ?>">
  <meta property="og:description" content="<?= e($page['description']) ?>">
  <meta property="og:url" content="<?= e($canonical) ?>">
  <meta property="og:image" content="<?= e($site::ORIGIN) . asset('assets/luana-nanu.jpg') ?>">
  <meta property="og:image:width" content="480">
  <meta property="og:image:height" content="720">
  <meta property="og:image:alt" content="Portrait of Luana Nanu">
  <meta name="twitter:card" content="summary">
  <meta name="twitter:title" content="<?= e($page['title']) ?>">
  <meta name="twitter:description" content="<?= e($page['description']) ?>">
  <meta name="twitter:image" content="<?= e($site::ORIGIN) . asset('assets/luana-nanu.jpg') ?>">
  <meta name="twitter:image:alt" content="Portrait of Luana Nanu">
  <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR) ?></script>
<?php else: ?>
  <meta name="robots" content="noindex, follow">
<?php endif ?>
  <link rel="icon" href="<?= asset('assets/favicon.svg') ?>" type="image/svg+xml">
  <link rel="preload" href="<?= asset('assets/dm-sans.woff2') ?>" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="<?= asset('assets/libre-caslon-display.woff2') ?>" as="font" type="font/woff2" crossorigin>
  <link rel="stylesheet" href="<?= asset('assets/site.css') ?>">
</head>
<body class="page-<?= e($page['view']) ?>">
  <a class="skip-link" href="#main">Skip to content</a>
  <?php require __DIR__ . '/partials/header.php'; ?>
  <main id="main" tabindex="-1">
    <?php if ($status === 200 && $path !== '/'): ?>
    <nav class="container breadcrumbs" aria-label="Breadcrumb">
      <a href="/">Home</a><span aria-hidden="true">/</span><span aria-current="page"><?= e($page['label']) ?></span>
    </nav>
    <?php endif ?>
    <?php require __DIR__ . '/pages/' . $page['view'] . '.php'; ?>
  </main>
  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>
