<?php
/**
 * Demo endpoint: line chart with two series. Streams an image/png response.
 */
require __DIR__ . '/_bootstrap.php';
jpgraph_boot('line');

$thisYear = [3, 5, 8, 6, 9, 13, 18, 16, 20, 24, 22, 27];
$lastYear = [2, 4, 5, 7, 6, 9, 12, 14, 13, 17, 19, 21];
$months   = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

$graph = new Graph(560, 320);
$graph->SetScale('textlin');
$graph->SetMargin(50, 30, 45, 45);
$graph->title->Set('Monthly active users');
$graph->xaxis->SetTickLabels($months);
$graph->yaxis->title->Set('thousands');
$graph->legend->SetPos(0.03, 0.06, 'right', 'top');

$l1 = new LinePlot($thisYear);
$l1->SetColor('firebrick');
$l1->SetWeight(2);
$l1->mark->SetType(MARK_FILLEDCIRCLE);
$l1->mark->SetFillColor('firebrick');
$l1->mark->SetSize(3);
$l1->SetLegend('This year');
$graph->Add($l1);

$l2 = new LinePlot($lastYear);
$l2->SetColor('gray');
$l2->SetWeight(1);
$l2->SetStyle('dashed');
$l2->SetLegend('Last year');
$graph->Add($l2);

$graph->Stroke();
