<?php

/**
 * This is a module for FanHuaJi.
 * It converts 幹 to 做.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\Module\Helper\AbstractModule;

class GanToZuo extends AbstractModule {

    // module info
    public static $info = [
        'name' => '幹→做',
        'desc' => '若字幕被判斷為裏番則不會啟用此模組',
    ];

    private static $mapping = [
        // protect
        '(^\s*|[\3])幹(?=[\s　]|$)' => '$1_protect_Gan_',
        '([被樹對猛實苦])幹' => '$1_protect_Gan_',
        '能幹(?!一?[點些]別的)' => '能_protect_Gan_',
        '幹(?=[線])' => '_protect_Gan_',
        '活(?=[動力])' => '_protect_Huo_',
        // replace 幹活 - 做事
        '幹([你妳您汝咱俺我他她它牠祂誰們]+)(?![娘])([^\s　]*)幹([的]*)[活事]' => '做$1$2做$3事',
        '[干乾幹]{2}(?<!幹乾)活' => '做做事',
        '幹活幹' => '做事做',
        '幹(?![事])([的了]*)([完]|[這那][麼多少點些]*|一?[點些件]|所有|全部|[太過很好挺][多少]|[你妳您汝咱俺余我他她它牠祂誰們]+)?([的了]*)([傻蠢好壞正])?[活事]' => '做$1$2$3$4事',
        '幹([這那哪][種件]?)([^\s　]{2,4})的[活事]' => '做$1$2的事',
        '幹([^\s　事什甚麼嘛]{0,4})([這那哪][種件]?)[活事]' => '做$1$2事',
        '(?<![樂生快死絕粗]|力氣|體力)活([就都能可以]*)([幹]|做(?![啥起]|什麼|公益|環保))' => '事$1做',
        '幹([^\s　事]*)的活' => '做$1的事',
        // replace 幹 - 做
        '幹(完(?![蛋]))' => '做$1',
        '幹([對錯好]?[了點些過])(?![你妳汝我咱俺他她它祂誰其])' => '做$1',
        '幹([得的])((?:[好很挺蠻還不]*(?:[好棒錯]|俐[落索]|習慣|適應|[痛艱困窮]苦|開心|高興|漂亮|不錯))|如何|怎麼?樣|$)' => '做$1$2',
        '幹([得的])()' => '做$1$2',
        '(認真|用來|[好麼]好)幹([你妳您汝咱俺余我他她它牠祂誰們]的|[\\\\]|[\s　]|$)' => '$1做$2',
        '((?>[你妳您汝咱俺余我他她它牠祂誰們]|[子就不要]|放手)[沒來去]?|[這那]麼)幹(的)?(?=[!！?？….。吧嗎啊吶呢呀啦話]|[好壞蠢]事|[\\\\]|[\s　]|$)' => '$1做$2',
        '(^|[\3]|[\s　]|[再在來去想別怎麼會要該]|[你我他她它牠祂誰們]+|[快慢]點|[居竟突忽悻]然)幹([啊啦呀吶呢吧]|[的得不出了](?![一二兩三四五六七八九十百千萬多好幾次上]*架|[你妳汝我咱俺他她它祂誰其])|[一這那]?[點些麼]|的話|[\\\\]|[\s　]|$)' => '$1做$2',
        '(?<!^|[\3]|[\s　]|[是])幹的$' => '做的',
        '([是])([^\s　有很挺蠻好]{1,5})幹的' => '$1$2做的',
        '是幹([這那])' => '是做$1',
        '事幹([阿啊吧呢嗎囉哩嘞吶呀嘎唷喲耶]|[\\\\]|[\s　]|$)' => '事做$1',
        '幹([你妳您汝咱俺余我他她它牠祂誰們]+)?[幹做]的' => '做$1做的',
        '[干乾幹做]([就])((?>[不要想能]|可以)*)[干乾幹做]' => '做$1$2做',
        '(什麼[也都]沒|不[好用])幹(?![部事])' => '$1做',
        '([都就也])幹(?=[\\\\]|[\s　]|$)' => '$1做',
        '死([干乾幹做])[活事]([干乾幹做])' => '死幹活幹',
        // replace 活 - 事
        '([的些點有雜]|[日天周週月年]|小?時|[秒分]鐘|[什甚]麼)活([阿啊吧呢嗎囉哩嘞吶呀嘎唷喲耶]|[也還]|[\\\\]|[\s　]|$)' => '$1事$2',
        // restore protections
        '_protect_Huo_' => '活',
        '_protect_Gan_' => '幹',
    ];

    private static $keywordPorn = [
        '[姦奸]',
        '射([了精在得]|出來)',
        '[精卵]子',
        '處女',
        '肉棒',
        '中出',
        '[小肉]穴(?![道])',
        '高潮',
    ];

    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, ['tw', 'hk'])) return false;
        // we do not load this module if the text is detected as a porn
        return !$this->LoadOrNotByKeywords($info->texts['tc'], self::$keywordPorn, 3, 1.5, PHP_INT_MAX);
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return self::$mapping;
    }

}
