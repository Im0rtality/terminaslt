<?php require("menu.php"); ?>
<div class="row offset1">
	<div class="span10 admin-box">
		<h1>Terminų pasiūlymai</h1>
		<table class="table table-condensed table-hover">
			<thead>
				<tr>
					<th class="small">Terminas</th>
					<th>Reikšmė</th>
					<th class="small">IP</th>
					<th class="actions">&nbsp;</th>
				</tr>
			</thead>
			<?php foreach($submissions as $obj): ?>
			<tr>
				<td><?=$obj['term']?></td>
				<td><?=$obj['meaning']?></td>
				<td><?=$obj['ip']?></td>
				<td>
					<a class="btn btn-mini" href="<?=WEB_ROOT?>admin/editsubmission/<?=$obj['id']?>"> <i class="icon-pencil"></i></a>
					<button class="btn btn-mini btn-danger btn-action" data-action="delete" data-controller="submission" data-id="<?=$obj['id']?>"> <i class="icon-trash"></i></button>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>
</div>