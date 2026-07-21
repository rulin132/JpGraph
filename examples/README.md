# JpGraph demo gallery

A tiny, self-contained way to **spin up** this library and see it render real
charts. Each endpoint uses the Composer loader in `lib/JpGraph.php` and streams
a PNG generated on request.

## Requirements

- PHP with the **GD** extension (`php -m | grep gd`)
- No Composer install needed — the loader and library are vendored in `lib/`

Tested on PHP 8.4. JpGraph 4.4.3 already handles the PHP 8.1+/9 deprecations on
the standard rendering paths, and this branch closes the remaining gaps (see the
PHP 9 note below). `_bootstrap.php` still mutes `E_DEPRECATED` for these
endpoints as a defensive measure, so a stray notice can never leak into the PNG
byte stream.

## Run it

From the repository root:

```bash
php -S localhost:8000 -t examples
```

Then open <http://localhost:8000/> for the gallery, or hit an endpoint directly:

- <http://localhost:8000/bar.php> — bar chart
- <http://localhost:8000/line.php> — two-series line chart
- <http://localhost:8000/pie.php> — pie chart
- <http://localhost:8000/windrose.php> — wind rose

## Files

| File              | What it does                                            |
| ----------------- | ------------------------------------------------------- |
| `index.php`       | HTML gallery that embeds the chart endpoints            |
| `_bootstrap.php`  | Shared loader + deprecation muting (`jpgraph_boot()`)   |
| `bar.php`         | Bar chart endpoint                                      |
| `line.php`        | Line chart endpoint (two series, legend, markers)       |
| `pie.php`         | Pie chart endpoint (percent labels, legend)             |
| `windrose.php`    | Wind rose endpoint (compass directions, speed ranges)   |

## Using the library in your own code

```php
require 'lib/JpGraph.php';

JpGraph\JpGraph::load();        // core
JpGraph\JpGraph::module('bar'); // any module in lib/jpgraph/src/jpgraph_<name>.php

$graph = new Graph(400, 300);
$graph->SetScale('textlin');
$graph->Add(new BarPlot([1, 2, 3, 4]));
$graph->Stroke();               // streams image/png, or pass a path to save
```

## PHP 9 compatibility

The bundled **JpGraph 4.4.3** already resolves the main PHP 8.1+/9 changes on the
standard rendering paths: `strftime()` has been replaced, `imagefilledpolygon()`
is version-guarded via `CheckPHPVersion()`, and computed `float`→`int`
coordinates and dynamic properties are handled. Rendering ~20 chart types under
`error_reporting(E_ALL)` on PHP 8.4 produces **zero** deprecation notices.

This branch closes the remaining removed-function gap, in `LanguageConv`
(`jpgraph_ttf.inc.php`) — the character-encoding paths that still call functions
PHP has removed:

| Removed function | Replacement | Path |
| --- | --- | --- |
| `utf8_encode()` (removed in PHP 9.0) | guarded `mb_convert_encoding` / `iconv`, with a manual Latin-1 fallback | Hebrew text |
| `convert_cyr_string()` (removed in PHP 8.0) | guarded `mb_convert_encoding` / `iconv` | Cyrillic text |

These reuse the guarded-`mb_convert_encoding` idiom the class already applies to
its EUC-JP handling, so behaviour is unchanged where the extensions are present.

**Caveat:** full PHP 9 cleanliness of *every* code branch can't be proven
without a PHP 9 runtime, but all standard plot types — Windrose included — are
verified clean on PHP 8.4.

## Windrose

`WindroseGraph` `require_once`'d `jpgraph_glayout_vh.inc.php`, which was missing
from this fork, so *any* windrose script fatally errored at include time. That
file has been restored (`lib/jpgraph/src/jpgraph_glayout_vh.inc.php`): a
composite layout tree (`LayoutRect` base, with `LayoutHor`/`LayoutVert`) that
arranges several windrose plots in one graph, matching the interface
`jpgraph_windrose.php` expects (`WindroseGraph::Add()` accepts these alongside a
`WindrosePlot`, and each exposes `LayoutSize()`/`SetPos()`/`Stroke()`). Single
plots and the multi-plot `LayoutVert([LayoutHor(...), LayoutHor(...)])` form
both render correctly.

Fonts: upstream windrose hardcoded the MS TrueType fonts (Verdana/Arial), which
aren't present on most systems, so it failed with a "font not readable" error
out of the box. Its font defaults now use the bundled DejaVu font
(`FF_DV_SANSSERIF`, which ships under `lib/jpgraph/src/fonts/`), so windrose
renders with no font setup at all. Call `SetFont()` (on the plot, its `scale`,
and the legend) to use a different font if you have one installed.
