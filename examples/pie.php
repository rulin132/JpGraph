<?php
/**
 * Demo endpoint: pie chart. Streams an image/png response.
 */
require __DIR__ . '/_bootstrap.php';
jpgraph_boot('pie');

$data   = [35, 25, 20, 12, 8];
$labels = ['Chrome', 'Safari', 'Firefox', 'Edge', 'Other'];

$graph = new PieGraph(460, 340);
$graph->title->Set('Browser share');
// Legend along the bottom so it never overlaps the pie.
$graph->legend->SetPos(0.5, 0.97, 'center', 'bottom');
$graph->legend->SetColumns(5);

$pie = new PiePlot($data);
$pie->SetLegends($labels);
$pie->SetCenter(0.5, 0.5);
$pie->SetSize(0.32);
$pie->SetLabelType(PIE_VALUE_PER);
$pie->value->Show();
$pie->value->SetFormat('%d%%');
$graph->Add($pie);

$graph->Stroke();
