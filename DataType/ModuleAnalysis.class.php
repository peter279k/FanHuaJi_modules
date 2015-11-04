<?php

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
