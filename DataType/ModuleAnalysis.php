<?php

/**
 * This class is used to wrap information while doing module analysis.
 * @author 小斐 and admin@2d-gate.org
 */

namespace XiaoFei\Fanhuaji\DataType;

class ModuleAnalysis {
    public $texts = array(
        'sc'  => '', // input text in Simplified Chinese
        'tc'  => '', // input text in Traditional Chinese
        'src' => '', // input text (not modified)
    );
    public $to = ''; // target locale
    function __construct ($texts, $to) {
        $this->texts = $texts;
        $this->to    = $to;
    }
}
