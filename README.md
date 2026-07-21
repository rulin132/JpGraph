# JpGraph (Unofficial)

JpGraph is an Object-Oriented graph-creating library for PHP 5 (>=5.1) and PHP 7.0. The library is completely written in PHP and ready to be used in any PHP scripts (both CGI/APXS/CLI versions of PHP are supported).


This is the unofficial loader, originally forked from ztec for Composer, from http://jpgraph.net/. I'll try my best to update this repository as soon as updates come out.


## Version 4.4.3
* Updated to upstream JpGraph 4.4.3 (improved PHP 8 compatibility)
* Re-applied local patches: libgd 2.3 empty-text guards and imageantialias() error suppression

## Version 4.3.5
* Updated to upstream JpGraph 4.3.5 (22 Oct 2021)
* Short-term fix for a bug introduced by libgd 2.3
* Suppress the problematic "missing imageantialias()" error on affected GD builds

## Version 4.3.0
* Support PHP 7.4


This is a port for Composer users to use JpGraph as a vendor library.

Use JpGraph\JpGraph::load(); and JpGraph\JpGraph::module('moduleName'); to load required modules.
