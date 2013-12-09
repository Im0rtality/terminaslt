<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <!-- <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/css/bootstrap-combined.min.css" rel="stylesheet"> -->
    <link href="<?= ASSETS_ROOT; ?>bootstrap-combined.min.css" rel="stylesheet">
    <link href="<?= ASSETS_ROOT; ?>style.css" rel="stylesheet">
</head>
<body>
<div class="container" style="min-height: 610px;">
    <?php echo renderView(); ?>
</div>
<?php if ($controller !== 'admin'): ?>
    <div id="footer" class="footer">
        <?php require("footer.php"); ?>
    </div>
<?php endif ?>
<?php if (($controller !== 'admin') && ($controller !== 'home') && ($controller !== '')): ?>
    <a href="<?= ASSETS_ROOT ?>">
        <div class="home-box border-hover"></div>
    </a>
<?php endif ?>
<!-- <script src="http://code.jquery.com/jquery.js" type="text/javascript"></script> -->
<!-- <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script> -->
<script src="<?= ASSETS_ROOT; ?>jquery.js" type="text/javascript"></script>
<script src="<?= ASSETS_ROOT; ?>bootstrap.min.js"></script>
<script src="<?= ASSETS_ROOT; ?>app.js"></script>
</body>
</html>
