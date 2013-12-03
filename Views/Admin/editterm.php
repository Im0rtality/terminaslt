<?php require("menu.php"); ?>
<div class="row offset1">
	<div class="span10 admin-box">
		<div class="row">
			<div class="span6 offset2">
				<form class="form-horizontal" action="<?=WEB_ROOT?>admin/saveterm/<?=$term['id']?>" method="post">
					<legend><?php if ($term['id'] !== null): ?>Keisti terminą<?php else: ?>Pridėti terminą<?php endif; ?></legend>
					<input type="hidden" name="id" value="<?=$term['id']?>">
					<div class="control-group">
						<label class="control-label">Terminas</label>
						<div class="controls">
							<input class="input-block-level" type="text" name="term" value="<?=$term['term']?>" placeholder="Terminas">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Reikšmė</label>
						<div class="controls">
							<textarea class="input-block-level" rows="6" name="meaning" placeholder="Reikšmė"><?=$term['meaning']?></textarea>
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