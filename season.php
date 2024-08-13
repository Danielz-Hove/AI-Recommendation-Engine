<?php
function get_season($month) {
    // Convert month number to lowercase string for comparison
    $month = strtolower($month);

    // Define the seasons and their corresponding months
    $seasons = array(
        'Spring' => array('march', 'april', 'may'),
        'Summer' => array('june', 'july', 'august'),
        'Autumn' => array('september', 'october', 'november'),
        'Winter' => array('december', 'january', 'february')
    );

    // Loop through the seasons to find the current season
    foreach ($seasons as $season => $months) {
        if (in_array($month, $months)) {
            return $season;
        }
    }

    // If the month doesn't match any season, return unknown
    return 'unknown';
}
?>
