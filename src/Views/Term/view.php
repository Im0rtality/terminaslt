<div class="box span6 offset3">
<?php if ($isTerm === true) : ?>
	<h1 class="deco"><?=$data['term']?></h1>
	<div class="term-meaning">
		<p><?=$data['meaning']?></p>
	</div>
	<?php if (Auth::isLoggedIn()) : ?>
	<?php foreach ($comments as $obj) :?>
	<blockquote>
		<p><?=$obj['content']?></p>
		<small><?=$obj['name']?></small>
	</blockquote>
	<?php endforeach ?>
	<form class="form-horizontal" id="form-add-comment"  style="margin-top:50px" method='POST' action="<?=WEB_ROOT?>comment/submit/">
		<input type="hidden" name="id" value="<?=$data['id']?>">
		<textarea class="span6" name="comment" placeholder="Komentaras"></textarea>
		<div class="pull-right" style="margin-top:10px">
			<button class='btn btn-primary' type="submit">Siųsti</button>
		</div>
	</form>
	<?php endif; ?>
<?php else: ?>
	<h1>Terminas nerastas</h1>
	<p>Jūsų pasirinktas terminas sistemos duomazėje neegzistuoja. Jei norite prisidėti prie duombazės pildymo galite užpildyti šią formą.</p>
	<form class="form-horizontal span4 offset0" id="form-add-term" method='POST' action="<?=WEB_ROOT?>term/submit/">
		<legend>Termino pridėjimo užklausa</legend>
		<div class='control-group'>
			<input class="span4" type="text" name="term" placeholder="Terminas" value="<?=$query?>">
		</div>
		<div class='control-group'>
			<textarea class="span4" name="meaning" placeholder="Reikšmė"></textarea>
		</div>
		<div class='control-group'>
			<textarea class="span4" name="comment" placeholder="Komentaras"></textarea>
		</div>
		<div class='form-actions'>
			<div class="pull-right">
				<button class='btn btn-primary' type="submit">Siųsti</button>
			</div>
		</div>
	</form>
<?php endif; ?>
</div>