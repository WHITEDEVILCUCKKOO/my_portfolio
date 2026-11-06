
<footer class="abh-foot">
    <div class="abh-wrap abh-foot-in">
        <div><strong><?= $v('name') ?></strong><br><?= $v('title') ?></div>
        <nav aria-label="Footer"><a href="#about">About</a> <a href="#projects">Projects</a> <a href="#contact">Contact</a></nav>
        <div><?php foreach (['github' => 'GitHub', 'linkedin' => 'LinkedIn'] as $k => $l): if (abh_url($S[$k] ?? '')): ?><a href="<?= $v($k) ?>" target="_blank" rel="noopener noreferrer"><?= $l ?></a> <?php endif;
                                                                                                                                                                                                    endforeach; ?></div>
        <small>&copy; <?= date('Y') ?> <?= $v('name') ?>. All rights reserved.</small>
    </div>
</footer>


<script src="assets/ui.js"></script>
</body>

</html>