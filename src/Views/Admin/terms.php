<?php require("menu.php"); ?>
<div class="row offset1">
    <div class="span10 admin-box">
        <h1>Terminai</h1>
        <a class="btn" href="<?= WEBSITE_ROOT ?>admin/editterm/0"><i class="icon-pencil"></i> Pridėti terminą</a>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th class="small">Terminas</th>
                <th>Reikšmė</th>
                <th class="actions">&nbsp;</th>
            </tr>
            </thead>
            <?php foreach ($terms as $obj): ?>
                <tr>
                    <td><?= $obj['term'] ?></td>
                    <td><?= $obj['meaning'] ?></td>
                    <td>
                        <a class="btn btn-mini" href="<?= WEB_ROOT ?>admin/editterm/<?= $obj['id'] ?>"> <i
                                class="icon-pencil"></i></a>
                        <button class="btn btn-mini btn-danger btn-action" data-controller="term" data-action="delete"
                                data-id="<?= $obj['id'] ?>"><i class="icon-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
