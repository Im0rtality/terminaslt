<?php require "menu.php"; ?>
<div class="row offset1">
    <div class="span10 admin-box">
        <h1>Komentarai</h1>
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th>Komentaras</th>
                <th class="small">Vartotojas</th>
                <th class="small">Terminas</th>
                <th class="actions">&nbsp;</th>
            </tr>
            </thead>
            <?php foreach ($comments as $obj): ?>
                <tr>
                    <td><?php echo $obj['content'] ?></td>
                    <td>
                        <a href="<?= $this->url('admin', 'edituser', $obj['user_id']) ?>"><?php echo $obj['name'] ?></a>
                    </td>
                    <td><?php echo $obj['term'] ?></td>
                    <td>
                        <button class="btn btn-mini btn-danger btn-action" data-controller="comment"
                                data-action="delete" data-id="<?php echo $obj['id'] ?>"><i class="icon-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
