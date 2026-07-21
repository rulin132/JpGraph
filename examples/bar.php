<?php
/**
 * Demo endpoint: bar chart. Streams an image/png response.
 * Serve the gallery and open /bar.php to view it.
 */
require __DIR__ . '/_bootstrap.php';
jpgraph_boot('bar');

$data = [12, 19, 8, 24, 15, 30, 21];

$graph = new Graph(500, 320);
$graph->SetScale('textlin');
$graph->SetMargin(45, 25, 45, 40);
$graph->title->Set('Weekly signups');
$graph->subtitle->Set('JpGraph ' . trim(str_replace('Version:', '', @file_get_contents(__DIR__ . '/../lib/jpgraph/VERSION'))));
$graph->xaxis->SetTickLabels(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']);
$graph->yaxis->title->Set('# signups');

$bar = new BarPlot($data);
$bar->SetFillColor('steelblue');
$bar->SetColor('steelblue');
$bar->SetWidth(0.6);
$bar->value->Show();
$graph->Add($bar);

$graph->Stroke();
