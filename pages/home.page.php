<header id="single-header">
	<div class="row">
		<div class="col-md-12 text-center">
			<h1>
				<?= $config->infos->site_title; ?>
				<br>
				<small><?= sprintf($config->infos->site_claim, $config->infos->city); ?></small>
			</h1>

		</div>
	</div>
</header>

<div class="flex-container row area">

	<div class="flex-item-homepage big-data"> <!-- LIVEMON -->
		<a href="pokemon">
			<img src="core/img/pokeball.png" alt="Visit the <?= $config->infos->site_name; ?> Pokedex" width=50 class="big-icon">
			<p><big><strong class="total-pkm-js">0</strong> Pokémon</big><br>
			<?= sprintf($locales->WIDGET_POKEMON_SUB, $config->infos->city); ?></p>
		</a>
	</div>


	<?php
    if (true === !$config->system->no_lures) {
        ?>
		<div class="flex-item-homepage big-data"> <!-- POKESTOPS -->
			<a href="pokestops">
				<img src="core/img/rocket_medal.png" alt="<?= $config->infos->site_name; ?> Invasions" width=50 class="big-icon">
				<p><big><strong class="total-lure-js">0</strong> Invasions</big><br>
                    <?= sprintf($locales->WIDGET_LURES_SUB, $config->infos->city); ?></p>
			</a>
		</div>
		<?php
    }
    if (true === $config->system->homepage_raids) {
        ?>
		<div class="flex-item-homepage flex-item-homepage-homepage big-data"> <!-- RAIDS -->
			<a href="raids">
				<img src="core/img/raid.png" alt="Discover the <?= $config->infos->site_name; ?> Raids" width=50
                     class="big-icon">
				<p><big><strong class="total-raids-js">0</strong> <?= $locales->RAIDS; ?></big><br>
                    <?= sprintf($locales->WIDGET_LURES_SUB, $config->infos->city); ?></p>
			</a>
		</div>
		<?php
    }
    ?>

	<div class="flex-item-homepage big-data">
		<a href="<?= $config->homewidget->url; ?>" target="_blank">
			<img src="<?= $config->homewidget->image; ?>" alt="<?= $config->homewidget->image_alt; ?>" width=50 class="big-icon">
			<p><?= $config->homewidget->text; ?></p>
		</a>
	</div>

</div>

<div class="row area big padding">
        <h2 class="text-center sub-title"><?= $locales->FIGHT_TITLE; ?></h2>

                <?php
            foreach ($home->teams as $team => $total) {
                if ($home->teams->rocket) {
                    ?>

                                        <div class="col-md-3 col-sm-6 col-sm-12 team">
                                                <div class="row">
                                                        <div class="col-xs-12 col-sm-12">
                                                                <p style="margin-top:0.5em;text-align:center;"><img src="core/img/<?= $team; ?>.png" alt="Team <?= $team; ?>" class="img-responsive" style="display:inline-block" width=80> <strong class="total-<?= $team; ?>-js">0</strong> <?= $locales->GYMS; ?></p>

                                <?php
                } else {
                    ?>

                                        <div class="col-md-4 col-sm-6 col-sm-12 team">
                                                <div class="row">
                                                        <div class="col-xs-12 col-sm-12">
                                                                <?php
                                    if ('rocket' != $team) {
                                        ?>
                                                                                <p style="margin-top:0.5em;text-align:center;"><img src="core/img/<?= $team; ?>.png" alt="Team <?= $team; ?>" class="img-responsive" style="display:inline-block" width=80> <strong class="total-<?= $team; ?>-js">0</strong> <?= $locales->GYMS; ?></p>
                                                                                <?php
                                    }
                } ?>
                                                        </div>
                                                </div>
                                        </div>
                                <?php
            } ?>
</div>

<div class="row area big-padding">
	<div class="col-md-12 text-center">
		<h2 class="text-center sub-title">
			<?php
            if ($config->system->recents_filter) {
                ?>
				<?= $locales->RECENT_MYTHIC_SPAWNS; ?>
			<?php
            } else {
                ?>
				<?= $locales->RECENT_SPAWNS; ?>
			<?php
            } ?>
		</h2>
		<div class="last-mon-js">
		<?php
        $timers = array();
        foreach ($recents as $key => $pokemon) {
            $id = $pokemon->id;
            $uid = $pokemon->uid; ?>
			<div class="col-md-1 col-xs-4 pokemon-single" data-pokeid="<?= $id; ?>" data-pokeuid="<?= $uid; ?>" >
				<a href="pokemon/<?= $id; ?>"><img src="<?= $pokemons->pokemon->$id->img; ?>" alt="<?= $pokemons->pokemon->$id->name; ?>" class="img-responsive"></a>
				<a href="pokemon/<?= $id; ?>"><p class="pkmn-name"><?= $pokemons->pokemon->$id->name; ?></p></a>
				<?php
                if ($config->system->recents_encounter_details) {
                    if ($pokemon->encdetails->available) {
                        if ($config->system->iv_numbers) {
                            ?>
							<div class="progress" style="height: 15px; margin-bottom: 0">
								<div title="Attack IV: <?= $pokemon->encdetails->attack; ?>" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->attack; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= (100 / 3); ?>%; line-height: 16px">
									<span class="sr-only"><?= $locales->ATTACK; ?> IV: <?= $pokemon->encdetails->attack; ?></span><?= $pokemon->encdetails->attack; ?>
								</div>
								<div title="Defense IV: <?= $pokemon->encdetails->defense; ?>" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->defense; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= (100 / 3); ?>%; line-height: 16px">
									<span class="sr-only"><?= $locales->DEFENSE; ?> IV: <?= $pokemon->encdetails->defense; ?></span><?= $pokemon->encdetails->defense; ?>
								</div>
								<div title="Stamina IV: <?= $pokemon->encdetails->stamina; ?>" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->stamina; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= (100 / 3); ?>%; line-height: 16px">
									<span class="sr-only"><?= $locales->STAMINA; ?> IV: <?= $pokemon->encdetails->stamina; ?></span><?= $pokemon->encdetails->stamina; ?>
								</div>
							</div>
						<?php
                        } else {
                            ?>
							<div class="progress" style="height: 6px; width: 80%; margin: 5px auto 0 auto;">
								<div title="Attack IV: <?= $pokemon->encdetails->attack; ?>" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->attack; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= ((100 / 15) * $pokemon->encdetails->attack) / 3; ?>%">
									<span class="sr-only"><?= $locales->ATTACK; ?> IV: <?= $pokemon->encdetails->attack; ?></span>
								</div>
								<div title="Defense IV: <?= $pokemon->encdetails->defense; ?>" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->defense; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= ((100 / 15) * $pokemon->encdetails->defense) / 3; ?>%">
									<span class="sr-only"><?= $locales->DEFENSE; ?> IV: <?= $pokemon->encdetails->defense; ?></span>
								</div>
								<div title="Stamina IV: <?= $pokemon->encdetails->stamina; ?>" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->stamina; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= ((100 / 15) * $pokemon->encdetails->stamina) / 3; ?>%">
									<span class="sr-only"><?= $locales->STAMINA; ?> IV: <?= $pokemon->encdetails->stamina; ?></span>
								</div>
							</div>
					<?php
                        } ?>
						<small><?= $pokemon->encdetails->cp; ?></small>
					<?php
                    } else {
                        if ($config->system->iv_numbers) {
                            ?>
							<div class="progress" style="height: 15px; margin-bottom: 0">
								<div title="Attack IV: not available" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->attack; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= (100 / 3); ?>%; line-height: 16px">
									<span class="sr-only"><?= $locales->ATTACK; ?> IV: <?= $locales->NOT_AVAILABLE; ?></span>?
								</div>
								<div title="Defense IV: not available" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->defense; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= (100 / 3); ?>%; line-height: 16px">
									<span class="sr-only"><?= $locales->DEFENSE; ?> IV: <?= $locales->NOT_AVAILABLE; ?></span>?
								</div>
								<div title="Stamina IV: not available" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $pokemon->encdetails->stamina; ?>" aria-valuemin="0" aria-valuemax="45" style="width: <?= (100 / 3); ?>%; line-height: 16px">
									<span class="sr-only"><?= $locales->STAMINA; ?> IV: <?= $locales->NOT_AVAILABLE; ?></span>?
								</div>
							</div>
						<?php
                        } else {
                            ?>
						<div class="progress" style="height: 6px; width: 80%; margin: 5px auto 0 auto;">
							<div title="IV not available" class="progress-bar" role="progressbar" style="width: 100%; background-color: rgb(210,210,210)" aria-valuenow="1" aria-valuemin="0" aria-valuemax="1">
								<span class="sr-only">IV <?= $locales->NOT_AVAILABLE; ?></span>
							</div>
						</div>
					<?php
                        } ?>
						<small>???</small>
					<?php
                    }
                } ?>
				</div>
			<?php
            // Array with ids and countdowns to start at the end of this file
            $timers[$uid] = $pokemon->last_seen - time();
        } ?>
		</div>
	</div>
</div>


<script>
	document.addEventListener('DOMContentLoaded', function() {
		<?php
        foreach (array_reverse($timers, true) as $id => $countdown) {
            ?>
			startTimer(<?= $countdown; ?>,"<?= $id; ?>");
		<?php
        } ?>
	}, false);
</script>
