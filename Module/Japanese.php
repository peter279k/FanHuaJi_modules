<?php

/**
 * This is a special module for FanHuaJi.
 * It's used to correct Japanese Kanji misconversions.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module;

use XiaoFei\Fanhuaji\Module\Helper\ModuleInterface;
use XiaoFei\Fanhuaji\Module\Helper\ModuleTrait;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;
use XiaoFei\Fanhuaji\DataType\MbString;

class Japanese implements ModuleInterface {

    use ModuleTrait;

    // module info
    public static $info = [
        'name' => '日文漢字校正',
        'desc' => '修正日文漢字在繁簡轉換時被誤轉的錯誤',
    ];

    private $encoding = 'UTF-8';

    private $options  = [];
    private $optionsDefault = [
        'ignoreNewLines' => false, // this will treat \r\n as Japanese chars
    ];

    // data from Wikipedia ( http://zh.wikipedia.org/wiki/%E5%B8%B8%E7%94%A8%E6%BC%A2%E5%AD%97 )
    private $gojuon     = 'あかさたなはまやらわいきしちにひみりうくすつぬふむゆるんえけせてねへめれおこそとのほもよろをがざだばぱぎじぢびぴぐずづぶぷげぜでべぺごぞどぼぽアカサタナハマヤラワイキシチニヒミリウクスツヌフムユルンエケセテネヘメレオコソトノホモヨロヲガザダバパギジジビピグズズブプゲゼデベペゴゾドボポゃゅょャュョァィゥェォっッヶー々';
    private $toyokanji  = '一丁七丈三上下不且世丘丙中丸丹主久乏乗乙九乳乾乱了事二互五井亜亡交享京人仁今介仕他付代令以仰仲件任企伏伐休伯伴伸伺似但位低住佐何仏作佳使来例侍供依侮侯侵便係促俊俗保信修俳俵併倉個倍倒候借倣値倫仮偉偏停健側偶傍傑備催伝債傷傾働像僚偽僧価儀億倹儒償優元兄充兆先光克免児入内全両八公六共兵具典兼冊再冒冗冠冬冷准凍凝凡凶出刀刃分切刈刊刑列初判別利到制刷券刺刻則削前剖剛剰副割創劇剤剣力功加劣助努効劾勅勇勉動勘務勝労募勢勤勲励勧勺匁包化北匠匹匿区十千升午半卑卒卓協南博占印危却卵巻卸即厘厚原去参又及友反叔取受口古句叫召可史右司各合吉同名后吏吐向君吟否含呈呉吸吹告周味呼命和咲哀品員哲唆唐唯唱商問啓善喚喜喪喫単嗣嘆器噴嚇厳嘱囚四回因困固圏国囲園円図団土在地坂均坊坑坪垂型埋城域執培基堂堅堤堪報場塊塑塔塗境墓墜増墨堕墳墾壁壇圧塁壊士壮壱寿夏夕外多夜夢大天太夫央失奇奉奏契奔奥奪奨奮女奴好如妃妊妙妥妨妹妻姉始姓委姫姻姿威娘娯娠婆婚婦婿媒嫁嫡嬢子孔字存孝季孤孫学宅宇守安完宗官宙定宜客宣室宮宰害宴家容宿寂寄密富寒察寡寝実寧審写寛寮宝寸寺封射将専尉尊尋対導小少就尺尼尾尿局居届屈屋展層履属山岐岩岸峠峰島峡崇崩岳川州巡巣工左巧巨差己市布帆希帝帥師席帳帯常帽幅幕幣干平年幸幹幻幼幽幾床序底店府度座庫庭庶康庸廉廊廃広庁延廷建弊式弓弔引弟弦弧弱張強弾形彩彫彰影役彼往征待律後徐径徒得従御復循微徴徳徹心必忌忍志忘忙忠快念怒怖思怠急性怪恒恐恥恨恩恭息悦悔悟患悲悼情惑惜恵悪惰悩想愁愉意愚愛感慎慈態慌慕惨慢慣慨慮慰慶憂憎憤憩憲憶憾懇応懲懐懸恋成我戒戦戯戸房所扇手才打扱扶批承技抄抑投抗折抱抵押抽払拍拒拓抜拘拙招拝括拷拾持指振捕捨掃授掌排掘掛採探接控推措描提揚換握掲揮援損揺捜搬携搾摘摩撤撮撲擁択撃操担拠擦挙擬拡摂支収改攻放政故叙教敏救敗敢散敬敵敷数整文斗料斜斤斥新断方施旅旋族旗既日旨早旬昇明易昔星映春昨昭是時晩昼普景晴晶暇暑暖暗暫暮暴暦曇暁曜曲更書替最会月有服朕朗望朝期木未末本札朱机朽材村束杯東松板析林枚果枝枯架柄某染柔査柱柳校株核根格栽桃案桑梅条械棄棋棒森棺植業極栄構概楽楼標枢模様樹橋機横検桜欄権次欲欺款歌欧歓止正歩武歳歴帰死殉殊殖残段殺殿殴母毎毒比毛氏民気水氷永求汗汚江池決汽沈没沖河沸油治沼沿況泉泊泌法波泣注泰泳洋洗津活派流浦浪浮浴海浸消渉液涼淑涙淡浄深混清浅添減渡測港渇湖湯源準温溶滅滋滑滞滴満漁漂漆漏演漢漫漸潔潜潤潮渋澄沢激濁濃湿済濫浜滝瀬湾火灰災炊炎炭烈無焦然煮煙照煩熟熱燃燈焼営燥爆炉争為爵父片版牛牧物牲特犠犬犯状狂狩狭猛猶獄独獲猟獣献玄率玉王珍珠班現球理琴環璽甘生産用田由甲申男町界畑畔留畜畝略番画異当畳疎疑疫疲疾病症痘痛痢痴療癖登発白百的皆皇皮盆益盛盗盟尽監盤目盲直相盾省看真眠眼睡督瞬矛矢知短石砂砲破研硝硫硬碁砕碑確磁礁礎示社祈祉秘祖祝神祥票祭禁禍福禅礼秀私秋科秒租秩移税程稚種称稲稿穀積穂穏穫穴究空突窒窓窮窯窃立並章童端競竹笑笛符第筆等筋筒答策箇算管箱節範築篤簡簿籍米粉粒粗粘粧粋精糖糧系糾紀約紅紋納純紙級紛素紡索紫累細紳紹紺終組結絶絞絡給統糸絹経緑維綱網綿緊緒線締縁編緩緯練縛県縫縮縦総績繁織繕絵繭繰継続繊欠罪置罰署罷羊美着群義羽翁翌習翼老考者耐耕耗耳聖聞声職聴粛肉肖肝肥肩肪肯育肺胃背胎胞胴胸能脂脅脈脚脱脹腐腕脳腰腸腹膚膜膨胆臓臣臨自臭至致台与興旧舌舎舗舞舟航般舶船艇艦良色芋芝花芳芽苗若苦英茂茶草荒荷荘茎菊菌菓菜華万落葉著葬蒸蓄薄薦薪薫蔵芸薬藩虐処虚虜虞号蚊融虫蚕蛮血衆行術街衝衛衡衣表衰衷袋被裁裂裏裕補装裸製複襲西要覆見規視親覚覧観角解触言訂計討訓託記訟訪設許訴診詐詔評詞詠試詩詰話該詳誇誌認誓誕誘語誠誤説課調談請論諭諮諸諾謀謁謄謙講謝謡謹証識譜警訳議護誉読変譲谷豆豊豚象豪予貝貞負財貢貧貨販貫責貯弐貴買貸費貿賀賃賄資賊賓賜賞賠賢売賦質頼購贈賛赤赦走赴起超越趣足距跡路跳踊踏践躍身車軌軍軒軟軸較載軽輝輩輪輸轄転辛弁辞辱農込迅迎近返迫迭述迷追退送逃逆透逐途通速造連逮週進逸遂遇遊運遍過道達違逓遠遣適遭遅遵遷選遺避還辺邦邪邸郊郎郡部郭郵都郷配酒酢酬酪酵酷酸酔醜医醸釈里重野量金針鈍鈴鉛銀銃銅銑銘鋭鋼録錘錠銭錯錬鍛鎖鎮鏡鐘鉄鋳鑑鉱長門閉開閑間閣閥閲関防阻附降限陛院陣除陪陰陳陵陶陥陸陽隆隊階隔際障隣随険隠隷隻雄雅集雇雌双雑離難雨雪雲零雷電需震霜霧露霊青静非面革音韻響頂項順預頒領頭題額顔願類顧顕風飛翻食飢飲飯飼飽飾養餓余館首香馬駐騎騰騒駆験驚駅骨髄体高髪闘鬼魂魅魔魚鮮鯨鳥鳴鶏塩麗麦麻黄黒黙点党鼓鼻斎歯齢';
    private $extraKanji = '挨曖宛嵐畏萎椅彙茨咽淫唄鬱怨媛艶旺岡臆俺苛牙瓦楷潰諧崖蓋骸柿顎葛釜鎌韓玩伎亀毀畿臼嗅巾僅錦惧串窟熊詣憬稽隙桁拳鍵舷股虎錮勾梗喉乞傲駒頃痕沙挫采塞埼柵刹拶斬恣摯餌鹿叱嫉腫呪袖羞蹴憧拭尻芯腎須裾凄醒脊戚煎羨腺詮箋膳狙遡曽爽痩踪捉遜汰唾堆戴誰旦綻緻酎貼嘲捗椎爪鶴諦溺塡妬賭藤瞳栃頓貪丼那奈梨謎鍋匂虹捻罵剝箸氾汎阪斑眉膝肘訃阜蔽餅璧蔑哺蜂貌頰睦勃昧枕蜜冥麺冶弥闇喩湧妖瘍沃拉辣藍璃慄侶瞭瑠呂賂弄籠麓脇猿凹渦靴稼拐涯垣殻潟喝褐缶頑挟矯襟隅渓蛍嫌洪溝昆崎皿桟傘肢遮蛇酌汁塾尚宵縄壌唇甚据杉斉逝仙栓挿曹槽藻駄濯棚挑眺釣塚漬亭偵泥搭棟洞凸屯把覇漠肌鉢披扉猫頻瓶雰塀泡俸褒朴僕堀磨抹岬妄厄癒悠羅竜戻枠';

    // my own defined text
    private $extraKanji2    = '坤蝉澤剥碍逢繋尨倶冨巌廼弍彦掴灯焔罸聡蒋遥騨鬪凛撫云瀾涸子丑寅卯辰巳午未申酉戌亥劫芦鮎馴懺棲栖霞祐卐卍痍龍綺訊禄魍魎瓢箪躯蠅倡娼壜罎遙搖謠蒔檗'; // added by myself
    private $kanjiMustBeJpn = '歩両乗亀亜仏仮伝価倹児処剣剤剰労効勅勧勲単厳収営団囲図圧塀塁壊壱売変奨実寛対専巣帯帰庁広廃弐弾従徳応恵悩悪懐戦戻払抜択拝拠拡挙挿捜掲揺摂斉斎暁暦曽栄桜桟検楽様権歓歯歴毎気浄涙渇済渉渋渓満滝焼猟獣畳発県砕稲穂穏竜粋粛経絵継続総緑縁縄縦繊聴脳荘蔵薬蛍覚観訳読謡豊賛転軽辺逓遅郷酔釈鉄鉱銭鋳錬録関闘陥険隠雑霊頼顕駆騒験髄髪鶏黒黙齢聡凛氷衆浜巌鮎歳値遥';
    private $punctuations   = "\t 　.．…、。~～!！?？·•・×☆★"; // punctuations are considered as Japanese as well
    private $numbers        = "0123456789０１２３４５６７８９#＃%％"; // numbers are considered as Japanese as well
    private $symbols        = "a-z\d+\\-*\\/#&"; // regex: chars in ASS tags, but this should be handle in the pre-processing module

    // do not touch these, basically
    private $charPreserved   = "\\2\\3"; // chars that are used in other modules to shorten the input
    private $newLineChars    = "\r\n";
    private $symbolsRegex    = 'generated in the constructor';
    private $jpnChars        = 'generated in the constructor';
    private $mayBeJpnChars   = 'generated in the constructor';
    private $mbMayBeJpnChars = 'generated in the constructor';
    private $mustBeJpn       = 'generated in the constructor';
    private $mbMustBeJpn     = 'generated in the constructor';
    // char-to-char fixes
    private $fixesJpnChar = [
        // IMPORTANT: text length should NOT be changed in these replacements
        // tc -> jp
        '剝' => '剥', '乘' => '乗', '亂' => '乱', '佔' => '占', '佛' => '仏',
        '來' => '来', '值' => '値', '假' => '仮', '傳' => '伝', '價' => '価',
        '兒' => '児', '內' => '内', '兩' => '両', '冰' => '氷', '剎' => '刹',
        '劃' => '画', '劍' => '剣', '區' => '区', '卷' => '巻', '卻' => '却',
        '參' => '参', '啟' => '啓', '單' => '単', '噓' => '嘘', '嚴' => '厳',
        '國' => '国', '圍' => '囲', '圖' => '図', '團' => '団', '壓' => '圧',
        '壞' => '壊', '壯' => '壮', '壽' => '寿', '奧' => '奥', '姊' => '姉',
        '姐' => '姉', '姬' => '姫', '孃' => '嬢', '學' => '学', '寢' => '寝',
        '實' => '実', '寫' => '写', '寶' => '宝', '將' => '将', '對' => '対',
        '屆' => '届', '屬' => '属', '帶' => '帯', '廚' => '厨', '廣' => '広',
        '廳' => '庁', '彌' => '弥', '彥' => '彦', '從' => '従', '悅' => '悦',
        '惠' => '恵', '惡' => '悪', '惱' => '悩', '應' => '応', '戀' => '恋',
        '戰' => '戦', '戲' => '戯', '戱' => '戯', '戶' => '戸', '拂' => '払',
        '插' => '挿', '揭' => '掲', '摑' => '掴', '擇' => '択', '擔' => '担',
        '擴' => '拡', '攜' => '携', '攝' => '摂', '收' => '収', '數' => '数',
        '斷' => '断', '晝' => '昼', '曬' => '晒', '曾' => '曽', '會' => '会',
        '果' => '裹', '條' => '条', '榮' => '栄', '樂' => '楽', '祿' => '禄',
        '樣' => '様', '橫' => '横', '檢' => '検', '權' => '権', '歐' => '欧',
        '步' => '歩', '歷' => '歴', '歸' => '帰', '殘' => '残', '氣' => '気',
        '沒' => '没', '淒' => '凄', '淚' => '涙', '淨' => '浄', '淺' => '浅',
        '溫' => '温', '滿' => '満', '潛' => '潜', '澤' => '沢', '濟' => '済',
        '濱' => '浜', '瀉' => '潟', '灣' => '湾', '燈' => '灯', '燒' => '焼',
        '營' => '営', '爭' => '争', '狀' => '状', '狹' => '狭', '挾' => '挟',
        '獨' => '独', '獻' => '献', '畫' => '画', '當' => '当', '瘦' => '痩',
        '發' => '発', '盡' => '尽', '眾' => '衆', '禪' => '禅', '禮' => '礼',
        '禱' => '祷', '稅' => '税', '稱' => '称', '稻' => '稲', '窗' => '窓',
        '絕' => '絶', '絲' => '糸', '經' => '経', '綠' => '緑', '緣' => '縁',
        '縣' => '県', '縱' => '縦', '總' => '総', '繩' => '縄', '繪' => '絵',
        '繼' => '継', '聲' => '声', '聽' => '聴', '脫' => '脱', '腦' => '脳',
        '腳' => '脚', '膽' => '胆', '臺' => '台', '與' => '与', '舊' => '旧',
        '莊' => '荘', '萬' => '万', '著' => '着', '藏' => '蔵', '藝' => '芸',
        '藥' => '薬', '虛' => '虚', '號' => '号', '螢' => '蛍', '蟲' => '虫',
        '蠻' => '蛮', '裝' => '装', '裡' => '裏', '覺' => '覚', '觀' => '観',
        '觸' => '触', '說' => '説', '證' => '証', '譯' => '訳', '簞' => '箪',
        '譽' => '誉', '讀' => '読', '變' => '変', '豐' => '豊', '貓' => '猫',
        '賣' => '売', '續' => '続', '贊' => '賛', '踴' => '踊', '蹟' => '跡',
        '轉' => '転', '辭' => '辞', '遲' => '遅', '預' => '予', '邊' => '辺',
        '鄉' => '郷', '醫' => '医', '錄' => '録', '錢' => '銭', '鎗' => '銃',
        '鐵' => '鉄', '閱' => '閲', '關' => '関', '隱' => '隠', '雙' => '双',
        '雜' => '雑', '靜' => '静', '餘' => '余', '驅' => '駆', '驗' => '験',
        '驛' => '駅', '體' => '体', '鬥' => '鬪', '鹽' => '塩', '麥' => '麦',
        '麵' => '麺', '黃' => '黄', '黑' => '黒', '點' => '点', '恆' => '恒',
        '龜' => '亀', '蟬' => '蝉', '增' => '増', '黨' => '党', '凜' => '凛',
        '勵' => '励', '慘' => '惨', '禦' => '御', '盜' => '盗', '嶽' => '岳',
        '隨' => '随', '濕' => '湿', '礙' => '碍', '繫' => '繋',
        '罐' => '缶', '彪' => '尨', '辨' => '弁', '瓣' => '弁', '辯' => '弁',
        '饑' => '飢', '蠶' => '蚕', '閒' => '閑', '妝' => '粧', '雞' => '鶏',
        '亞' => '亜', '俱' => '倶', '儉' => '倹', '富' => '冨', '鯰' => '鮎',
        '處' => '処', '劑' => '剤', '剩' => '剰', '勞' => '労', '勸' => '勧',
        '勳' => '勲', '囑' => '嘱', '墮' => '堕', '壘' => '塁', '壤' => '壌',
        '壹' => '壱', '獎' => '奨', '娛' => '娯', '寬' => '寛', '專' => '専',
        '峽' => '峡', '巖' => '巌', '廢' => '廃', '迺' => '廼', '貳' => '弐',
        '彈' => '弾', '徑' => '径', '德' => '徳', '徵' => '徴', '懷' => '懐',
        '拜' => '拝', '據' => '拠', '舉' => '挙', '擊' => '撃',
        '齊' => '斉', '齋' => '斎', '曉' => '暁', '曆' => '暦', '樞' => '枢',
        '查' => '査', '櫻' => '桜', '棧' => '桟', '樓' => '楼', '歡' => '歓',
        '齒' => '歯', '歲' => '歳', '毆' => '殴', '澀' => '渋', '涉' => '渋',
        '溪' => '渓', '瀧' => '滝', '滯' => '滞', '瀨' => '瀬', '爐' => '炉',
        '焰' => '焔', '犧' => '犠', '獵' => '猟', '獸' => '獣', '產' => '産',
        '疊' => '畳', '碎' => '砕', '穗' => '穂', '穩' => '穏', '竊' => '窃',
        '粹' => '粋', '肅' => '粛', '纖' => '繊', '聰' => '聡', '軀' => '躯',
        '臟' => '臓', '舖' => '舗', '莖' => '茎', '蔣' => '蒋', '霸' => '覇',
        '覽' => '覧', '讓' => '譲', '踐' => '践', '輕' => '軽',
        '遞' => '逓', '醉' => '酔', '釀' => '醸', '釋' => '釈',
        '礦' => '鉱', '鑄' => '鋳', '陷' => '陥', '險' => '険', '鄰' => '隣',
        '靈' => '霊', '賴' => '頼', '顏' => '顔', '顯' => '顕', '騷' => '騒',
        '驔' => '騨', '髓' => '髄', '鷄' => '鶏', '默' => '黙', '齡' => '齢',
        '拔' => '抜', '慾' => '欲', '迴' => '回', '週' => '周', '兇' => '凶',
        '蹤' => '踪', '蘆' => '芦', '鬆' => '松', '灑' => '洒', '黏' => '粘',
        // sc -> jp
        '丑' => '醜', '专' => '専', '业' => '業', '东' => '東', '丝' => '糸',
        '两' => '両', '严' => '厳', '丧' => '喪', '个' => '個', '丰' => '豊',
        '临' => '臨', '为' => '為', '丽' => '麗', '举' => '挙', '义' => '義',
        '乐' => '楽', '习' => '習', '乡' => '郷', '书' => '書', '买' => '買',
        '云' => '雲', '亚' => '亜', '产' => '産', '亩' => '畝', '亲' => '親',
        '亿' => '億', '仅' => '僅', '从' => '従', '仓' => '倉', '仪' => '儀',
        '价' => '価', '众' => '衆', '优' => '優', '伞' => '傘', '伟' => '偉',
        '传' => '伝', '伤' => '傷', '伦' => '倫', '伪' => '偽', '侣' => '侶',
        '侦' => '偵', '侧' => '側', '俭' => '倹', '债' => '債', '倾' => '傾',
        '偿' => '償', '儿' => '児', '关' => '関', '兴' => '興', '养' => '養',
        '兽' => '獣', '冈' => '岡', '册' => '冊', '军' => '軍', '农' => '農',
        '冢' => '塚', '冲' => '衝', '决' => '決', '况' => '況', '冻' => '凍',
        '净' => '浄', '准' => '準', '凉' => '涼', '减' => '減', '几' => '幾',
        '击' => '撃', '划' => '画', '则' => '則', '刚' => '剛', '创' => '創',
        '别' => '別', '剂' => '剤', '剑' => '剣',
        '剧' => '劇', '劝' => '勧', '务' => '務', '动' => '動', '劳' => '労',
        '势' => '勢', '勋' => '勲', '勐' => '猛', '华' => '華', '协' => '協',
        '单' => '単', '卖' => '売', '卫' => '衛', '厅' => '庁', '历' => '暦',
        '压' => '圧', '县' => '県', '发' => '発', '变' => '変', '叠' => '畳',
        '叶' => '葉', '后' => '後', '吓' => '嚇', '吕' => '呂', '忏' => '懺',
        '听' => '聴', '启' => '啓', '呗' => '唄', '员' => '員', '咏' => '詠',
        '响' => '響', '唤' => '喚', '唿' => '呼', '喷' => '噴', '团' => '団',
        '园' => '園', '围' => '囲', '图' => '図', '圣' => '聖', '场' => '場',
        '坏' => '壊', '块' => '塊', '坚' => '堅', '坛' => '壇',
        '坟' => '墳', '坠' => '墜', '垒' => '塁', '垦' => '墾', '处' => '処',
        '备' => '備', '复' => '複', '头' => '頭', '夸' => '誇', '夺' => '奪',
        '奋' => '奮', '奖' => '奨', '妆' => '粧', '妇' => '婦', '娱' => '娯',
        '孙' => '孫', '宁' => '寧', '实' => '実', '审' => '審', '宪' => '憲',
        '宫' => '宮', '宽' => '寛', '宾' => '賓', '对' => '対', '寻' => '尋',
        '导' => '導', '层' => '層', '岁' => '歳', '岚' => '嵐', '岛' => '島',
        '嵴' => '脊', '币' => '幣', '帅' => '帥', '师' => '師', '帐' => '帳',
        '带' => '帯', '并' => '並', '广' => '広', '庄' => '荘',
        '庆' => '慶', '库' => '庫', '应' => '応', '废' => '廃', '开' => '開',
        '异' => '異', '弃' => '棄', '张' => '張', '弹' => '弾', '归' => '帰',
        '录' => '録', '彻' => '徹', '忆' => '憶', '忧' => '憂',
        '怀' => '懐', '态' => '態', '总' => '総', '恳' => '懇', '恶' => '悪',
        '恼' => '悩', '悬' => '懸', '惊' => '驚', '惩' => '懲', '惯' => '慣',
        '愤' => '憤', '愿' => '願', '戏' => '戯', '战' => '戦', '户' => '戸',
        '扑' => '撲', '执' => '執', '扩' => '拡', '扫' => '掃', '扬' => '揚',
        '抚' => '撫', '护' => '護', '报' => '報', '拟' => '擬', '拥' => '擁',
        '择' => '択', '挂' => '掛', '挚' => '摯', '挥' => '揮', '损' => '損',
        '换' => '換', '据' => '拠', '摄' => '摂', '摇' => '揺', '敌' => '敵',
        '斋' => '斎', '斗' => '鬪', '斩' => '斬', '无' => '無', '时' => '時',
        '昙' => '曇', '显' => '顕', '晓' => '暁', '暂' => '暫', '暧' => '曖',
        '术' => '術', '杀' => '殺', '杂' => '雑', '权' => '権', '龟' => '亀',
        '杰' => '傑', '极' => '極', '构' => '構', '枪' => '銃', '栅' => '柵',
        '标' => '標', '栈' => '桟', '栋' => '棟', '栏' => '欄', '树' => '樹',
        '样' => '様', '桥' => '橋', '梦' => '夢', '检' => '検', '樱' => '桜',
        '欢' => '歓', '毁' => '毀', '气' => '気', '汇' => '彙', '汉' => '漢',
        '汤' => '湯', '沟' => '溝', '泪' => '涙', '泷' => '滝', '泻' => '潟',
        '泽' => '澤', '洁' => '潔', '浊' => '濁', '测' => '測', '济' => '済',
        '浓' => '濃', '涂' => '塗', '涌' => '湧', '涡' => '渦', '润' => '潤',
        '涩' => '渋', '渍' => '漬', '渐' => '漸', '渔' => '漁', '游' => '遊',
        '溃' => '潰', '满' => '満', '滨' => '浜', '漤' => '濫', '澜' => '瀾',
        '濑' => '瀬', '灭' => '滅', '灵' => '霊', '灾' => '災', '舍' => '捨',
        '烟' => '煙', '烦' => '煩', '烧' => '焼', '热' => '熱', '爱' => '愛',
        '牺' => '犠', '犟' => '強', '犹' => '猶', '狱' => '獄', '猎' => '猟',
        '环' => '環', '现' => '現', '玺' => '璽', '电' => '電', '疗' => '療',
        '疡' => '瘍', '盐' => '塩', '监' => '監', '盖' => '蓋', '盘' => '盤',
        '矫' => '矯', '矿' => '鉱', '础' => '礎', '确' => '確', '仆' => '僕',
        '祸' => '禍', '离' => '離', '种' => '種', '积' => '積', '稳' => '穏',
        '穷' => '窮', '窑' => '窯', '竞' => '競', '笃' => '篤', '笔' => '筆',
        '笺' => '箋', '笼' => '籠', '筑' => '築', '简' => '簡', '类' => '類',
        '粮' => '糧', '紧' => '緊', '纟' => '糸', '纠' => '糾', '赈' => '賑',
        '红' => '紅', '纤' => '繊', '约' => '約', '级' => '級', '纪' => '紀',
        '纬' => '緯', '纯' => '純', '纲' => '綱', '纳' => '納', '纵' => '縦',
        '纷' => '紛', '纸' => '紙', '纹' => '紋', '纺' => '紡', '绀' => '紺',
        '练' => '練', '组' => '組', '绅' => '紳', '细' => '細', '织' => '織',
        '终' => '終', '绍' => '紹', '经' => '経', '结' => '結', '绘' => '絵',
        '给' => '給', '络' => '絡', '绝' => '絶', '绞' => '絞', '统' => '統',
        '绢' => '絹', '继' => '継', '绩' => '績', '绪' => '緒', '续' => '続',
        '绳' => '縄', '维' => '維', '绵' => '綿', '绽' => '綻', '绿' => '緑',
        '缐' => '線', '缓' => '緩', '缔' => '締', '编' => '編', '缘' => '縁',
        '缚' => '縛', '缝' => '縫', '缩' => '縮', '缮' => '繕', '缲' => '繰',
        '网' => '網', '罗' => '羅', '罚' => '罰', '罢' => '罷', '羡' => '羨',
        '耻' => '恥', '职' => '職', '聪' => '聡', '肃' => '粛', '肠' => '腸',
        '肤' => '膚', '肾' => '腎', '肿' => '腫', '胀' => '脹', '胁' => '脅',
        '胜' => '勝', '脉' => '脈', '脏' => '臓', '脑' => '脳', '腾' => '騰',
        '舰' => '艦', '艺' => '芸', '节' => '節', '范' => '範', '茧' => '繭',
        '荐' => '薦', '荣' => '栄', '药' => '薬', '获' => '獲', '萤' => '蛍',
        '营' => '営', '蓝' => '藍', '虏' => '虜', '虑' => '慮', '补' => '補',
        '袭' => '襲', '见' => '見', '观' => '観', '规' => '規', '视' => '視',
        '览' => '覧', '觉' => '覚', '誊' => '謄', '计' => '計', '订' => '訂',
        '讣' => '訃', '认' => '認', '讨' => '討', '让' => '譲', '训' => '訓',
        '议' => '議', '讯' => '信', '记' => '記', '讲' => '講', '许' => '許',
        '论' => '論', '讼' => '訟', '设' => '設', '访' => '訪', '证' => '証',
        '评' => '評', '识' => '識', '诈' => '詐', '诉' => '訴', '诊' => '診',
        '词' => '詞', '诏' => '詔', '译' => '訳', '试' => '試', '诗' => '詩',
        '诘' => '詰', '诚' => '誠', '话' => '話', '诞' => '誕', '诠' => '詮',
        '诣' => '詣', '该' => '該', '详' => '詳', '语' => '語', '误' => '誤',
        '诱' => '誘', '说' => '説', '请' => '請', '诸' => '諸', '诺' => '諾',
        '读' => '読', '课' => '課', '谁' => '誰', '调' => '調', '谈' => '談',
        '谋' => '謀', '谐' => '諧', '谒' => '謁', '谕' => '諭', '谘' => '諮',
        '谛' => '諦', '谜' => '謎', '谢' => '謝', '谣' => '謡', '谦' => '謙',
        '谨' => '謹', '谱' => '譜', '贝' => '貝', '贞' => '貞', '谊' => '誼',
        '负' => '負', '贡' => '貢', '财' => '財', '责' => '責', '贤' => '賢',
        '败' => '敗', '货' => '貨', '质' => '質', '贩' => '販', '贪' => '貪',
        '贫' => '貧', '购' => '購', '贮' => '貯', '贯' => '貫', '贰' => '弐',
        '贴' => '貼', '贵' => '貴', '贷' => '貸', '贸' => '貿', '费' => '費',
        '贺' => '賀', '贼' => '賊', '贿' => '賄', '赁' => '賃', '赂' => '賂',
        '资' => '資', '赋' => '賦', '赌' => '賭', '赏' => '賞', '赐' => '賜',
        '赔' => '賠', '赖' => '頼', '赠' => '贈', '跃' => '躍', '车' => '車',
        '轨' => '軌', '轩' => '軒', '转' => '転', '轮' => '輪', '软' => '軟',
        '轴' => '軸', '轻' => '軽', '载' => '載', '较' => '較', '辈' => '輩',
        '辉' => '輝', '输' => '輸', '辖' => '轄', '辩' => '弁', '边' => '辺',
        '达' => '達', '迁' => '遷', '过' => '過', '运' => '運', '还' => '還',
        '进' => '進', '远' => '遠', '违' => '違', '连' => '連', '迟' => '遅',
        '迹' => '跡', '适' => '適', '选' => '選', '逊' => '遜', '递' => '逓',
        '遗' => '遺', '邮' => '郵', '邻' => '隣', '郁' => '鬱', '酿' => '醸',
        '释' => '釈', '里' => '裏', '针' => '針', '钓' => '釣', '钝' => '鈍',
        '钟' => '鐘', '钢' => '鋼', '钱' => '銭', '铁' => '鉄', '铃' => '鈴',
        '铅' => '鉛', '铜' => '銅', '铣' => '銑', '铭' => '銘', '铳' => '銃',
        '银' => '銀', '铸' => '鋳', '锁' => '鎖', '锅' => '鍋', '错' => '錯',
        '锢' => '錮', '锤' => '錘', '锦' => '錦', '锭' => '錠', '键' => '鍵',
        '锻' => '鍛', '镇' => '鎮', '镜' => '鏡', '长' => '長', '门' => '門',
        '闭' => '閉', '问' => '問', '闲' => '閑', '间' => '間', '闻' => '聞',
        '阀' => '閥', '阁' => '閣', '阅' => '閲', '队' => '隊', '阳' => '陽',
        '阴' => '陰', '阵' => '陣', '阶' => '階', '际' => '際', '陆' => '陸',
        '陈' => '陳', '险' => '険', '隐' => '隠', '难' => '難', '雾' => '霧',
        '韩' => '韓', '韵' => '韻', '顶' => '頂', '顷' => '頃', '叹' => '嘆',
        '项' => '項', '顺' => '順', '须' => '須', '顽' => '頑', '顾' => '顧',
        '顿' => '頓', '颁' => '頒', '预' => '預', '领' => '領', '颊' => '頰',
        '频' => '頻', '题' => '題', '颚' => '顎', '颜' => '顔', '额' => '額',
        '风' => '風', '飞' => '飛', '饥' => '飢', '饭' => '飯', '饮' => '飲',
        '饰' => '飾', '饱' => '飽', '饲' => '飼', '饵' => '餌', '饼' => '餅',
        '饿' => '餓', '馀' => '余', '馆' => '館', '马' => '馬', '驯' => '馴',
        '驱' => '駆', '驹' => '駒', '驻' => '駐', '驿' => '駅', '骂' => '罵',
        '验' => '験', '骑' => '騎', '骚' => '騒', '鱼' => '魚', '鲜' => '鮮',
        '鲶' => '鮎', '鲸' => '鯨', '鸟' => '鳥', '鸡' => '鶏', '鸣' => '鳴',
        '鹤' => '鶴', '齐' => '斉', '齿' => '歯', '龄' => '齢', '龙' => '竜',
    ];
    // fix Japanese word
    private $fixesJpnWord = [
        // IMPORTANT: text length should NOT be changed after replacements
        '可怜' => '可憐',
        '着作' => '著作',
        '提倡' => '提唱',
        '幾帳' => '几帳',
        '待命' => '待機',
        '([袖経文浄床脇])機' => '$1机',
        '機([案上下辺])' => '机$1',
        '千裏眼' => '千里眼',
        '([の淫])虫' => '$1蟲',
        '虫([師使]|と眼球|ども)' => '蟲$1',
        'の蟲に'=>'の虫に',
        '乾([渉涸])' => '干$1',
        '(飲み)乾' => '$1干',
        '干坤' => '乾坤',
        '葉([わえうっ]|いま|いそう)' => '叶$1',
        '今葉え' => '今叶え',
        '([結効成後因宙])裹' => '$1果',
        '裹([てた実樹物汁])' => '果$1',
        '([郷実絵])裏' => '$1里',
        '裏([実])' => '里$1',
        '(?<![根躯])幹(?![線部])' => '乾',
        '雲([いえうわ])' => '云$1',
        '拠([え])' => '据$1',
        '([見拮])拠' => '$1据',
        '予([かけ])' => '預$1',
        '醜([三時会関])' => '丑$1',
        '周([一二三四五六日間初末央休刊報給明番評足数替変]|[ご])' => '週$1',
        '([\d０１２３４５６７８９先今来次隔翌毎]|黄金)周' => '$1週',
        '([の])周(?![辺期波速長回濠囲王朝]|[り]|.?期|回路)' => '$1週',
        '([皇蟲虫])後' => '$1后',
        '後([位腹妃羿]|がね)' => '后$1',
        '([北])鬪' => '$1斗',
        '鬪([形米山南酒拱掻])' => '斗$1',
        '([海陸])栖' => '$1棲',
        '栖([息霞む]|み分)' => '棲$1',
        '([第])叁' => '$1叄',
        '叁([番])' => '叄$1',
        '灯([す])' => '燈$1',
        '透過(?![し型性])' => '通過',
    ];
    // fix Chinese word to Japanese usage
    private $fixesChiWord = [
        // IMPORTANT: text length can be changed, but NO regex should be used
        '主角' => '主人公',
        '収獲' => '収穫',
        '報導' => '報道',
        '手把' => '手柄',
        '牛奶' => '牛乳',
        '花沢' => '花澤',
        '高中' => '高校',
        '人才' => '人材',
        '小姉' => '小姐',
        '面対し'=>'直面し',
        '打点滴' => '輸液',
    ];
    // those words are not used in Chinese but in Japanese
    private $fixesJpnWordUnique = [
        // IMPORTANT: those replacements will be applied in Chinese as well
        '(?<=^|[\3]|[\s　])(本當|失禮)(?=[\s　]|[?？]|$)',
        '([國国]|電話|郵便|[個法]人|[當当]選|[製商]品|FAX)番號',
        '番號([檢検]索)',
        '通信([中])?著信',
        '(決勝|勝負)下著',
        '著物(?=[\s　]|$)',
    ];

    // constructor
    public function __construct ($options=null) {
        $encoding       = &$this->encoding;
        $gojuon         = &$this->gojuon;
        $toyokanji      = &$this->toyokanji;
        $extraKanji     = &$this->extraKanji;
        $extraKanji2    = &$this->extraKanji2;
        $kanjiMustBeJpn = &$this->kanjiMustBeJpn;
        $punctuations   = &$this->punctuations;
        $numbers        = &$this->numbers;
        $jpnChars       = &$this->jpnChars;
        $mayBeJpnChars  = &$this->mayBeJpnChars;
        $mustBeJpn      = &$this->mustBeJpn;
        // merge options
        if (is_array($options)) {
            $this->options = array_merge($this->optionsDefault, $options);
        } else {
            $this->options = $this->optionsDefault;
        }
        // generate $this->symbolsRegex
        $symbols = "{$this->symbols}{$this->charPreserved}";
        if ($this->options['ignoreNewLines']) $symbols .= $this->newLineChars;
        $this->symbolsRegex = "/([{$symbols}]+)/uimS";
        // generate $this->jpnChars, $this->mayBeJpnChars, $this->mustBeJpn
        $mayBeJpnKanji = $this->stringUnique(
            implode('',
                array_merge(
                    array_keys($this->fixesJpnChar),
                    array_values($this->fixesJpnChar),
                    array_keys($this->fixesChiWord)
                )
            )
        );
        $jpnChars      = "{$gojuon}{$toyokanji}{$extraKanji}{$extraKanji2}{$punctuations}{$numbers}";
        $mayBeJpnChars = "{$jpnChars}{$mayBeJpnKanji}";
        $mustBeJpn     = "{$gojuon}{$kanjiMustBeJpn}";
        // multi-byte strings
        $this->mbMustBeJpn     = new MbString($mustBeJpn, $encoding);
        $this->mbMayBeJpnChars = new MbString($mayBeJpnChars, $encoding);
    }

    // destructor
    public function __destruct () {
        unset($this->mbMustBeJpn, $this->mbMayBeJpnChars);
    }

    // whether load this module?
    public function load_or_not (ModuleAnalysis &$info) {
        if (!in_array($info->to, ['sc', 'tw', 'hk'])) return false;
        // activate this module only when there are Japanese chars
        return preg_match("/[{$this->mustBeJpn}]/uimS", $info->texts['tc']) === 1;
    }

    public function loop_or_not () {
        return false;
    }

    public function conversion_table (ModuleAnalysis &$info) {
        return [];
    }

    // hooks
    public function hookAfter_Simplifize     (DataInput &$in) { $this->execute($in); }
    public function hookAfter_Traditionalize (DataInput &$in) { $this->execute($in); }
    public function hookAfter_Hongkongize    (DataInput &$in) { $this->execute($in); }
    public function hookAfter_Taiwanize      (DataInput &$in) { $this->execute($in); }

    private function execute (DataInput &$in) {
        $this->correctJpnChars($in->text);
        $this->correctJpnCharsUnique($in->text);
    }

    /**
     * correct unique Japanese Kanji usage which are wrong in $text
     * @param  string $text [the text to be corrected]
     * @return none
     */
    private function correctJpnCharsUnique (&$text) {
        $callback = function (&$matches) {
            // prepend a jpn char to text to make it Japanese
            $jpChar = 'あ';
            $jpText = "{$jpChar}{$matches[0]}";
            $this->correctJpnChars($jpText);
            // return fixed text without the prepended jpn char
            return substr($jpText, strlen($jpChar));
        };
        foreach ($this->fixesJpnWordUnique as &$sr) {
            $text = preg_replace_callback("/{$sr}/uimS", $callback, $text);
        }
    }

    /**
     * correct Japanese chars which are wrong in $text
     * @param  string $text [the text to be corrected]
     * @return none
     */
    private function correctJpnChars (&$text) {
        $encoding     = &$this->encoding;
        $symbolsRegex = &$this->symbolsRegex;
        // split $text into text parts (even key) and symbol parts (odd key)
        $textSplit    = preg_split($symbolsRegex, $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $textSplitCnt = count($textSplit);
        // get text parts and concatenate them into a new string to $textNoSymbol
        // this string should have no symbol but all Chinese/Japanese/... chars
        $textNoSymbol = [];
        for ($i=0; $i<$textSplitCnt; $i+=2) $textNoSymbol[] = &$textSplit[$i];
        $textNoSymbol   = implode('', $textNoSymbol);
        $mbTextNoSymbol = new MbString($textNoSymbol, $encoding);
        // fix Japanese chars and some Japanese mis-conversions
        $fixesJpn = $this->fixesJpnChar + $this->fixesJpnWord;
        $this->replaceConsecutiveJpnChars($mbTextNoSymbol, $fixesJpn, true);
        // patch text parts in $textSplit by using $mbTextNoSymbol
        for ($i=$seek=0; $i<$textSplitCnt; $i+=2) {
            $pieceLength = MbString::static_strlen($textSplit[$i], $encoding);
            $textSplit[$i] = $mbTextNoSymbol->substr($seek, $pieceLength);
            $seek += $pieceLength;
        }
        unset($mbTextNoSymbol);
        // re-construct $mbText by concatenating $textSplit
        $mbText = new MbString(implode('', $textSplit), $encoding);
        // fix mis-conversions which are caused by other modules
        $this->replaceConsecutiveJpnChars($mbText, $this->fixesChiWord, false);
        $text = $mbText->val();
        unset($mbText);
    }

    /**
     * replace consecutive Japanese/Kanji chars with a given array
     * @param  string  $text             [the text which will be processed on]
     * @param  array   &$srRepArray      [key/value = search/replace]
     * @param  boolean $ignoreLengthDiff [true  = each search's length equals its corresponding replace's length
     *                                    false = otherwise, but regex is not allowed in $srRepArray]
     * @return none
     */
    private function replaceConsecutiveJpnChars (MbString &$mbText, &$srRepArray, $ignoreLengthDiff=false) {
        $encoding   = &$this->encoding;
        $mbText_len = $mbText->strlen();
        // search consecutive Japanese chars in $mbText
        for ($idx=0; $idx<$mbText_len; ++$idx) {
            $jpnFound = $this->searchConsecutiveJpnChars($mbText, $idx);
            if ($jpnFound === false) break;
            list($jpnStart, $jpnLength) = $jpnFound;
            // do partial replacements for $mbText
            $jpnString = $mbText->substr($jpnStart, $jpnLength);
            $textLengthDiff = 0; // text length maybe different after replacing
            foreach ($srRepArray as $sr=> &$rep) {
                $jpnString = preg_replace("/{$sr}/uimS", $rep, $jpnString, -1, $count);
                if (!$ignoreLengthDiff) {
                    $textLengthDiff += $count * (
                        MbString::static_strlen($rep, $encoding) -
                        MbString::static_strlen($sr,  $encoding));
                }
            }
            // update $mbText with $jpnString internally
            $mbText->substr_replace_i($jpnString, $jpnStart, $jpnLength);
            $idx = ($jpnStart + $jpnLength - 1) + $textLengthDiff;
        }
    }

    /**
     * search consecutive Japanese/Kanji chars
     * @param  MbString     &$mbText [the haystack]
     * @param  integer      $offset  [search neighbors to this offset]
     * @return array/false           [0/1 = position/length, false otherwise]
     */
    private function searchConsecutiveJpnChars (MbString &$mbText, $offset=0) {
        $mbText_len = $mbText->strlen();
        for ($idx=$offset; $idx<$mbText_len; ++$idx) {
            // search a Japanese char/word's location ($idx) in $mbText
            if (!$this->mbMustBeJpn->has($mbText[$idx])) continue;
            // search consecutive Japanese chars frontward
            for ($idxF=$idx-1; $idxF>=0; --$idxF) {
                if (!$this->mbMayBeJpnChars->has($mbText[$idxF])) break;
            }
            ++$idxF; // position correction
            // search consecutive Japanese chars backward
            for ($idxB=$idx+1; $idxB<$mbText_len; ++$idxB) {
                if (!$this->mbMayBeJpnChars->has($mbText[$idxB])) break;
            }
            --$idxB; // position correction
            // a Japanese region has been found
            break;
        }
        return $idx<$mbText_len ? [$idxF, $idxB-$idxF+1] : false;
    }

    ////////////////////
    // misc functions //
    ////////////////////

    /**
     * a faster implementation of array_unique(),
     * but only works on non-associate array and keys are not preserved
     * @param  array $array [input array]
     * @return array        [unique values in the input array]
     */
    private function array_unique_fast ($array) {
        $tmp = [];
        foreach ($array as &$val) $tmp[$val] = true;
        return array_keys($tmp);
    }

    /**
     * remove repeated chars in the input string
     * @param  string $string [the input string]
     * @return string         [string with repeated chars removed]
     */
    private function stringUnique ($string) {
        return implode('', $this->array_unique_fast(
            // preg_split splits a string into an array of chars
            preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY)
        ));
    }

}
