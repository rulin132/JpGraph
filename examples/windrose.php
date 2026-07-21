<?php
/**
 * Demo endpoint: wind rose. Streams an image/png response.
 *
 * Data is wind-frequency (%) per compass direction. In each direction the
 * first value is the "calm" share (drawn as the centre circle) and the rest
 * are the speed-range buckets; the values must sum to <= 100% over the whole
 * plot. Direction keys are compass labels.
 */
require __DIR__ . '/_bootstrap.php';
jpgraph_boot('windrose');

//              calm  0-5   5-10  10-15
$data = [
    'n'  => [1.5, 1.0, 0.8, 0.4],
    'ne' => [1.0, 0.8, 0.5, 0.3],
    'e'  => [1.2, 1.5, 0.9, 0.4],
    'se' => [1.0, 1.2, 0.8, 0.3],
    's'  => [2.0, 2.5, 1.5, 0.5],
    'sw' => [3.0, 4.0, 3.5, 2.0],
    'w'  => [4.0, 4.5, 3.5, 2.0],
    'nw' => [2.5, 3.0, 2.0, 1.0],
];

$graph = new WindroseGraph(500, 400);
$graph->title->Set('Wind rose — frequency by direction');
$graph->title->SetFont(FF_DV_SANSSERIF, FS_BOLD, 12);

$wp = new WindrosePlot($data);
$wp->SetType(WINDROSE_TYPE8);
$wp->SetFontColor('darkgray');
// Speed ranges (knots) -> legend labels + colours (3 ranges after the calm centre).
$wp->SetRanges([0, 5, 10, 15]);
$wp->SetRangeColors(['#4575b4', '#91bfdb', '#fdae61']);
$graph->Add($wp);

$graph->Stroke();
