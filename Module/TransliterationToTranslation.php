<?php

/**
 * This is a module for FanHuaJi.
 * It replaces transliteration with translation.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\Module\Helper\AbstractModule;

class TransliterationToTranslation extends AbstractModule {

    // module info
    public static $info = [
        'name' => '音譯轉意譯',
        'desc' => '例如：胖次→內褲、歐派→胸部',
    ];

    private static $mapping = [
        '(?<!男子漢)大丈夫(?=[吧嗎啊呢吶嘎呀啦])' => '沒問題',
        '[雅亞呀][美妹蠛][蝶跌疊]' => '不要啊',
        '[歐毆偶嘔][尼泥逆膩]醬'=>'哥哥',
        '[唷呦喲][西希]' => '好',
        '(?<![磨])[蹭憎][得的]累' => '傲嬌',
        '(?<![姊姐妹])妹抖(?![著])' => '女僕',
        '歐派' => '胸部',
        '胖次' => '內褲',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        // you need to force enable this module
        return false;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return self::$mapping;
    }

}
