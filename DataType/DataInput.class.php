<?php

namespace XiaoFei\Fanhuaji\DataType;

class DataInput {
    public $text = ''; // input text
    public $to   = ''; // target locale
    function __construct ($text, $to) {
        $this->text = $text;
        $this->to   = $to;
    }
}
