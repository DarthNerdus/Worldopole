<?php

// This file only include other files to have only 1 entry in your crontabs.
// ------------------------------------------------------------------------

$config_file = dirname(__FILE__).'/../../config.php';

include_once $config_file;

// Load functions
include_once SYS_PATH.'/functions.php';

// Load timezone
include_once SYS_PATH.'/core/process/timezone.loader.php';

// Load variables.json
$variables = SYS_PATH.'/core/json/variables.json';
$config = json_decode(file_get_contents($variables));
// force english language for all cron stuff
$config->system->forced_lang = 'en';

// Manage Time Interval
// #####################

include_once SYS_PATH.'/core/process/timezone.loader.php';

// Load Query Manager
// ###################

include_once __DIR__.'/../process/queries/QueryManager.php';
$manager = \Worldopole\QueryManager::current();

// Update dashboard data
// the following files are updated every run
$gym_file = SYS_PATH.'/core/json/gym.stats.json';
$pokestop_file = SYS_PATH.'/core/json/pokestop.stats.json';
$pokemonstats_file = SYS_PATH.'/core/json/pokemon.stats.json';

if (is_file($gym_file)) {
    $gymsdatas = json_decode(file_get_contents($gym_file), true);
}
if (is_file($pokestop_file)) {
    $stopdatas = json_decode(file_get_contents($pokestop_file), true);
}
if (is_file($pokemonstats_file)) {
    $pokedatas = json_decode(file_get_contents($pokemonstats_file), true);
}

$timestamp = time();
$timestamp_lastweek = $timestamp - 604800;

// Trim all json stats files to last 7 days of data
$gymsdatas = trim_stats_json($gymsdatas, $timestamp_lastweek);
$stopdatas = trim_stats_json($stopdatas, $timestamp_lastweek);
$pokedatas = trim_stats_json($pokedatas, $timestamp_lastweek);

// Update json stats files
include_once SYS_PATH.'/core/cron/gym.cron.php';
include_once SYS_PATH.'/core/cron/pokemon.cron.php';
include_once SYS_PATH.'/core/cron/pokestop.cron.php';
if ($config->system->captcha_support) {
    include_once SYS_PATH.'/core/cron/captcha.cron.php';
}

// The following files are updated every 24h only because the queries are quite expensive
// and they don't need a fast update interval
$pokedex_rarity_file = SYS_PATH.'/core/json/pokedex.rarity.json';
$nests_parks_file = SYS_PATH.'/core/json/nests.parks.json';

$migration = new DateTime();
$migration->setTimezone(new DateTimeZone('UTC'));
$migration->setTimestamp(1493856000);
do {
    $migrationPrev = clone $migration;
    $migration->modify('+14 days');
} while ($migration < new DateTime());
$migration = $migrationPrev->getTimestamp();

// Do not update both files at the same time to lower cpu load
if (file_update_ago($pokedex_rarity_file) > 86400) {
    // set file mtime to now before executing long running queries
    // so we don't try to update the file twice
    touch($pokedex_rarity_file);
    // update pokedex rarity
    include_once SYS_PATH.'/core/cron/pokedex_rarity.cron.php';
} 

include_once SYS_PATH.'/core/cron/nests.cron.php';
