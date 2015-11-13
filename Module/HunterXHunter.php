<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming words about HunterXHunter.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class HunterXHunter implements ModuleInterface {

    use ModuleTrait;

    // module info
    public $info = [
        'name' => '獵人',
        'desc' => '日本動畫',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        // only works when convert to Transitional Chinese
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        $cnt = 0;
        $threshold = 8;
        $keywords = ['全職獵人', '幻影旅團', '嵌合蟻', '奇犽', '基路亞', '西索', '畢索加', '希索嘉'];
        foreach ($keywords as &$keyword) {
            $cnt += substr_count($info->texts['tc'], $keyword);
            if ($cnt > $threshold) return true;
        }
        return false;
    }

    public function loop_or_not () {
        return false;
    }

    // http://zh.wikipedia.org/wiki/Talk:HUNTER%C3%97HUNTER%E8%A7%92%E8%89%B2%E5%88%97%E8%A1%A8
    public function conversion_table (ModuleAnalysis &$info) {
        return [
            '全職獵人' => '獵人',

            // 主角
            '小?岡' => '小傑',
            '費格斯|菲獵斯' => '富力士',
            '[李里裡]昂[李里裡]奧' => '雷歐力',
            '古[勒拿]比加' => '酷拉皮卡',
            '基路亞' => '奇犽',

            // 揍敵客家
            '左魯迪古|祖迪' => '揍敵客',
            '伊路米' => '伊耳謎',
            '米路奇' => '糜稽',
            '嘉路多' => '柯特',
            '薛奴拔' => '席巴',
            '[謝哲]諾' => '桀諾',
            '吉梗' => '奇曲',

            // 幻影旅團
            '克洛洛|古羅洛' => '庫洛洛',
            '斯[里裡]夫' => '魯西魯',
            '畢索加|希索嘉' => '西索',
            '查路拿古|沙勒古' => '俠客',
            '麻子|瑪芝' => '瑪奇',
            '小霞|志津久' => '小滴',
            '佛達|菲丹' => '飛坦',
            '法蘭基|費林明' => '富蘭克林',
            '胡步勁|上坊' => '窩金',
            '羅布拿加' => '信長',
            '法古斯|范克司' => '芬克斯',
            '彭古娜蒂|柏古諾特|柏露達' => '派克諾妲',
            '哥路多比|高[托託]比' => '庫嗶',
            '波諾尼' => '剝落列夫',

            // 其他配角
            '冬帕' => '東巴',
            '巴[崩鵬]' => '疤彭',
            '朦淇' => '門淇',
            '比斯凱' => '比斯吉',
            '蓋斯魯' => '甘舒',
            '葛度' => '梧桐',
            '鵬茲' => '彭絲',
        ];
    }
}
