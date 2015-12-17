<?php

function packageSegmentAttributesForSavingAndSorting($segment_times, $names, $authors, $albums, $categories, $can_con,
                                                     $new_release, $french_vocal_music) {

    $segmentCount = count($segment_times);
    $segments = array();

    for ($i = 0; $i < $segmentCount; $i++) {
        $segments[$i] = array('start_time' => $segment_times[$i], 'name' => $names[$i], 'author' => $authors[$i], 'album' => $albums[$i], 'category' => $categories[$i],
            'can_con' => isset($can_con[$i]), 'new_release' => isset($new_release[$i]), 'french_vocal_music' => isset($french_vocal_music[$i]));
    }

    usort($segments, function ($a, $b) {
        return strtotime($a['start_time']) > strtotime($b['start_time']);
    });

    return $segments;
}

function computeSegmentDurations($segments, $end_time) {
    $segmentStartTimeCount = count($segments);

    for ($i = 0; $i < $segmentStartTimeCount; $i++) {
        if ($i < ($segmentStartTimeCount - 1)) {
            $duration = date_diff(new DateTime($segments[$i+1]['start_time']), new DateTime($segments[$i]['start_time']));
        } else {
            $duration = date_diff(new DateTime($end_time), new DateTime($segments[$i]['start_time']));
        }

        $segments[$i]['duration'] = $duration->format('%H:%i:%s');
    }

    return $segments;
}