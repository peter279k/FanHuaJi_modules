<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming words about OnePiece.
 * @author 小斐 <admin@2d-gate.org>
 * @ref https://zh.wikipedia.org/wiki/%E6%A8%A1%E5%9D%97:CGroup/OnePiece
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\Module\Helper\AbstractModule;

class OnePiece extends AbstractModule {

    // module info
    public static $info = [
        'name' => '海賊王',
        'desc' => '日本動畫',
    ];

    private static $mapping = [
        //////////////////
        // observations //
        //////////////////
        '(?>香吉(?!士)|山[治智])君?' => '香吉士',
        '羅羅諾亞' => '羅羅亞',
        '烏索普' => '騙人布',
        '德古拉' => '喬拉可爾',
        '紅髮傑克斯' => '紅髮傑克',
        '摩根' => '蒙卡',
        '毛奇' => '摩奇',
        ////////////////////
        // from Wikimedia //
        ////////////////////
        '蒙奇' => '蒙其',
        '路飛' => '魯夫',
        '佐羅' => '索隆',
        '奈美' => '娜美',
        '撒謊布' => '騙人布',
        '山智' => '香吉士',
        '妮古' => '妮可',
        '弗蘭奇' => '佛朗基',
        '千[裡里]陽光號' => '千陽號',
        '瑪利喬亞' => '馬力喬亞',
        '艾尼艾斯' => '艾尼愛斯',
        '庫[贊讚]' => '庫山',
        '戈普' => '卡普',
        '[菸煙]鬼' => '斯摩格',
        'T-bone' => 'T彭恩',
        '塔希米' => '達絲琪',
        '日奈' => '希娜',
        '鼴鼠' => '飛鼠',
        '可比' => '克比',
        '希路麥波' => '貝魯梅伯',
        '赫波迪' => '芬布迪',
        '強高' => '傑克斯',
        '羅西南德' => '羅希南特',
        '馬林梵多' => '馬林福特',
        'NEO海軍' => '新海軍',
        '大將(?![軍])' => '上將',
        '愛德華' => '艾德華',
        '紐哥[德特]' => '紐蓋特',
        '夏洛特([．·• 　]*)玲玲' => '夏洛特$1莉莉',
        '蓋德' => '海道',
        '傑拉基爾' => '喬拉可爾',
        '米霍克' => '密佛格',
        '多弗拉門戈' => '多佛朗明哥',
        '巴索羅謬' => '巴索羅繆',
        '波爾' => '波雅',
        '漢庫珂' => '漢考克',
        '甚平' => '吉貝爾',
        '提奇' => '汀奇',
        '匹卡' => '皮卡',
        '迪亞曼蒂' => '帝雅曼鐵',
        '克拉松' => '柯拉遜',
        '糖糖' => '砂糖',
        '古拉迪烏斯' => '古拉迪斯',
        '拉奧G' => '拉歐G',
        '戴林格' => '德林傑',
        '賽諾爾([．·• 　]*)平克' => '粉紅先生',
        '馬哈拜斯' => '馬赫拜茲',
        '德萊斯羅茲' => '多雷斯羅薩',
        '維奧拉' => '碧歐菈',
        '紫羅蘭' => '維爾莉特',
        '莉貝卡' => '蕾貝卡',
        '[裡里]克([．·• 　]*)多爾鐸' => '利克$1德爾多3世',
        '巴爾托羅梅奧' => '巴特洛馬',
        '凱文迪修' => '卡文迪許',
        '蔡義' => '雜菜',
        '布武' => '阿葡',
        '海爾丁' => '哈爾汀',
        '班克禁區' => '龐克哈薩特',
        '凱撒([．·• 　]*)庫朗' => '凱薩$1克勞恩',
        '莫奈' => '莫內',
        '維爾高' => '威爾可',
        '挪亞' => '諾亞',
        '鮫星' => '鯊星',
        '龍星' => '皇星',
        '曼星' => '翻車星',
        '范德' => '班塔',
        '霍迪' => '荷帝',
        '伊卡魯斯([．·• 　]*)姆嘻' => '伊卡洛斯$1穆希',
        '梅迦羅' => '梅卡洛',
        '夏莉夫人' => '雪莉夫人',
        '克爾拉' => '可亞拉',
        '加[裡里]([．·• 　]*)達丹' => '卡莉$1達坦',
        '達丹' => '達坦',
        '范([．·• 　]*)貝克曼' => '班$1貝克曼',
        '拉奇([．·• 　]*)路' => '拉奇$1魯',
        '旺([．·• 　]*)奧加' => '范$1歐葛',
        '吉扎斯([．·• 　]*)巴傑斯' => '吉札士$1伯吉斯',
        'Dr.Q' => '毒Q',
        '希流' => '矢龍',
        '聖胡安([．·• 　]*)惡狼' => '薩方$1烏爾夫',
        '阿瓦羅([．·• 　]*)匹薩羅' => '亞帕羅$1披薩羅',
        '巴斯克([．·• 　]*)喬特' => '巴斯可$1簫特',
        '卡特蓮娜([．·• 　]*)蝶美' => '卡達莉納$1戴彭',
        '馬爾高' => '馬可',
        '波特夾斯' => '波特卡斯',
        '露秀' => '露珠',
        '喬茲' => '裘斯',
        '沙奇' => '薩吉',
        '霍懷迪貝' => '白雪之珮',
        '庫斯亞德' => '史庫亞德',
        '安普[裡里]奧' => '艾波利歐',
        '因佩爾' => '推進城',
        '漢尼拔' => '般若拔',
        '多米諾' => '托米諾',
        '候斯' => '薩魯戴斯',
        '薩迪小姐' => '小莎蒂',
        '金盞花' => '瑪莉哥德',
        '宮燈花' => '桑塔索妮雅',
        '斑馬花' => '雅菲蘭朵拉',
        '火焰花' => '嘉蘭百合',
        '香波地諸島' => '夏波帝諸島',
        '希爾巴茲' => '席爾巴斯',
        '芍奇' => '夏姬',
        '巴基爾([．·• 　]*)霍金斯' => '巴吉魯$1霍金斯',
        '德雷克' => '多雷古',
        '特拉法爾加' => '托拉法爾加',
        '瓦鉄爾' => '瓦特爾',
        '江巴爾' => '強帕爾',
        '貝寶' => '培波',
        '逆戟鯨' => '夏奇',
        '打碟人([．·• 　]*)阿保' => '刮盤人$1亞普',
        '基拉' => '奇拉',
        '傑麗([．·• 　]*)邦妮' => '珠寶$1波妮',
        '邦妮' => '波妮',
        '「匪幫」' => '「流氓」',
        '卡彭([．·• 　]*)班吉' => '卡波涅$1培基',
        '維莎利亞' => '維薩利亞',
        '巴爾基摩亞' => '巴爾的摩',
        '卡瑪巴卡' => '卡馬帕卡',
        '海克力斯' => '海格拉斯',
        '納瑪庫拉島' => '破銅爛鐵島',
        '哈拉海塔尼亞' => '哈拉黑塔涼',
        '特奇拉沃爾夫' => '龍舌蘭之狼',
        '克拉伊咖那' => '克拉伊卡納',
        '西茲凱阿爾' => '西凱阿爾',
        '凱咪' => '海咪',
        '帕帕格' => '帕帕克',
        '豪格巴克' => '赫古巴庫',
        '辛德麗' => '辛朵莉',
        '阿布薩拉姆' => '阿布薩羅姆',
        '佩羅娜' => '培羅娜',
        '柯瑪西' => '庫馬希',
        '奧茲' => '歐斯',
        '約克' => '尤奇',
        '奧爾比亞' => '歐爾比雅',
        '三葉草博士' => '克洛巴博士',
        '魯茲' => '路基',
        '佳妮法' => '卡莉法',
        '斯潘達姆' => '斯帕達姆',
        '傑布拉' => '賈布拉',
        '臉譜' => '隈取',
        '阿斯巴古' => '艾斯巴古',
        '巴利' => '包利',
        '皮布[裡里]([．·• 　]*)魯魯' => '畢普利$1露露',
        '泰魯斯通' => '戴魯斯通',
        '奇姆妮' => '蒂姆妮',
        '昆平' => '公貝',
        '卡提([．·• 　]*)佛蘭姆' => '卡迪$1佛拉姆',
        '艾尼路' => '艾涅爾',
        '皮埃爾' => '皮耶爾',
        '馬堅力' => '麥金利',
        '柯尼絲' => '柯妮絲',
        '卡爾加拉' => '卡爾葛拉',
        '庫力凱特' => '庫力凱',
        '諾蘭度' => '諾蘭德',
        '奈菲特' => '納菲魯塔莉',
        '可布拉' => '寇布拉',
        '伊格拉姆' => '尹卡蘭姆',
        '貝魯' => '貝爾',
        '恰卡' => '加卡',
        '空扎' => '寇沙',
        '鱷魚' => '克洛克達爾',
        '達茲([．·• 　]*)波涅斯' => '達茲$1波涅士',
        '盆([．·• 　]*)歲末' => '馮$1克雷',
        '本薩姆' => '班薩姆',
        '加爾迪諾' => '賈爾迪諾',
        '波拉' => '波菈',
        '克洛卡斯' => '可樂可斯',
        '一本松' => '賣一刀',
        '阿龍' => '惡龍',
        '貝魯梅爾' => '貝爾梅爾',
        '野路子' => '虹子',
        '健藏' => '源造',
        '卓夫' => '哲普',
        '嘉雅' => '可雅',
        '巴奇' => '巴其',
        '亞比達' => '亞爾麗塔',
        '秀秀' => '咻咻',
        '閃光人' => '光人',
        '高路' => '哥爾',
        '[裡里]克' => '利克',
        '凱撒' => '凱薩',
        '伊卡魯斯' => '伊卡洛斯',
        '加[裡里]' => '卡莉',
        '吉扎斯' => '吉札士',
        '聖胡安' => '薩方',
        '阿瓦羅' => '亞帕羅',
        '巴斯克' => '巴斯可',
        '卡特蓮娜' => '卡達莉納',
        '巴基爾' => '巴吉魯',
        '打碟人' => '刮盤人',
        '傑麗' => '珠寶',
        '卡彭' => '卡波涅',
        '皮布[裡里]' => '畢普利',
        '卡提' => '卡迪',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        // only works when convert to Transitional Chinese
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        $text = &$info->texts['tc'];
        $keywords = ['海賊王', '草帽小子', '路飛', '魯夫', '香吉', '烏索普', '騙人布', '索隆', '佐羅', '喬巴', '布魯克', '羅賓', '弗蘭奇', '佛朗基'];
        return $this->LoadOrNotByKeywords($text, $keywords, 3, 1.5, 1.2);
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return self::$mapping;
    }

    ///////////////////////
    // utility functions //
    ///////////////////////

    /**
     * input format is like the following:
     *
     *     return {
     *
     *     name='OnePiece',
     *     description = 'OnePiece',
     *     content = {
     *
     *     { type = 'text', text = [=[
     *     [[Category:ACG公共轉換組模板|{{SUBPAGENAME}}]][[Category:ONE PIECE]]
     *     ..............
     *
     * @return array [parsed data in array]
     * @ref https://zh.wikipedia.org/wiki/%E6%A8%A1%E5%9D%97:CGroup/OnePiece
     */
    private function parseWikiPage (&$text) {
        if (preg_match_all("#rule = '([^\r\n]+;)'#imuS", $text, $rules)) {
            $rules = $rules[1];
            $ret = [];
            foreach ($rules as &$rule) {
                $array_series = preg_split("#;\s*#", $rule, -1, PREG_SPLIT_NO_EMPTY);
                $array_associative = [];
                foreach ($array_series as &$translation) {
                    list($locale, $text) = explode(':', $translation);
                    $array_associative[$locale] = $text;
                }
                $ret[] = $array_associative;
            }
            return $ret;
        }
        return false;
    }

    private function filterConversions (array &$conversions) {
        $nameDelimiters = '．·• 　';
        $textToRegex = function ($text, $srcLocale='sc') use (&$nameDelimiters) {
            switch ($srcLocale) {
                default:
                case 'sc':
                    $fixTable = [
                        "[{$nameDelimiters}]" => "([{$nameDelimiters}]*)",
                        '[裡里]' => '[裡里]',
                        '[贊讚]' => '[贊讚]',
                        '[菸煙]' => '[菸煙]',
                        '哥[德特]' => '哥[德特]',
                        '大將' => '大將(?![軍])',
                    ];
                    break;
                case 'tc':
                    $fixTable = [
                        "[{$nameDelimiters}]" => '\$1',
                    ];
                    break;
            }
            foreach ($fixTable as $sr => &$rep) {
                $text = preg_replace("/{$sr}/iumS", $rep, $text);
            }
            return $text;
        };
        $ret = $lastnames = [];
        foreach ($conversions as &$conversion) {
            // pick out Simplified Chinese
            if     (isset($conversion['zh-cn']))   $sc = &$conversion['zh-cn'];
            elseif (isset($conversion['zh-hans'])) $sc = &$conversion['zh-hans'];
            elseif (isset($conversion['zh-hant'])) $sc = &$conversion['zh-hant'];
            else                                   $sc = '';
            // pick out Traditional Chinese (Taiwan)
            if     (isset($conversion['zh-tw']))   $tc = &$conversion['zh-tw'];
            elseif (isset($conversion['zh-hant'])) $tc = &$conversion['zh-hant'];
            else                                   $tc = '';
            // sanitize
            if (empty($sc) || empty($tc) || $sc == $tc) continue;
            // use regex
            $ret[$textToRegex($sc, 'sc')] = $textToRegex($tc, 'tc');
            // add the last name into the conversion list
            $nameSplit_sc = preg_split("/[{$nameDelimiters}]/uS", $sc, -1, PREG_SPLIT_NO_EMPTY);
            $nameSplit_tc = preg_split("/[{$nameDelimiters}]/uS", $tc, -1, PREG_SPLIT_NO_EMPTY);
            if (count($nameSplit_sc) > 1 && count($nameSplit_tc) > 1) {
                $lastname_sc = &$nameSplit_sc[0];
                $lastname_tc = &$nameSplit_tc[0];
                if (
                    $lastname_sc != $lastname_tc &&
                    mb_strlen($lastname_sc, 'UTF-8') > 1
                ) {
                    $lastnames[$textToRegex($lastname_sc, 'sc')] = $lastname_tc;
                }
            }
        }
        return array_merge($ret, $lastnames);
    }

}
