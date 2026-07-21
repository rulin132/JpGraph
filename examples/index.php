<?php
/**
 * Demo gallery landing page. Each <img> points at a chart endpoint that
 * streams a freshly-rendered PNG from JpGraph.
 */
$version = trim(str_replace('Version:', '', @file_get_contents(__DIR__ . '/../lib/jpgraph/VERSION')));
$charts = [
    'bar.php'      => 'Bar chart',
    'line.php'     => 'Line chart (two series)',
    'pie.php'      => 'Pie chart',
    'windrose.php' => 'Wind rose',
];
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>JpGraph demo gallery</title>
<style>
  :root { color-scheme: light dark; }
  body { font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
         margin: 0; padding: 2rem; line-height: 1.5; }
  header { max-width: 900px; margin: 0 auto 1.5rem; }
  h1 { margin: 0 0 .25rem; font-size: 1.6rem; }
  .sub { opacity: .7; font-size: .95rem; }
  .grid { max-width: 900px; margin: 0 auto; display: grid;
          grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem; }
  figure { margin: 0; border: 1px solid rgba(128,128,128,.3);
           border-radius: 10px; overflow: hidden; }
  figure img { display: block; width: 100%; height: auto; background: #fff; }
  figcaption { padding: .6rem .8rem; font-size: .9rem;
               border-top: 1px solid rgba(128,128,128,.25); }
  figcaption a { text-decoration: none; opacity: .6; float: right; }
  code { background: rgba(128,128,128,.15); padding: .1rem .35rem; border-radius: 4px; }
</style>
</head>
<body>
<header>
  <h1>JpGraph demo gallery</h1>
  <p class="sub">Live charts rendered by JpGraph <?= htmlspecialchars($version) ?: 'library' ?>
     on PHP <?= PHP_VERSION ?>. Each image is generated on request.</p>
</header>
<div class="grid">
<?php foreach ($charts as $file => $title): ?>
  <figure>
    <img src="<?= htmlspecialchars($file) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
    <figcaption><?= htmlspecialchars($title) ?>
      <a href="<?= htmlspecialchars($file) ?>" title="Open raw PNG">PNG&nbsp;&rarr;</a>
    </figcaption>
  </figure>
<?php endforeach; ?>
</div>
</body>
</html>
