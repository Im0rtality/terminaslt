<?php require("menu.php"); ?>
<div class="row offset1">
    <div class="span10 admin-box">
        <h1>Vartotojai</h1>
        <a class="btn" href="<?= WEBSITE_ROOT ?>admin/edituser/0"><i class="icon-pencil"></i> Pridėti vartotoją</a>
        <table class="table table-condensed table-hover" width="100%" style="margin-bottom: 0;">
            <thead>
            <th>Vardas</th>
            <th>E-paštas</th>
            <th class="small">isAdmin</th>
            <th class="actions">&nbsp;</th>
            </thead>
            <?php foreach ($users as $obj): ?>
                <tr>
                    <td><?= $obj['name'] ?></td>
                    <td><?= $obj['email'] ?></td>
                    <td><?= $obj['isAdmin'] == 1 ? "Yes" : "No" ?></td>
                    <td>
                        <a class="btn btn-mini" href="<?= WEBSITE_ROOT ?>admin/edituser/<?= $obj['id'] ?>"> <i
                                class="icon-pencil"></i></a>
                        <button class="btn btn-mini btn-danger" data-action="delete" data-id="<?= $obj['id'] ?>"><i
                                class="icon-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
