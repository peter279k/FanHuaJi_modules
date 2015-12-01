<?php

/**
 * This is a module for FanHuaJi.
 * It converts an article into nonsense.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class Nonsense implements ModuleInterface {

    use ModuleTrait;

    // module info
    public $info = [
        'name' => '廢到笑',
        'desc' => '將文章轉換成廢文…（須強制啟用模組）',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        // you need to force enable this module
        return false;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return [
            '幹你媽的' => 'ㄍㄋㄇㄉ',
            '\b[cｃＣ][cｃＣ][rｒＲ]\b' => 'ㄈㄈ尺',
            '出來' => '粗乃',
            '出去' => '粗企',
            '([覺做作幹來])得' => '$1ㄉ',
            '可([愛憐])' => '口$1',
            '([約打幹])([泡炮砲])' => '$1ㄆ',
            '應該' => '因該',
            '喜歡' => '洗翻',
            '外國' => '歪果',
            '大大' => 'ㄉㄉ',
            '漂亮' => '漂釀',
            '肥宅' => 'ㄈㄓ',
            '這樣' => '醬',
            '開心' => '開薰',
            '(?<![淹沉沈吞])沒' => '迷',
            '超(?![人])' => '敲',
            '[你妳]' => '泥',
            '們' => '悶',
            '出' => '粗',
            '好' => '毫',
            '就' => '啾',
            '很' => '狠',
            '我' => '窩',
            '最' => '罪',
            '說' => '縮',

            '走吧' => '９８',
            '是' => '４',
            '無' => '５',

            '加油' => '+U',
            '愛' => 'ｉ',
            '屁' => 'Ｐ',
            '有' => 'Ｕ',
            '一' => 'yee',

            // ㄅㄆㄇㄈ
            '[不吧]' => 'ㄅ',
            '[嗎媽]' => 'ㄇ',
            '[麼]' => 'ㄇ',
            // ㄉㄊㄋㄌ
            '(?<![目])的' => 'ㄉ',
            '[他她它牠祂]' => 'ㄊ',
            '呢' => 'ㄋ',
            '了(?![解結斷])' => 'ㄌ',
            // ㄍㄎㄏ
            '[個歌哥]' => 'ㄍ',
            '[可科顆]' => 'ㄎ',
            '呵' => 'ㄏ',
            // ㄐㄑㄒ
            '雞' => 'ㄐ',
            '去' => 'ㄑ',
            // ㄓㄔㄕㄖ
            '[之隻知]' => 'ㄓ',
            // ㄗㄘㄙ
            '[滋子]' => 'ㄗ',
            '[吃]' => 'ㄘ',
            // ㄧㄨㄩ
            // ㄚㄛㄜㄝ
            '[阿啊]' => 'ㄚ',
            '喔' => 'ㄛ',
            // ㄞㄟㄠㄡ
            '[毆歐]' => 'ㄡ',
            // ㄢㄣㄤㄥ
            '[安]' => 'ㄢ',
            // ㄦ
        ];
    }

}