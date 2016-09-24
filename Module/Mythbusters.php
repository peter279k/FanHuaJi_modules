<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming words about Mythbusters.
 * @author 小斐 and admin@2d-gate.org
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\Module\Helper\AbstractModule;

class Mythbusters extends AbstractModule {

    public static $info = [
        'name' => '流言終結者',
        'desc' => 'Discovery 科普片',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        $cnt = 0;
        $threshold = 1;
        $keywords = ['流言終結者'];
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
        return [

'薩維奇' => '沙維奇',
'格蘭特(?![別意地殊])' => '格蘭',
'托[里利]' => '托瑞',
'[凱卡][莉麗](?<!凱莉)' => '凱莉',
'雪[佛弗福]蘭' => '雪佛蘭',
'泡沫塑[膠料]' => '泡棉塑膠',

        ];
    }

}
