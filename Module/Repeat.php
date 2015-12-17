<?php

/**
 * This is a special module for FanHuaJi.
 * It converts "草...草...泥~馬~馬" into "操...操...你~媽~媽".
 * The punctuations among chars are ignored and the conversion extends bi-directional.
 * Flaw(s):
 *   - "草...草...泥~泥~馬~馬" will not be converted
 *     because it becomes "雅雅美美蝶蝶" after removing punctuations
 *     and "雅美蝶" can not be found in the string.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\DataType\MbString;

class Repeat implements ModuleInterface {

    use ModuleTrait;

    // module info
    public static $info = [
        'name' => '重複字取代',
        'desc' => '功能類似這樣：「神...神~神─馬」→「什...什~什─麼」。容易被中斷的詞轉換可以透過此模組得到解決。',
    ];

    // settings
    private $encoding = "UTF-8";
    private $context = 5; // check length for conditionRegex
    private $punctuationRegex = "/([\t 　,，.。…、!！?？~～\-─－☆★卍卐「」『』【】《》〈〉]+|[\\2a-z\d\\3]+)/uiS";
    private $convTableBefore = [
        // search => [replace, conditionRegex]
        '草泥馬戈壁' => ['操你媽個屄', ''],
        '草泥馬' => ['操你媽', '草泥馬(?!了)'],
        '淡定' => ['冷靜', ''],
        '神馬' => ['什麼', '(?<![匹眼眾諸死戰火風水雷之])神馬'],
        '甚什麼' => ['什什麼', ''],
        '臥槽' => ['我操', ''],
        '能行' => ['可以', '(?<![功不可])能行([的吧嗎啊呢吶嘎]|[\s　]|$)'],
        '家伙' => ['傢伙', ''],
        '家夥' => ['傢伙', ''],
        '傢夥' => ['傢伙', ''],
        '石頭剪刀布' => ['剪刀石頭布', ''],
        '石頭剪子布' => ['剪刀石頭布', ''],
        '干幹嘛' => ['幹幹嘛', ''],
        '痛疼' => ['痛痛', ''],
        '疼疼疼' => ['痛痛痛', '疼疼疼(?!痛)'],
    ];
    private $convTableAfter = [
        // search => [replace, conditionRege]
        '衝沖田' => ['沖沖田', ''],
        '什嗎' => ['什麼', ''],
        '鬆竹梅' => ['松竹梅', ''],
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        return true;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return [];
    }

    public function hookBefore_Hongkongize (DataInput &$in) { $this->_hookBefore($in); }
    public function hookAfter_Hongkongize  (DataInput &$in) { $this->_hookAfter($in); }
    public function hookBefore_Taiwanize   (DataInput &$in) { $this->_hookBefore($in); }
    public function hookAfter_Taiwanize    (DataInput &$in) { $this->_hookAfter($in); }

    private function _hookBefore (DataInput &$in) {
        $this->replaceRepeatPattern(
            $in->text,
            $this->punctuationRegex,
            $this->convTableBefore,
            $this->context
        );
    }

    private function _hookAfter (DataInput &$in) {
        $this->replaceRepeatPattern(
            $in->text,
            $this->punctuationRegex,
            $this->convTableAfter,
            $this->context
        );
    }

    private function replaceRepeatPattern (&$text, &$punctuationRegex, &$convTable, $context) {

        // split text into text parts (even key) and symbol parts (odd key)
        $textSplit = preg_split($punctuationRegex, $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $textSplitCnt = count($textSplit);

        // get text parts and merge them into a new string to $textNoSymbol
        $textNoSymbol = [];
        for ($i=0; $i<$textSplitCnt; $i+=2) {
            $textNoSymbol[] = &$textSplit[$i];
        }
        $textNoSymbol = implode('', $textNoSymbol);

        $mbTextNoSymbol = new MbString($textNoSymbol, $this->encoding);
        $mbTextNoSymbol_len = $mbTextNoSymbol->strlen();
        // do conversion on the de-symboled text, i.e., $mbTextNoSymbol
        foreach ($convTable as $sr => &$repArr) {
            list($rep, $conditionRegex) = $repArr;
            $mbSr  = new MbString($sr, $this->encoding);
            $mbRep = new MbString($rep, $this->encoding);
            $mbSr_len  = $mbSr->strlen();
            $mbRep_len = $mbRep->strlen();
            // skip replacements which will cause different lengths
            if ($mbSr_len != $mbRep_len) { unset($mbSr, $mbRep); continue; }
            // start the replacement
            $seek = -1;
            while (true) {
                // find the position of the searched string
                $seek = $mbTextNoSymbol->strpos($sr, $seek+1);
                if ($seek === false) break;
                // check the $conditionRegex
                $textSlice = $mbTextNoSymbol->substr(($seek>$context ? $seek-$context : 0), $mbSr_len+$context<<1);
                if (!empty($conditionRegex) && !preg_match("/$conditionRegex/u", $textSlice)) continue;
                // replace frontward
                $seekFront = $seek;
                while ($seekFront > 0) {
                    --$seekFront;
                    // check $charToCheck is in $sr or not
                    $charToCheck = $mbTextNoSymbol[$seekFront];
                    $charToCheckPosInSr = $mbSr->strpos($charToCheck);
                    if ($charToCheckPosInSr === false) break;
                    // replace $charToCheck with the corresponding one
                    $repChar = $mbRep[$charToCheckPosInSr];
                    $mbTextNoSymbol->substr_replace_i($repChar, $seekFront, 1);
                }
                // replace backward
                $seekBack = $seek + $mbSr_len;
                while ($seekBack < $mbTextNoSymbol_len) {
                    // check $charToCheck is in $sr or not
                    $charToCheck = $mbTextNoSymbol[$seekBack];
                    $charToCheckPosInSr = $mbSr->strpos($charToCheck);
                    if ($charToCheckPosInSr === false) break;
                    // replace $charToCheck with the corresponding one
                    $repChar = $mbRep[$charToCheckPosInSr];
                    $mbTextNoSymbol->substr_replace_i($repChar, $seekBack, 1);
                    ++$seekBack;
                }
                // replace the center
                $mbTextNoSymbol->substr_replace_i($rep, $seek, $mbSr_len);
            }
            unset($mbSr, $mbRep);
        }

        // patch text parts in $textSplit by using $mbTextNoSymbol
        for ($i=$seek=0; $i<$textSplitCnt; $i+=2) {
            $pieceLength = MbString::static_strlen($textSplit[$i], $this->encoding);
            $textSplit[$i] = $mbTextNoSymbol->substr($seek, $pieceLength);
            $seek += $pieceLength;
        }
        unset($mbTextNoSymbol);

        // re-construct $text by concatenating $textSplit
        $text = implode('', $textSplit);
    }

}
