<header class="site-header">
  <div class="container header-inner">
    <div class="header-brand">
      <img class="brand-emblem" src="<?= asset('assets/hospitality-mark.svg') ?>" width="64" height="80" alt="" aria-hidden="true">
      <div>
        <a class="wordmark" href="/" aria-label="Luana Nanu, home">Luana Nanu<span>Ph.D.</span></a>
        <p class="brand-description">Consumer behavior · Research &amp; education</p>
      </div>
    </div>
    <nav aria-label="Main navigation">
      <?php foreach ($site->pages as $route => $item): if ($route === '/') continue; ?>
      <a href="<?= e($route) ?>"<?= $path === $route ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
      <?php endforeach ?>
    </nav>
  </div>
</header>
