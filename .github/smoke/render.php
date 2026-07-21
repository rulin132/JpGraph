<?php
/**
 * Smoke test: load JpGraph through the Composer loader and render a basic
 * chart to a PNG. Fails (non-zero exit) if the library can't produce output
 * on the current PHP version. Used by .github/workflows/ci.yml.
 */

error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

require __DIR__ . '/../../lib/JpGraph.php';

use JpGraph\JpGraph;

JpGraph::load();
JpGraph::module('bar');

$data  = [12, 8, 19, 3, 10, 7];
$graph = new \Graph(320, 200);
$graph->SetScale('textlin');

$bar = new \BarPlot($data);
$graph->Add($bar);

$out = sys_get_temp_dir() . '/jpgraph_smoke.png';
$graph->Stroke($out);

if (!is_file($out) || filesize($out) === 0) {
    fwrite(STDERR, "FAIL: no output produced at $out\n");
    exit(1);
}

echo 'OK: rendered ' . filesize($out) . " bytes to $out\n";
