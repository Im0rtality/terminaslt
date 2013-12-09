<?php require("menu.php"); ?>
<div class="row offset1">
    <div class="span10">
        <h1>Apžvalga</h1>

        <div class="row">
            <div class="span5 admin-box border">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="<?= $this->url('admin', 'comments') ?>">Komentarai</a>
                        </th>
                    </tr>
                    </thead>
                    <?php foreach ($comments as $obj): ?>
                        <tr>
                            <td><?= $obj['content'] ?></td>
                            <!-- <td><?=$obj['term']?></td> -->
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="span5 admin-box border">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>
                            <a href="<?= $this->url('admin', 'submissions') ?>">Pasiūlymai</a>
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <?php foreach ($submissions as $obj): ?>
                        <tr>
                            <td><?= $obj['term'] ?></td>
                            <td><?= $obj['meaning'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="span5 admin-box border" style="height:183px">
                <!-- <h5>-reserved-</h5> -->
                <div id="chart1">
                </div>
            </div>
            <div class="span5 admin-box border">
                <h5>-reserved-</h5>
            </div>
        </div>
    </div>
</div>
<script src="<?= WEB_ROOT; ?>raphael.min.js" type="text/javascript"></script>
<script src="<?= WEB_ROOT; ?>g.raphael.min.js"></script>
<script src="<?= WEB_ROOT; ?>g.pie.min.js"></script>
<script>
    var r = Raphael("chart1");
    // r.piechart(354, 87, 85, [
    <?=$termCloudHits?>], {legend: ['a', 'b']});

    pie = r.piechart(284, 90, 80, [<?=$termCloudHits?>], { legend: [<?=$termCloudTerms?>], legendpos: "west"});

    r.text(10, 10, "Terminų debesies būsena").attr({
        'font-family': "'Helvetica Neue', Helvetica, Arial, sans-serif",
        'font-size': '14px',
        'font-weight': 'bold',
        fill: 'rgb(0, 136, 204)',
        'text-anchor': 'start'});

    pie.hover(function () {
        this.sector.stop();
        this.sector.scale(1.1, 1.1, this.cx, this.cy);

        if (this.label) {
            this.label[0].stop();
            this.label[0].attr({ r: 7.5 });
            this.label[1].attr({ "font-weight": 800 });
        }
    }, function () {
        this.sector.animate({ transform: 's1 1 ' + this.cx + ' ' + this.cy }, 500, "bounce");

        if (this.label) {
            this.label[0].animate({ r: 5 }, 500, "bounce");
            this.label[1].attr({ "font-weight": 400 });
        }
    });
    r.height = 168;
</script>
