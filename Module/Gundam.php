<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming words about Gundam.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class Gundam implements ModuleInterface {

    use ModuleTrait;

    // module info
    public static $info = [
        'name' => '鋼彈',
        'desc' => '日本動畫',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        $text = &$info->texts['tc'];
        $keywords = ['高達', '敢達', '鋼彈', '機動', '夏亞'];
        return $this->LoadOrNotByKeywords($text, $keywords, 2, 1.5, 1.2);
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        if ($info->to == 'hk') {
            return $this->conversion_table_hk();
        } else {
            return $this->conversion_table_tw();
        }
    }

    public function conversion_table_hk () {
        return [
            '鋼彈' => '高達',
        ];
    }

    public function conversion_table_tw () {
        return [
            '[高敢]達' => '鋼彈',
        ];
    }

}
