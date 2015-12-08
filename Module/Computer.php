<?php

/**
 * This is a module for FanHuaJi.
 * It's responsible for transforming words about Computer.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

class Computer implements ModuleInterface {

    use ModuleTrait;

    // module info
    public $info = [
        'name' => '電腦詞彙',
        'desc' => '可以用在應用程式的語系檔',
    ];

    // http://jjhou.boolan.com/terms.htm
    private static $mapping = [
        '(?<![寬恢])宏(?![大觀遠偉])' => '巨集',
        '[制製]表位' => '定位點',
        '[源原]碼' => '原始碼',
        '保存' => '儲存',
        '全屏幕?' => '全螢幕',
        '剪切' => '剪下',
        '單元格' => '儲存格',
        '在線(?![上下])' => '線上',
        '在線下(?![賽面])' => '離線',
        '工具欄' => '工具列',
        '剪貼板' => '剪貼簿',
        '只讀(?![了過取寫])' => '唯讀',
        '[注註]譯' => '註解',
        '拆分' => '分割',
        '指針' => '指標',
        '接口' => '介面',
        '撤消' => '復原',
        '支持' => '支援',
        '數據(?![機])' => '資料',
        '文件夾' => '資料夾',
        '文件' => '檔案',
        '文檔' => '文件',
        '智能' => '智慧',
        '替換' => '取代',
        '查找' => '尋找',
        '激活' => '啟用',
        '(擴展|後綴)名' => '副檔名',
        '狀態條' => '狀態列',
        '皮膚' => '外觀',
        '程序' => '程式',
        '窗口' => '視窗',
        '窗體' => '表單',
        '組件' => '元件',
        '網格線' => '格線',
        '自定義' => '自訂',
        '菜單' => '選單',
        '(?<![檢])視圖' => '檢視',
        '計算機' => '電腦',
        '訪問(?=[本遠線在])' => '存取',
        '設置(?![的])' => '設定',
        '(?<![被])通過(?!([信郵]箱)?驗證|後)' => '透過',
        '運行' => '執行',
        '頁眉' => '頁首',
        '頁腳' => '頁尾',
        '高級' => '進階',
        '黏貼' => '貼上',
        '拷貝' => '複製',
        '默認' => '預設',
        '聯機' => '連線',
        '窄帶' => '窄頻',
        '常規(?![定則])' => '一般',
        '外圍設備' => '周邊設備',
        '引導記錄' => '開機紀錄',
        '主板' => '主機板',
        '光標' => '游標',
        '內核' => '核心',
        '內聯函數' => '行內函數',
        '冒泡排序' => '氣泡排序',
        '刻錄' => '燒錄',
        '命令行' => '命令列',
        '調試器(?![具械])' => '除錯器',
        '尋址' => '定址',
        '[匯彙]編' => '組語',
        '[匯彙]編語言' => '組合語言',
        '溢出' => '溢位',
        '縮進' => '縮排',
        '用戶' => '使用者',
        '面向對象' => '物件導向',
        '面向過程' => '程序導向',
        '頭文件' => '標頭檔',
        '畫格' => '幀',
        '界面' => '介面',
        'IP(v[46])?地址' => 'IP$1位址',
        '回復後([將把刪提發送紀記停繼返回])' => '回覆後$1',
        '時間線(?![性條])'=>'時間軸',
        '哈希(?![姆])'=>'雜湊',
        '搜索'=>'搜尋',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        $text = &$info->texts['tc'];
        // remove all ASCII chars, leave Chinese chars
        $textChi = preg_replace('/[[:ascii:]]+/u', '', $text);
        // count all times of possible replacements
        $cntArray = [];
        foreach (self::$mapping as $cn => &$tw) {
            if ($this->isRegex($cn)) {
                preg_match_all("/{$cn}/u", $textChi, $matches);
                $cntArray[$cn] = count($matches[0]);
            } else {
                $cntArray[$cn] = substr_count($textChi, $cn);
            }
        }
        // remove empty elements and outliers
        $cntArray = array_filter($cntArray);
        $cntArray = $this->removeOutliers($cntArray, 1.2);
        return
            count($cntArray) >= 6 && // too few types of conversion are performed
            $this->average($cntArray) >= 1.5; // not all conversion appears rarely
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return self::$mapping;
    }

}
