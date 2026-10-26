<header class="site-header" id="top" tabindex="-1">
  <div class="container header-inner">
    <a class="header-brand" href="/" aria-label="Luana Nanu, Ph.D., home">
      <img class="brand-logo brand-logo-dark" src="<?= asset('assets/luana-nanu-header-for-dark-background.svg') ?>" width="440" height="80" alt="" aria-hidden="true">
      <img class="brand-logo brand-logo-light" src="<?= asset('assets/luana-nanu-header.svg') ?>" width="440" height="80" alt="" aria-hidden="true">
      <span class="brand-compact" aria-hidden="true">
        <img src="<?= asset('assets/luana-nanu-icon.svg') ?>" width="64" height="64" alt="" aria-hidden="true">
        <span class="brand-copy">
          <span class="brand-name">Luana Nanu<span class="brand-degree">Ph.D.</span></span>
          <span class="brand-focus">Hospitality · Consumer behavior</span>
        </span>
      </span>
    </a>
    <nav aria-label="Main navigation">
      <?php foreach ($site->pages as $route => $item): if ($route === '/') continue; ?>
      <a href="<?= e($route) ?>"<?= $path === $route ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
      <?php endforeach ?>
    </nav>
  </div>
</header>
