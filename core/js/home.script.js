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

(function cron() {
	$.ajax({
		url: 'core/process/aru.php?type=home_update',
		success: function(data) {
			var pokemon = data[0];
			var lure = data[1];
			var raids = data[2];
			var gym = data[3];
			var red = data[4];
			var blue = data[5];
			var yellow = data[6];
			var neutral = data[7];

			updateCounter(pokemon, '.total-pkm-js');
			updateCounter(lure, '.total-lure-js');
			updateCounter(gym, '.total-gym-js');
			updateCounter(raids, '.total-raids-js');
			updateCounter(red, '.total-valor-js');
			updateCounter(blue, '.total-mystic-js');
			updateCounter(yellow, '.total-instinct-js');
			updateCounter(neutral, '.total-rocket-js');
		},
		complete: function() {
			// Schedule the next request when the current one's complete
			setTimeout(cron, 5000);
		}
	});
})();



(function spawn() {
	var last_uid = $('.last-mon-js div:first-child').attr('data-pokeuid');

	$.ajax({
		url: 'core/process/aru.php?type=spawnlist_update&last_uid=' + last_uid,
		success: function(data) {
			if (!$.isEmptyObject(data)) {
				$(data).each(function(index, element) {
					$('.last-mon-js').prepend(element.html);
					// stop timer of last child
					stopTimer();
					// replace child
					$('.last-mon-js > div:last-child').fadeOut();
					$('.last-mon-js > div:first-child').fadeIn();
					$('.last-mon-js > div:last-child').remove();

					// start timer for new child
					startTimer(element.countdown, element.pokemon_uid);
				});
			}
		},
		complete: function() {
			// Schedule the next request when the current one's complete
			setTimeout(spawn, 5000);
		}
	});
})();

// Array with timer IDs
var timers = [];

function startTimer(duration, element) {
}

function stopTimer() {
}

function formatDuration(remainingTime) {
	var countdown = remainingTime, hours, minutes, seconds;
	hours = Math.abs(parseInt(countdown / 3600, 10));
	minutes = Math.abs(parseInt((countdown / 60) % 60, 10));
	seconds = Math.abs(parseInt(countdown % 60, 10));

	hours = hours < 10 ? '0' + hours : hours;
	minutes = minutes < 10 ? '0' + minutes : minutes;
	seconds = seconds < 10 ? '0' + seconds : seconds;

	var output = (countdown < 0 ? '- ' : '') + hours + ':' + minutes + ':' + seconds;
	return output;
}
