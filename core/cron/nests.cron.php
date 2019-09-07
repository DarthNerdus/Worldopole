<?php

// -----------------------------------------------------------------------------------------------------------
// Nests datas
//
//
// -----------------------------------------------------------------------------------------------------------

$bounds = $manager->getMapsCoords();

$allNestSpawns = array();
$allNestParks = array();

// Get Parks from overpass
$variables = SYS_PATH.'/core/json/osm.json';
$json = json_decode(file_get_contents($variables), true);

$parks = array();
foreach ($json['elements'] as $key => &$element) {
    $tempGeos = array();
    if (isset($element['type']) && 'way' == $element['type'] && isset($element['geometry'])) {
        $tempGeos = array($element['geometry']);
    } elseif (isset($element['type']) && 'relation' == $element['type'] && isset($element['members'])) {
        $outers = array();
        $members = $element['members'];
        foreach ($members as $member) {
            if (isset($member['role']) && 'outer' == $member['role'] && isset($member['geometry'])) {
                $outers[] = $member['geometry'];
            }
        }
        $tempGeos = combineOuter($outers);
    }
    foreach ($tempGeos as $key => $tempGeo) {
        if (!is_null($tempGeo) && 0 != count($tempGeo)) {
            $data = array();
            $geo = array();
            foreach ($tempGeo as $ele) {
                $geo[] = array('lat' => $ele['lat'], 'lng' => $ele['lon']);
            }

                    // Finish poly where we started
            $firstEle = $geo[0];
            $lastEle = $geo[count($geo) - 1];
            if ($firstEle != $lastEle) {
                $geo[] = $firstEle;
            }

            $data['geo'] = $geo;
            if (isset($element['tags']) && isset($element['tags']['name'])) {
                $data['name'] = $element['tags']['name'];
            } else {
                $data['name'] = null;
            }
            $data['id'] = $element['id'];
            $data['bounds'] = $element['bounds'];
            $parks[] = $data;
        }
    }
    unset($json[$key]);
}

// Checking Parks for for PMSF matches
$nests = $manager->getPMSFNests();
foreach ($parks as $key => &$park) {
	$nestKey = null;
        foreach ($nests as $key => $nest) {
		if ($nest->nest_id == $park['id']) {
			$nestKey = $key;
        	}
	}


     if(!is_null($nestKey)) {
     $nest = $nests[$nestKey]; 
     $park['pid'] = $nest->pokemon_id;
     $park['count'] = (int) $nest->pokemon_avg;

     $allNestParks[] = $park;
}

     unset($parks[$key]);
 }

foreach ($allNestParks as $keyA => $parkA) {                                                                   
    foreach ($allNestParks as $keyB => $parkB) {                                                               
        if ($keyA != $keyB && $parkA['pid'] == $parkB['pid']) {                                                
            if (polyIsInsidePolygon($parkA['geo'], $parkA['bounds'], $parkB['geo'], $parkB['bounds'])) {       
                unset($allNestParks[$keyA]);                                                                   
            } elseif (polyIsInsidePolygon($parkB['geo'], $parkB['bounds'], $parkA['geo'], $parkA['bounds'])) { 
                unset($allNestParks[$keyB]);                                                                   
            }                                                                                                  
	}
    }
}

// Write files
file_put_contents($nests_parks_file, json_encode(array_values($allNestParks)));
