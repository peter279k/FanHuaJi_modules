<?php

include 'autoload.inc.php';

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

$moduleName = "XiaoFei\\Fanhuaji\\Module\\{$testMod}";
$moduleAnalysisResults = array(
    'load_or_not'      => null,
    'loop_or_not'      => null,
    'conversion_table' => null,
);

// prepare texts for module analysis
$pseudoSctc = new pseudoSctc();
$texts = array(
    // the source in Simplified Chinese
    'sc'  => $pseudoSctc->convert($text, 'sc'),
    // the source in Transitional Chinese
    'tc'  => $pseudoSctc->convert($text, 'tc'),
    // the source
    'src' => $text,
);

myVarDump($texts);

// do module analysis
$analysis  = new ModuleAnalysis($texts, $to);
$moduleObj = new $moduleName();
foreach ($moduleAnalysisResults as $key => &$val) {
    $val = $moduleObj->$key($analysis);
}

myVarDump($moduleAnalysisResults);

// do pre-conversion
$textConverted = new DataInput($text, $to);
switch ($to) {
    case 'sc':
        $pseudoSctc->convertDataInput($textConverted, 'sc');
        break;
    case 'tc':
    case 'hk':
    case 'tw':
        $pseudoSctc->convertDataInput($textConverted, 'tc');
        break;
    default:
        die('$to is not legal...');
}

// do module replacements
if ($moduleAnalysisResults['load_or_not']) {
    triggerModuleHook($moduleObj, $textConverted, 'before');
    foreach ($moduleAnalysisResults['conversion_table'] as $search => &$replace) {
        do {
            $textConverted->text = preg_replace(
                "/$search/uiS",
                $replace,
                $textConverted->text,
                -1,
                $repCnt
            );
        } while ($moduleAnalysisResults['loop_or_not'] && $repCnt!=0);
    }
    triggerModuleHook($moduleObj, $textConverted, 'after');
}

// the text after conversion
myVarDump($textConverted->text);

//////////
// misc //
//////////

function myVarDump () {
    ob_start();
    // redirect to var_dump()
    call_user_func_array('var_dump', func_get_args());
    $out = ob_get_contents();
    ob_end_clean();
    // executed from the webserver?
    if (php_sapi_name() != 'cli') {
        $out = str_replace('  ', ' &nbsp;', $out);
        $out = nl2br($out);
    }
    echo $out;
}

/**
 * trigger the hook in modules
 * @param  object     &$moduleObj  [the module]
 * @param  DataInput  $in          [a data structure that contains $text and $to]
 * @param  string     $beforeAfter ["before" / "after"]
 * @return none
 */
function triggerModuleHook (&$moduleObj, DataInput &$in, $beforeAfter) {
    static $hookMap = array(
        'sc' => 'Simplifize',
        'tc' => 'Transitionalize',
        'hk' => 'Hongkongize',
        'tw' => 'Taiwanize',
    );
    // check args
    if (!array_key_exists($in->to, $hookMap)) return;
    // construct the name of the hook method
    $hookLang = $hookMap[$in->to];
    $beforeAfter = ucfirst(strtolower($beforeAfter));
    $hookFunc = "hook{$beforeAfter}_{$hookLang}";
    // trigger hook
    if (!method_exists($moduleObj, $hookFunc)) return;
    $moduleObj->$hookFunc($in);
}

class pseudoSctc {

    static private $scMap = array();
    static private $tcMap = array();

    public function __construct () {
        include dirname(__FILE__).'/base/ZhConversion_fast.php';
        self::$scMap = preg_split('//u', $_table_sc, -1, PREG_SPLIT_NO_EMPTY);
        self::$tcMap = preg_split('//u', $_table_tc, -1, PREG_SPLIT_NO_EMPTY);
    }

    public function convert ($text, $toLocale) {
        switch ($toLocale) {
            case 'sc':
                $text = str_replace(self::$tcMap, self::$scMap, $text);
                break;
            case 'tc':
                $text = str_replace(self::$scMap, self::$tcMap, $text);
                break;
            default:
                echo __METHOD__." did nothing...\n";
                break;
        }
        return $text;
    }

    public function convertDataInput (DataInput &$in, $toLocale) {
        $in->text = $this->convert($in->text, $toLocale);
    }

}
