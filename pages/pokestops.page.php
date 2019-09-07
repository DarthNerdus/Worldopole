<header id="single-header">
	<div class="row">
		<div class="col-md-12 text-center">
			<h1>
				<?= sprintf($locales->POKESTOPS_TITLE, $config->infos->city); ?>
			</h1>
			
		</div>
	</div>
</header>


<div class="row area">

	<?php
    if (true === !$config->system->no_lures) {
        ?>
		<div class="col-md-4 col-sm-4 col-xs-12 big-data" style="border-right:1px lightgray solid;"> <!-- POKESTOPS -->
		<?php
    } else {
        ?>
		<div class="big-data"> <!-- POKESTOPS -->
		<?php
    }
    ?>
		<img src="core/img/pokestop.png" alt="Pokestop" width=50 class="big-icon">
		<p><big><strong><?= $pokestop->total; ?></strong> <?= $locales->POKESTOPS; ?></big><br> <?= sprintf($locales->INCITY, $config->infos->city); ?></p>
	</div>

	<?php
    if (true === !$config->system->no_lures) {
        ?>
		<div class="col-md-4 col-sm-4 col-xs-12 big-data" style="border-right:1px lightgray solid;"> <!-- LURED STOPS -->
		<img src="core/img/lure-module.png" alt="Lured Pokestop" width=50 class="big-icon">
			<p><big><strong><?= $pokestop->lured; ?></strong> <?= $locales->LURES; ?></big><br> <?= $locales->POKESTOPS_LURES; ?></p>
		</div>

		<div class="col-md-4 col-sm-4 col-xs-12 big-data"> <!-- INVADED STOPS -->
                <img src="core/img/rocket_medal.png" alt="Team Rocket Invasions" width=50 class="big-icon">
                        <p><big><strong><?= $pokestop->invaded; ?></strong> Invasions</big><br>active now</p>
                </div>
	<?php
    }
    ?>
</div>

<?php
if (true === !$config->system->no_lures) {
        ?>
	<div class="row text-center subnav">
		<div class="btn-group" role="group">
		<a class="btn btn-default active" id="lureSelector"><i class="fa fa-bolt"></i> Active</a>
		<a class="btn btn-default " id="pokestopSelector"><i class="fa fa-medkit"></i> All Pokestops</a>
	</div>
	</div>
	<?php
    }
?>

<div class="row">
	
	<div class="col-md-12">
	
		<div id="map">
		
		</div>
	
	</div>

</div>
