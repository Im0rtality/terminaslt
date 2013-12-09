<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $this->getTitle() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= ASSETS_ROOT; ?>bootstrap-combined.min.css" rel="stylesheet">
    <link href="<?= ASSETS_ROOT; ?>style.css" rel="stylesheet">
</head>
<body>
<div class="container" style="min-height: 610px;">
    <?php $this->renderView(); ?>
</div>
<?php if ($this->getController() !== 'admin'): ?>
    <div id="footer" class="footer">
        <?php require("footer.php"); ?>
    </div>
    <?php
endif ?>
<?php
if (($this->getController() !== 'admin') && ($this->getController() !== 'home') && ($this->getController() !== '')):
    ?>
    <a href="<?= ASSETS_ROOT ?>">
        <div class="home-box border-hover"></div>
    </a>
    <?php
endif ?>
<script src="<?= ASSETS_ROOT; ?>jquery.js" type="text/javascript"></script>
<script src="<?= ASSETS_ROOT; ?>bootstrap.min.js"></script>
<script src="<?= ASSETS_ROOT; ?>app.js"></script>
</body>
</html>
