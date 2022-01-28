<?php // content="text/plain; charset=utf-8"
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
//require_once ('jpgraph/jpgraph_regstat.php');

error_reporting(E_ALL);
ini_set("display_errors", 1);

$graph = new Graph(1168,170);
$graph->SetMargin(60,20,20,50);
$graph->SetScale('textlin');

$ydata = array(0=> 95.5, 1 => 94.32);

$line = new LinePlot($ydata);
$graph->Add($line);

$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
$graph->xaxis->HideTicks(false,false);
$graph->xaxis->SetTextTickInterval(5,4);
$line->SetLegend('Yield % By Distillation');

$graph->yaxis->title->Set('Yield %');
$graph->yaxis->SetTitleMargin(40);
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");

$graph->Stroke();

?>
