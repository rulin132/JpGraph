<?php
//=======================================================================
// File:        JPGRAPH_GLAYOUT_VH.INC.PHP
// Description: Vertical / horizontal composite layout helpers used to
//              arrange several sub-plots inside a single graph.
//
//              jpgraph_windrose.php require_once's this file and, in
//              WindroseGraph::Add(), accepts LayoutRect / LayoutHor /
//              LayoutVert alongside a plain WindrosePlot. The graph then
//              calls $obj->Stroke($graph) on whatever was added.
//
//              The layout is a composite tree: a WindrosePlot is a "leaf"
//              (its LayoutSize() returns 1) and LayoutHor / LayoutVert are
//              container nodes that split a rectangular region of the image
//              among their children -- horizontally or vertically,
//              proportional to each child's LayoutSize() -- and then stroke
//              them. Children only need the small layout protocol:
//              LayoutSize(), SetPos($x,$y) and Stroke($graph); nested
//              layouts additionally accept SetRegion().
//
//              Regions and positions are expressed as fractions (0..1) of
//              the image, which is exactly what WindrosePlot::Stroke()
//              expects for its centre (iX,iY) coordinates.
//========================================================================

class LayoutRect {
    protected $iObj;                                 // child nodes (plots or nested layouts)
    protected $iX = 0.0, $iY = 0.0, $iW = 1.0, $iH = 1.0; // region, as fractions of the image
    protected $iTitleInset = true;                   // reserve top space for the graph title

    function __construct($aObjArray) {
        if( ! is_array($aObjArray) ) {
            $aObjArray = array($aObjArray);
        }
        $this->iObj = array_values($aObjArray);
    }

    // Total number of leaf plots in this subtree. A parent layout uses this
    // to proportion the space handed to each child along its own axis.
    function LayoutSize() {
        $s = 0;
        foreach( $this->iObj as $o ) {
            $s += $o->LayoutSize();
        }
        return $s > 0 ? $s : 1;
    }

    // Assign the rectangular region (image fractions) this node may use.
    // Called by a parent layout before Stroke().
    function SetRegion($aX, $aY, $aW, $aH) {
        $this->iX = $aX; $this->iY = $aY;
        $this->iW = $aW; $this->iH = $aH;
        $this->iTitleInset = false; // a nested node inherits an already-inset region
    }

    // Position (and stroke) a single child inside the given sub-region.
    // Nested layouts receive the region; leaf plots receive their centre.
    protected function _strokeChild($aChild, $aGraph, $x, $y, $w, $h) {
        if( $aChild instanceof LayoutRect ) {
            $aChild->SetRegion($x, $y, $w, $h);
            $aChild->Stroke($aGraph);
        }
        else {
            // Leaf plot: centre it in the cell (fraction of the whole image).
            $aChild->SetPos($x + $w / 2, $y + $h / 2);
            $aChild->Stroke($aGraph);
        }
    }

    // Lay children out along one axis, proportional to their LayoutSize().
    protected function _layout($aGraph, $aHoriz) {
        $this->_applyTitleInset($aGraph);
        $total = $this->LayoutSize();
        if( $total <= 0 ) {
            return;
        }
        if( $aHoriz ) {
            $cx = $this->iX;
            foreach( $this->iObj as $child ) {
                $cw = $this->iW * ($child->LayoutSize() / $total);
                $this->_strokeChild($child, $aGraph, $cx, $this->iY, $cw, $this->iH);
                $cx += $cw;
            }
        }
        else {
            $cy = $this->iY;
            foreach( $this->iObj as $child ) {
                $ch = $this->iH * ($child->LayoutSize() / $total);
                $this->_strokeChild($child, $aGraph, $this->iX, $cy, $this->iW, $ch);
                $cy += $ch;
            }
        }
    }

    // For the top-level node only, shrink the region from the top so the
    // sub-plots do not overlap the graph title.
    protected function _applyTitleInset($aGraph) {
        if( ! $this->iTitleInset ) {
            return; // nested node: region already accounts for the title
        }
        $this->iTitleInset = false; // apply once
        if( ! isset($aGraph->title) || ! is_object($aGraph->title) ) {
            return;
        }
        $t = isset($aGraph->title->t) ? $aGraph->title->t : '';
        if( $t === '' || $t === null ) {
            return;
        }
        $img = $aGraph->img;
        $th  = 0;
        if( method_exists($aGraph->title, 'GetTextHeight') ) {
            $th = (float) @$aGraph->title->GetTextHeight($img);
        }
        if( $th <= 0 ) {
            $th = 20; // conservative default when the height can't be measured
        }
        $inset = ($th + 12) / max(1, $img->height);
        $inset = min(0.25, max(0.0, $inset));
        if( $inset > 0 ) {
            $this->iY = $inset;
            $this->iH = 1.0 - $inset;
        }
    }

    // A bare LayoutRect behaves like a horizontal row.
    function Stroke($aGraph) {
        $this->_layout($aGraph, true);
    }
}

// Arrange children left-to-right.
class LayoutHor extends LayoutRect {
    function Stroke($aGraph) {
        $this->_layout($aGraph, true);
    }
}

// Arrange children top-to-bottom.
class LayoutVert extends LayoutRect {
    function Stroke($aGraph) {
        $this->_layout($aGraph, false);
    }
}
