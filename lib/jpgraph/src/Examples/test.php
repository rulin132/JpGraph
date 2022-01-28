<?php

require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_bar.php');

function graficaBarra($tipoResultado,$cantFem,$cantMasc){
    $data1y=$cantMasc;
    $data2y=$cantFem;
    $maximo = max(max($data1y,$data2y))+10;
    $graph = new Graph(650, 305, "auto");
    $graph->SetScale("textlin");
    $graph->ClearTheme();
//    $graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,9);
//    $graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,9);
    $graph->xgrid->Show();

    /*$graph->subtitle->SetFont(FF_ARIAL,FS_NORMAL,10);
    $graph->subtitle->SetColor('blue');
    $graph->subtitle->Set('"tiutlo"');*/
    /*$theme_class= new VividTheme;
    $graph->SetTheme($theme_class);*/

    $graph->ygrid->SetFill(false);
    $graph->xaxis->SetTickLabels($tipoResultado);
//    $graph->xaxis->SetFont(FF_ARIAL, FS_BOLD, 10);
    $graph->yaxis->HideLine(false);
    $graph->yaxis->HideTicks(false,false);
    $graph->yaxis->scale->SetAutoMax($maximo);
    $graph->SetBox(false);
    $b1plot = new BarPlot($data1y);
    $b1plot->SetLegend("Masculino");
$b1plot->SetValuePos("top");
    $b1plot->value->Show();
//$b1plot->value->SetFont(FF_ARIAL, FS_BOLD, 13);
    $b1plot->SetCenter(0.4);

    $b2plot = new BarPlot($data2y);//var_dump($b2plot);exit;
    $b2plot->SetLegend("Femenino");
    $b2plot->SetValuePos("center");
//    $b2plot->value->SetFont(FF_ARIAL, FS_BOLD, 13);
    $b2plot->value->SetFormat('%d');
    $b2plot->value->Show();

    $gbplot = new GroupBarPlot(array($b1plot,$b2plot));
    $gbplot->plots[0]->SetValuePos("top");
    $gbplot->plots[0]->value->Show(true);
    $graph->Add($gbplot);
    $graph->legend->Pos(0.5, 0.99, 'center', 'bottom');
//    $graph->legend->SetFont(FF_ARIAL, FS_BOLD, 11);
    $graph->Stroke();
}

graficaBarra(['a', 'b', 'c'], [10, 20, 30], [30, 20, 10]);
