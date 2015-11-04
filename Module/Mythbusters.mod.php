<?php

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class Mythbusters implements ModuleInterface {

    use ModuleTrait;

    // module info
    public $info = array(
        'name' => '流言終結者',
        'desc' => 'Discovery 科普片',
    );

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, array('tw', 'hk'))) return false;
        $cnt = 0;
        $threshold = 1;
        $keywords = array('流言終結者');
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
            '薩維奇' => '沙維奇',
            '格蘭特(?![別意地殊])' => '格蘭',
            '托[里利]' => '托瑞',
            '[凱卡][莉麗](?<!凱莉)' => '凱莉',
            '雪[佛弗福]蘭' => '雪佛蘭',
            '泡沫塑[膠料]' => '泡棉塑膠',
        );
    }

}
