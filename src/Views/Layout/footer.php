<?php use Utils\Auth; ?>
<div class="container">
    <p>Designed and crafted from scratch by <a href="http://www.im0rtality.com">Laurynas Veržukauskas</a></p>

    <p>Empowered by <a href="jquery.com">jQuery</a>, <a href="twitter.github.com/bootstrap/">Bootstrap</a>, <a
            href="http://raphaeljs.com/">Raphaël</a> and <a href="http://glyphicons.com/">Glyphicons Free</a></p>
    <ul class="footer-links">
        <li><a href="<?= $this->url('') ?>">Home</a></li>
        <li class="muted">•</li>
        <?php if (Auth::getInstance()->isLoggedIn()) : ?>
            <li><a href="<?= $this->url('logout') ?>">Logout</a>
                <small class="muted">(<span id="user-name"><?= Auth::getInstance()->user('name') ?></span>)</small>
            </li>
            <?php if (Auth::getInstance()->hasFlag(Auth::FLAG_ADMIN)) : ?>
                <li class="muted">•</li>
                <li><a href="<?= $this->url('admin') ?>">Admin</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="<?= $this->url('login') ?>">Login</a></li>
        <?php endif; ?>
    </ul>
</div>
