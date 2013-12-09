<?php require("menu.php"); ?>
<div class="row offset1">
    <div class="span10 admin-box">
        <div class="row">
            <div class="span6 offset2">
                <form class="form-horizontal" action="<?= WEBSITE_ROOT ?>admin/saveuser/<?= $user['id'] ?>" method="post">
                    <legend><?php if ($user['id'] !== null): ?>Keisti vartotoją<?php else: ?>Pridėti vartotoją<?php endif; ?></legend>
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">

                    <div class="control-group">
                        <label class="control-label">Vardas</label>

                        <div class="controls">
                            <input type="text" name="name" value="<?= $user['name'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">E-paštas</label>

                        <div class="controls">
                            <input type="text" name="email" value="<?= $user['email'] ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Slaptažodis</label>

                        <div class="controls">
                            <input type="password" name="password" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- <label class="control-label">Flags</label> -->
                        <br/>

                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="flags[0]" <?= $isAdmin ?>> Administratorius
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="pull-right">
                            <button class="btn btn-primary" type="submit">Išsaugoti</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
