<footer class="site-footer">
  <div class="container footer-inner">
    <div>
      <a class="wordmark" href="/">Luana Nanu<span>Ph.D.</span></a>
      <p>Consumer behavior research &amp; education</p>
    </div>
    <nav aria-label="Footer navigation">
      <?php foreach ($site->pages as $route => $item): ?>
      <a href="<?= e($route) ?>"<?= $path === $route ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
      <?php endforeach ?>
    </nav>
    <p>© <?= date('Y') ?> Luana Nanu</p>
  </div>
</footer>
