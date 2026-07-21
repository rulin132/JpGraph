<?php
/**
 * Shared bootstrap for the demo chart endpoints.
 *
 * JpGraph streams raw PNG bytes straight to the output buffer, so *any* text
 * emitted before or during rendering (a stray warning, a notice) corrupts the
 * image. The vendored library has been patched for the PHP 8.1+/9 deprecations
 * it used to emit (see jpgraph_compat.inc.php and the PHP 9 section of
 * README.md), so standard rendering is now notice-free. We still mute
 * E_DEPRECATED (and turn off inline error display) as a defensive measure, so
 * that a stray notice from any un-exercised code path can never leak into the
 * image stream.
 *
 * This file itself does NOT modify the vendored library — it only configures
 * error reporting for these example endpoints.
 */

// Keep real errors, drop the strftime()/other deprecation noise from the
// 2021-era library so it never leaks into the PNG byte stream.
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors', '0');

require __DIR__ . '/../lib/JpGraph.php';

/**
 * Load the JpGraph core plus any modules a demo needs.
 *
 * @param string ...$modules e.g. 'bar', 'line', 'pie'
 */
function jpgraph_boot(string ...$modules): void
{
    \JpGraph\JpGraph::load();
    foreach ($modules as $module) {
        \JpGraph\JpGraph::module($module);
    }
}
