<?php use Utils\Auth; ?>
<div class="container">
    <p>Designed and crafted from scratch by <a href="http://www.im0rtality.com">Laurynas Veržukauskas</a></p>

    <p>Empowered by <a href="jquery.com">jQuery</a>, <a href="twitter.github.com/bootstrap/">Bootstrap</a>, <a
            href="http://raphaeljs.com/">Raphaël</a> and <a href="http://glyphicons.com/">Glyphicons Free</a></p>
    <ul class="footer-links">
        <li><a href="<?= WEB_ROOT ?>">Home</a></li>
        <li class="muted">•</li>
        <?php if (Auth::isLoggedIn()) : ?>
            <li><a href="<?= url('logout') ?>">Logout</a>
                <small class="muted">(<span id="user-name"><?= Auth::user('name') ?></span>)</small>
            </li>
            <?php if (Auth::hasFlag(Auth::FLAG_ADMIN)) : ?>
                <li class="muted">•</li>
                <li><a href="<?= url('admin') ?>">Admin</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="<?= url('login') ?>">Login</a></li>
        <?php endif; ?>
    </ul>
</div>
