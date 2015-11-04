<?php

namespace XiaoFei\Fanhuaji\Module\Helper;

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

interface ModuleInterface {
    // the conversion table: array('from1'=>'to1', ...)
    public function conversion_table (ModuleAnalysis &$info);
    // load this module or not?
    public function load_or_not (ModuleAnalysis &$info);
    // repeat replacement until there is no text changes?
    public function loop_or_not ();
}
