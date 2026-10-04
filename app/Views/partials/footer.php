<footer class="site-footer">
  <div class="container footer-inner">
    <div class="footer-identity">
      <a class="wordmark" href="/">Luana Nanu<span>Ph.D.</span></a>
      <p>Consumer behavior research &amp; education</p>
      <p class="footer-note">Understanding people.<br>Connecting research and practice.</p>
    </div>
    <div class="footer-explore">
      <p class="footer-label">Explore</p>
      <nav aria-label="Footer navigation">
        <?php foreach ($site->pages as $route => $item): ?>
        <a href="<?= e($route) ?>"<?= $path === $route ? ' aria-current="page"' : '' ?>><?= e($item['label']) ?></a>
        <?php endforeach ?>
      </nav>
    </div>
    <div class="footer-connect">
      <p class="footer-label">Connect</p>
      <a class="footer-contact" href="/contact">Start a conversation <span aria-hidden="true">↗</span></a>
      <div class="footer-profiles">
        <a href="https://scholar.google.com/citations?user=Jz0kZsIAAAAJ&amp;hl=en">Google Scholar <span aria-hidden="true">↗</span></a>
        <a href="https://orcid.org/0000-0002-6157-330X">ORCID <span aria-hidden="true">↗</span></a>
      </div>
    </div>
  </div>
  <div class="container footer-bottom">
    <p>© <?= date('Y') ?> Luana Nanu</p>
    <a href="#top">Back to top <span aria-hidden="true">↑</span></a>
  </div>
</footer>
