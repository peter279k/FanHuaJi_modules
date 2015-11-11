<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming generic words.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class ProperNoun implements ModuleInterface {

    use ModuleTrait;

    // module info
    public $info = array(
        'name' => '專有名詞',
        'desc' => '較具有通用性的人名、地名、片名、遊戲名等等…',
    );

    // if a English word writes in uppercase, we may consider it as a proper noun
    private $convTable = array(
        // 人名
        '伯利茲'=>'貝里斯',
        '傅[里裡]葉'=>'傅立葉',
        '列奧納多'=>'李奧納多',
        '喬布斯'=>'賈伯斯',
        '埃瑞克'=>'艾瑞克',
        '巴佛滅'=>'巴風特',
        '弗蘭克'=>'法蘭克',
        '斯大林'=>'史達林',
        '斯科特'=>'史考特',
        '萊昂納多'=>'李奧納多',
        '蓋茨'=>'蓋茲',
        '薛定[諤谔鄂]'=>'薛丁格',
        '迪卡普[里裡]奧'=>'狄卡皮歐',
        '達·?芬奇'=>'達文西',
        // 機構、組織
        '(?<![山空幽稻五])[谷穀]歌'=>'Google',
        // 國家、地名
        '九重裡'=>'九重里',
        '伯克利'=>'柏克萊',
        '布[裡里列]塔'=>'不列顛',
        // 影視
        '[黑駭]客帝國'=>'駭客任務',
        '加勒比海盗'=>'神鬼奇航',
        '指環王'=>'魔戒',
        '星球大戰'=>'星際大戰',
        '泰坦尼克號?'=>'鐵達尼號',
        '盜夢空間'=>'全面啟動',
        // 遊戲
        '(?<![上的])求生之路(?![也越愈])'=>'惡靈勢力',
        '(?<![用靠著的])合金裝備'=>'潛龍諜影',
        '(?<![的]|[變成]為)生化危機'=>'惡靈古堡',
        '使命召喚'=>'決勝時刻',
        '冰封王座'=>'寒冰霸權',
        '刺客信條'=>'刺客教條',
        '古墓麗影'=>'古墓奇兵',
        '命令與征服'=>'終極動員令',
        '孤島危機'=>'末日之戰',
        '孤島驚魂'=>'極地戰嚎',
        '寂靜嶺'=>'沉默之丘',
        '怪物獵人'=>'魔物獵人',
        '最終幻想'=>'太空戰士',
        '極品飛車'=>'極速快感',
        '泡泡堂'=>'爆爆王',
        '紅心大戰'=>'傷心小棧',
        '街頭霸王'=>'快打旋風',
        // 化學
        '硅'=>'矽', '砹'=>'砈', '銰'=>'砈', '鈪'=>'砈', '鈁'=>'鍅',
        '鈈'=>'鈽', '錇'=>'鉳', '鍀'=>'鎝', '鎄'=>'鑀', '鎇'=>'鋂',
        '鎿'=>'錼', '鐦'=>'鉲', '鑥'=>'鎦',
        // 動漫
        '([a-z之的代]|自由|天帝|決鬥|暴風|瘟神|禁斷|神盾|侵略|電擊|攻擊|戰士|正義|雷鳥|陸戰|精靈|實驗|獨角獸?)(型)?[高敢]達'=>'$1$2鋼彈',
        '[高敢]達([a-z動漫達玩系模公種之娘無玉石版板])'=>'鋼彈$1',
        '中華小(廚師|當家)'=>'中華一番',
        '全金屬狂潮'=>'驚爆危機',
        '千與千尋'=>'神隱少女',
        '口袋(妖怪|怪[獸物])|寵物小精靈'=>'神奇寶貝',
        '寵物小精靈'=>'神奇寶貝',
        '數碼暴龍'=>'數碼寶貝',
        '浪客劍心'=>'神劍闖江湖',
        '鐵臂阿童木'=>'原子小金剛',
        // 日文
        '(?<![會才只本又還怎麼跟跑])來棲(?![息])'=>'來栖',
        '有棲院'=>'有栖院',
        '栖([姬鬼艦])'=>'棲$1', // 艦隊Collection
        '麻枝準(?![備])'=>'麻枝准',
    );

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, array('tw'))) return false;
        return true;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return $this->convTable;
    }

}
