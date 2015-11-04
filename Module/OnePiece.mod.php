<?php

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class OnePiece implements ModuleInterface {

    use ModuleTrait;

    // module info
    public $info = array(
        'name' => '海賊王',
        'desc' => '日本動畫',
    );

    public function load_or_not (ModuleAnalysis &$info) {
        // only works when convert to Transitional Chinese
        if (!in_array($info->to, array('tw', 'hk'))) return false;
        $cnt = 0;
        $threshold = 8;
        $keywords = array('海賊王', '路飛', '魯夫', '香吉', '烏索普', '騙人布', '索隆', '佐羅', '喬巴', '布魯克', '羅賓', '弗蘭奇', '佛朗基');
        foreach ($keywords as &$keyword) {
            $cnt += substr_count($info->texts['tc'], $keyword);
            if ($cnt > $threshold) return true;
        }
        return false;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return array(
            '蒙奇' => '蒙其',
            '路飛' => '魯夫',
            '奈美' => '娜美',
            '佐羅' => '索隆',
            '(?>香吉(?!士)|山[治智])君?' => '香吉士',
            '羅羅諾亞' => '羅羅亞',
            '烏索普' => '騙人布',
            '弗蘭奇' => '佛朗基',
            '德古拉' => '喬拉可爾',
            '米霍克' => '密佛格',
            '傑克斯' => '傑克',
            '健藏' => '阿健',
            '摩根' => '蒙卡',
            '毛奇' => '摩奇',
            '煙鬼' => '斯摩格',
            '卓夫' => '哲普',
        );
    }

}
