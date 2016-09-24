<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming words about Naruto.
 * @author 小斐 and admin@2d-gate.org
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\Module\Helper\AbstractModule;

class Naruto extends AbstractModule {

    public static $info = [
        'name' => '火影忍者',
        'desc' => '日本動畫',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        // only works when convert to Transitional Chinese
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        $cnt = 0;
        $threshold = 5;
        $keywords = ['忍者', '鳴人', '佐助'];
        foreach ($keywords as &$keyword) {
            $cnt += substr_count($info->texts['tc'], $keyword);
            if ($cnt > $threshold) return true;
        }
        if (strpos($info->texts['tc'], '火影忍者') !== false) return true;
        return false;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return [

'鳴門' => '鳴人',
'渦卷鳴人' => '漩渦鳴人',
'卡凱西' => '卡卡西',
'複製忍者' => '拷貝忍者',
"洛克([{$this->_nameDelimiters} 　]*)李" => '李$1洛克',
'幹柿' => '干柿',

        ];
    }

}
