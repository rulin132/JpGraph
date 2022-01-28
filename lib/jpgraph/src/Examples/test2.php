<?php // content="text/plain; charset=utf-8"
require_once ("jpgraph/jpgraph.php");
require_once ("jpgraph/jpgraph_line.php");
require_once ("jpgraph/jpgraph_odo.php");


function draw_gauge()
{
    $graph = new OdoGraph(250,150);
    $graph->SetColor("black");
    $graph->SetMargin(0,0,0,0);
    $graph->SetFrame(false);

    $odo = new Odometer(ODO_HALF);
    $odo->scale->Set(0,0.6);
    $odo->scale->SetTicks(0.1);
    $odo->scale->SetLabelFormat('%.01f');
    $odo->AddIndication(0,.1,"green:0.9");
    $odo->AddIndication(.1,.2,"green:0.7");
    $odo->AddIndication(.2,.4,"yellow");
    $odo->AddIndication(.4,.6,"red");
    $odo->SetCenterAreaWidth(0.4); //Area around needle
    $odo->SetColor("black");
    $odo->SetBorder("black",1);
    $odo->SetPos(0.5,0.1); //Center meter in image

// Set display value for the odometer
    $odo->needle->Set(1.5);

    $odo->needle->SetFillColor("white");
    $odo->SetBase(true,0.,"black","black","yellow");
    $graph->Add($odo);

// $graph->Stroke();

    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);
    $contentType = 'image/png';
    ob_start();
    imagepng($gdImgHandler);
    $image_data = ob_get_contents();
    ob_end_clean();
    echo '<img src="'."data:$contentType;base64,".base64_encode($image_data).'">';
}

function draw_graph($ydata, $machine_name, $linecolor, $avgcycles)
{

    $graph = new Graph(600,120);
    $graph->clearTheme();

    $graph->SetColor('black');
    $graph->SetScale('textlin');
    $graph->SetMargin(55,20,30,30);
    $graph->SetMarginColor('black');

//$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,9);
    $graph->xaxis->SetColor('black','white');
    $graph->xaxis->title->SetColor('white');
    $graph->xaxis->SetTitle('Last 50 Cycles','center');
    $graph->xaxis->SetTitleMargin(10);
    $graph->xaxis->setTextTickInterval(2);

// $graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,9);
    $graph->yaxis->SetColor('black','white');
    $graph->yaxis->SetTitleMargin(45);
    $graph->yaxis->SetColor('black','white');
    $graph->yaxis->title->SetColor('white');
    $graph->yaxis->SetTitle('Seconds','center');

// $graph->title->SetFont(FF_FONT1,FS_NORMAL,10);
    $graph->title->SetColor('white');
    $graph->title->Set($machine_name);
// $graph->subtitle->SetFont(FF_FONT1,FS_NORMAL,8);
    $graph->subtitle->Set("AVG Cycles: ".$avgcycles);
    $graph->subtitle->SetColor('white');

// $graph->img->SetImgFormat('png');
// $graph->img->SetQuality(100);

    $lineplot=new LinePlot($ydata);
    $graph->Add($lineplot);
    $lineplot->SetColor($linecolor);
    $lineplot->SetWeight(2);
// $lineplot->SetFillGradient('white','darkgreen');

// $graph->Stroke();

    $gdImgHandler = $graph->Stroke(_IMG_HANDLER);
    $contentType = 'image/png';
    ob_start();
    imagepng($gdImgHandler);
    $image_data = ob_get_contents();
    ob_end_clean();
    echo '<img src="'."data:$contentType;base64,".base64_encode($image_data).'">';
}

draw_gauge();
//draw_graph([1,2,3,4,5], 'test', '#000', 'avg');