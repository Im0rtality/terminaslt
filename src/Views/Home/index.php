<div class="container">
	<div class="row">
		<div class="box span8 offset2 text-center" id="logo-box">
			<h1 class="deco">Terminas.lt</h1>
				<span class="span8 offset0 term-cloud">
					<?php foreach($termCloud as $termRow): ?>
					<?php foreach($termRow as $term): ?>
					<span style="font-size:<?=$term['scale']?>%">
						<a href="<?=url('term', 'view', $term['term'])?>"><?=$term['term']?></a>
					</span>
				<?php endforeach ?>
				<br/>
			<?php endforeach ?>
		</span>
	<div class="span4 offset2" style="padding-bottom:40px">
		<form action="index.php" method="get" id="term-search-form" class="form-inline">
			<input type="hidden" value="view" name="action"/>
			<input type="hidden" value="term" name="controller"/>
			<input class="input-xlarge search-query typeahead" type="text" placeholder="Įveskite terminą" id="term-search-form-query" data-link="index.php?controller=list&action=index/">
			<button class="btn" type='submit'> <i class="icon-search"></i></button>
		</form>
	</div>
	</div>
</div>
</div>