<div class="span2 well"
     style="position: fixed; left: 19px; top:19px; max-width: 340px; padding: 8px 0; margin-left: 0;">
    <ul class="nav nav-list">
        <li class="nav-header">Valdymas</li>

        <li><a href="<?= $this->url('admin', 'index') ?>">Apžvalga</a></li>
        <li><a href="<?= $this->url('admin', 'comments') ?>">Komentarai</a></li>
        <li><a href="<?= $this->url('admin', 'submissions') ?>">Terminų pasiūlymai</a></li>
        <li><a href="<?= $this->url('admin', 'terms') ?>">Terminai</a></li>
        <li><a href="<?= $this->url('admin', 'users') ?>">Vartotojai</a></li>

        <li class="nav-header">Kita</li>
        <li><a href="<?= WEBSITE_ROOT ?>">Pradinis</a></li>
        <li><a href="<?= $this->url('logout') ?>">Baigti darbą</a></li>
    </ul>
</div>
