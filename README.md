# JpGraph (Unoffical)

JpGraph is an Object-Oriented Graph creating library for PHP5 (>=5.1) and PHP7.0 The library is completely written in PHP and ready to be used in any PHP scripts (both CGI/APXS/CLI versions of PHP are supported).


This is the unoffical loader originally forked from ztec for composer from http://jpgraph.net/, I'll try my best to update this repository as soon as updates come out.


## Version 4.3.5
* Updated to upstream JpGraph 4.3.5 (22 Oct 2021)
* Short-term fix for a bug introduced by libgd 2.3
* Suppress the problematic "missing imageantialias()" error on affected GD builds

## Version 4.3.0
* Support PHP 7.4


This is a port for Composer users to use JpGraph as a Vendor library

use JpGraph\JpGraph::load(); and JpGraph\JpGraph::module('moduleName'); to load required modules

