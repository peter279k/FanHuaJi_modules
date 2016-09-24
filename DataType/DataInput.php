<?php

/**
 * This class is the data unit used in Fanhuaji.
 * @author 小斐 and admin@2d-gate.org
 */

namespace XiaoFei\Fanhuaji\DataType;

class DataInput {
    public $text = ''; // input text
    public $to   = ''; // target locale
    function __construct ($text, $to) {
        $this->text = $text;
        $this->to   = $to;
    }
}
