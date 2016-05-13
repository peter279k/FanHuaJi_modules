<?php

namespace XiaoFei\Fanhuaji\Module\Helper;

trait DictVariables {

    protected $_gojuon = 'あかさたなはまやらわいきしちにひみりうくすつぬふむゆるんえけせてねへめれおこそとのほもよろをがざだばぱぎじぢびぴぐずづぶぷげぜでべぺごぞどぼぽアカサタナハマヤラワイキシチニヒミリウクスツヌフムユルンエケセテネヘメレオコソトノホモヨロヲガザダバパギジジビピグズズブプゲゼデベペゴゾドボポゃゅょャュョァィゥェォっッヶー々';
    protected $_nameDelimiters = '．•·';
    protected $_punctuations = ',，.…。、~～－!！?？;；';
    protected $_people = '你妳您汝爾咱俺余我他她它牠祂誰們';
    protected $_peopleRegex = '(?:[你妳您汝爾咱俺余我他她它牠祂誰][們等]?)';
    protected $_modalParticles = '阿啊吧呢嗎嘛囉哩嘞吶呀嘎唷呦喲哦喔噢耶';
    protected $_cookMethods = '燻熏燒烤炸炒燉蒸煮煎熬泡醃釀';
    protected $_colors = '赤紅橙黃綠藍紫黑灰白褐棕金銀彩';

}
