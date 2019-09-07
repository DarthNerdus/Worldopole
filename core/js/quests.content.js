var dustCount = 0;
var itemCount = 0;
var monCount = 0;
var stopCount = 0;

$(function() {
	$.getJSON('core/json/variables.json', function(variables) {
		var pokeimg_suffix = variables['system']['pokeimg_suffix'];
		var location_url = variables['system']['location_url'] || 'https://maps.google.com/?q={latitude},{longitude}&ll={latitude},{longitude}&z=16';
		$('.raidsLoader').hide();
		loadRaids(pokeimg_suffix, location_url);
	});
});

function updateCounter(new_value, classname) {
        var CurrentValue = $(classname).text();
        $({ someValue: CurrentValue }).animate({ someValue: new_value }, {
                duration: 3000,
                easing: 'swing',
                step: function() {
                        $(classname).text(Math.round(this.someValue));
                }
        });
}

function loadRaids(pokeimg_suffix, location_url) {
	$('.raidsLoader').show();
	$.ajax({
		'type': 'GET',
		'dataType': 'json',
		'url': 'core/process/aru.php',
		'data': {
			'type': 'quests'
		}
	}).done(function(data) {
		var internalIndex = 0;
		if (data.raids.length === 0) {
			var raidInfos = $('<tr>');
			raidInfos.append($('<td>', { colspan: 6, text: data.locale.noraids })).css('text-align', 'center');
			$('#raidsContainer').append(raidInfos);
		}
		$.each(data.raids, function(gym_id, raid) {
			internalIndex++;
			printRaid(raid, pokeimg_suffix, location_url);
		});
	}).fail(function() {
		var raidInfos = $('<tr>');
		raidInfos.append($('<td>', { colspan: 6, text: 'ERROR' })).css('text-align', 'center');
		$('#raidsContainer').append(raidInfos);
	}).always(function() {
		$('.raidsLoader').hide();
		updateCounter(dustCount, '#dustCount');
		updateCounter(itemCount, '#itemCount');
		updateCounter(monCount, '#monCount');
		updateCounter(stopCount, '#stopCount');
  $("#questSearch").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#raidsTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
	});
};

function printRaid(raid, pokeimg_suffix, location_url) {
	stopCount++;
	var now = new Date();

	var raidInfos = $('<tr>', { id: 'raidInfos_' + raid.pokestop_id });

	raidInfos.append($('<td>', { id: 'raidLevel_' + raid.pokestop_id}).css("vertical-align", "middle").append($('<img />', { class: 'pokestopimg', src: raid.url } )));
	var locationLink = location_url.replace(/\{latitude\}/g, raid.latitude).replace(/\{longitude\}/g, raid.longitude)
	raidInfos.append($('<td>', { id: 'raidGym_' + raid.pokestop_id }).css("vertical-align", "middle").append($('<a>', { href: locationLink, text: raid.name })));
	// Append pokemon now (handle other quests soon)
	var raidReward = $('<div>', { class: 'pokemon-single' }).css("text-align", "center").css("vertical-align", "middle");
	if (raid.quest_reward_type == "Pokemon") {
			monCount++;
			raidReward.append(
				$('<a>', { href: 'pokemon/' + parseInt(raid.pokemon_id,10) }).append($('<img />', { src: 'core/pokemons/' + parseInt(raid.pokemon_id, 10) + pokeimg_suffix }))
			);
			raidReward.append($('<div>', { text: raid.pokemon_name } ));
	} else if (raid.quest_reward_type == "Item") {
		itemCount += raid.item_amount;
		raidReward.append($('<img />', { src: 'core/img/quest/reward_' + raid.item_id + '_1.png' }));
		raidReward.append($('<div>', { text: raid.item_amount + ' ' + raid.item_type }));
	} else if (raid.quest_reward_type == "Stardust") {
		dustCount += raid.item_amount;
		raidReward.append($('<img />', { src: 'core/img/quest/reward_stardust.png' }));
		raidReward.append($('<div>', { text: raid.item_amount + ' Stardust' }));
	} else {
		raidReward.append($('<span>', { text: raid.quest_reward_type }));
	}
	raidInfos.append($('<td>', { id: 'raidBoss_' + raid.pokestop_id }).css("vertical-align", "middle").append(raidReward));
	raidInfos.append($('<td>', { id: 'raidRemaining_' + raid.pokestop_id, text: raid.quest_task }).css("vertical-align", "middle"));



	$('#raidsContainer').append(raidInfos);
}
