<header id="single-header">
<div class="row">
	<div class="col-md-12 text-center">
		<h1>
			Get out in the <strong>Field</strong><br />
			<small>Find the best rewards from Field Research</small>
		</h1>
	</div>
</div>
<style>
    .pokestopimg {
        border: 3px solid #36c6ff;
        width: 70px;
        height: 70px;
        background-size: cover;
        display: block;
        border-radius: 50px;
        margin: auto;
    }
</style>
</header>


<div class="row area">

                <div class="col-md-3 col-sm-3 col-xs-12 big-data" style="border-right:1px lightgray solid;"> <!-- STOPCOUNT -->
                <img src="core/img/stop.png" alt="Pokestop" width=50 class="big-icon">
                <p><big><strong><span id="stopCount"></span></strong> Pokéstops</big><br /> to spin</p>
	        </div>

                <div class="col-md-3 col-sm-3 col-xs-12 big-data" style="border-right:1px lightgray solid;"> <!-- STARDUST -->
                <img src="core/img/quest/reward_stardust.png" alt="Stardust" width=50 class="big-icon">
                <p><big><strong><span id="dustCount"></span></strong> Stardust</big><br /> to collect</p>
	        </div>

                <div class="col-md-3 col-sm-3 col-xs-12 big-data" style="border-right:1px lightgray solid;"> <!-- ITEMS -->
                <img src="core/img/quest/reward_1301_1.png" alt="Items" width=50 class="big-icon">
                        <p><big><strong><span id="itemCount"></span></strong> Items</big><br /> to acquire</p>
                </div>

                <div class="col-md-3 col-sm-3 col-xs-12 big-data"> <!-- Pokemon -->
                <img src="core/img/quest/reward_1_1.png" alt="Team Rocket Invasions" width=50 class="big-icon">
                        <p><big><strong><span id="monCount"></span></strong> Pokémon</big><br /> to catch</p>
                </div>
</div>

<div class="col-md-12" style="padding-bottom: 3em;">
		<div class="search form-group">
			<input id="questSearch" type="search" class="form-control" placeholder="Search stops, objectives, and rewards" required="">
		</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">

			<table class="table" id="raidsTable">
				<thead>
				<tr>
					<th style="width:100px;">Pokestop</th>
					<th></th>
					<th>Reward</th>
					<th>Quest</th>
				</tr>
				</thead>
				<tbody id="raidsContainer">

				</tbody>
				<tfoot>
					<tr class="loadMore text-center">
						<td colspan="6"><button id="loadMoreButton" class="btn btn-default hidden"><?= $locales->RAIDS_LOAD_MORE; ?></button></td>
					</tr>
					<tr class="raidsLoader">
						<td colspan="6"><div class="loader"></div></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>

