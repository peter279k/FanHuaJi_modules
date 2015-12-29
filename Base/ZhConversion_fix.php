<?php

/**
 * This file is a quick fix for zhConversion.php.
 * By doing so, zhConversion.php can be maintained by Wikimedia.
 * @author 小斐 <admin@2d-gate.org>
 */

// 簡轉繁
$zh2Hant_fix = [
'⋯'=>'…',
'三重托盤'=>'三重托盤',
'了然並'=>'了然並', // 然並卵
'了然後'=>'了然後',
'了然而'=>'了然而',
'休克死'=>'休克死',
'作奸犯科'=>'作奸犯科',
'保险柜'=>'保險櫃',
'借助'=>'借助',
'克制得'=>'克制得',
'克拉克'=>'克拉克',
'关注'=>'關注',
'净'=>'淨',
'凈'=>'淨',
'几淨'=>'几淨',
'凱旋回'=>'凱旋回',
'凶相'=>'凶相',
'别强'=>'别强',
'卧'=>'臥',
'卷筒'=>'卷筒',
'发卷子'=>'發卷子',
'发呆'=>'發呆',
'吸油面纸'=>'吸油面纸',
'啓'=>'啟',
'啮'=>'嚙',
'喂'=>'喂',
'墨斗鱼'=>'墨斗鱼',
'墻'=>'牆',
'尓'=>'爾',
'尔'=>'爾',
'峰回答'=>'峰回答',
'并力主'=>'並力主',
'并力拚'=>'並力拚',
'并力拼'=>'並力拼',
'并力挽'=>'並力挽',
'幸幸'=>'幸幸',
'幸幸然'=>'悻悻然',
'托附近'=>'托附近',
'拮據'=>'拮据',
'挂'=>'掛',
'挂号'=>'掛號',
'挂图'=>'掛圖',
'挂帅'=>'掛帥',
'挂彩'=>'掛彩',
'挂念'=>'掛念',
'挂车'=>'掛車',
'掌柜'=>'掌櫃',
'昵'=>'暱',
'柜上'=>'櫃上',
'柜台'=>'櫃臺',
'柜子'=>'櫃子',
'欲望'=>'欲望',
'歎'=>'嘆',
'污'=>'汙',
'注定'=>'注定',
'浪費米面'=>'浪費米麵',
'淨几'=>'淨几',
'清析'=>'清晰',
'游了'=>'游了',
'游騎'=>'遊騎',
'爲'=>'為',
'瓮'=>'甕',
'痒'=>'癢',
'白費米面'=>'白費米麵',
'看表演'=>'看表演',
'着'=>'著',
'算发'=>'算發',
'粘'=>'黏',
'綫'=>'線',
'纔'=>'才',
'脣'=>'唇',
'腌'=>'醃',
'舘'=>'館',
'葉韻'=>'叶韻',
'葯'=>'藥',
'谷人'=>'谷人',
'賬'=>'帳',
'返回路'=>'返回路',
'鉆'=>'鑽',
'閑'=>'閒',
'關注'=>'關注',
'面包圍'=>'面包圍',
'面包抄'=>'面包抄',
'飈'=>'飆',
'駡'=>'罵',
'鮮于'=>'鮮于',
'鶏'=>'雞',
'麽'=>'麼',
'黑闇'=>'黑暗',
'黨項'=>'党項',
// 伙
'一伙'=>'一伙',
'大伙'=>'大伙',
'伙伴'=>'伙伴',
'伙同'=>'伙同',
'伙计'=>'伙計',
// don't convert punctuations
'‘'=>'‘',
'’'=>'’',
'“'=>'“',
'“'=>'“',
'”'=>'”',
'”'=>'”',
];

// 繁轉簡
$zh2Hans_fix = [
'剪貼簿'=>'剪贴板',
'姊'=>'姐',
'智慧型手機'=>'智能电话',
'智慧手機'=>'智能电话',
'生命跡象'=>'生命体征',
'範例'=>'示例',
'訊息'=>'信息',
'讯息'=>'信息',
'預設值'=>'默认值',
// don't convert punctuations
'「'=>'「',
'」'=>'」',
'『'=>'『',
'』'=>'』',
'｢'=>'｢',
'｣'=>'｣',
];

// 轉為台灣用語（假定輸入為繁）
$zh2TW_fix = [
'一次性暖爐'=>'暖暖包',
'一步裙'=>'西裝裙',
'一言難表'=>'一言難盡',
'中介費'=>'仲介費',
'乒乒乓乓'=>'乒乒乓乓',
'乳畜業'=>'畜牧業',
'交互式'=>'互動式',
'亭式車站'=>'候車亭',
'代用鹽'=>'低鈉鹽',
'以太網'=>'乙太網',
'便利店'=>'便利商店',
'便攜式'=>'攜帶型',
'保修期'=>'保固期',
'保值期'=>'保存期',
'保育院'=>'育幼院',
'信息素'=>'費洛蒙',
'個人訊息'=>'個人資料',
'倒計時'=>'倒數計時',
'假肢'=>'義肢',
'傳感'=>'感測',
'傳輸協議'=>'傳輸協定',
'兄弟院校'=>'姊妹校',
'充值'=>'儲值',
'光榮榜'=>'榮譽榜',
'光焦度'=>'屈光率',
'入鄉隨俗'=>'入境隨俗',
'八旗子弟'=>'紈褲子弟',
'公布什'=>'公布什',
'冒險為難'=>'冒險犯難',
'冷不丁'=>'冷不防',
'凍結他'=>'凍結他',
'初來乍到'=>'新來乍到',
'剃鬚刀'=>'刮鬍刀',
'半包價式'=>'半自助式',
'半決賽'=>'準決賽',
'半邊家庭'=>'單親家庭',
'博客'=>'部落格',
'卜算子'=>'卜算子',
'厄爾尼諾現象'=>'聖嬰現象',
'原音帶'=>'原聲帶',
'可入肺顆粒物'=>'細懸浮微粒',
'向風針'=>'風向儀',
'吸鐵石'=>'磁鐵',
'商標菜'=>'招牌菜',
'喇叭筒'=>'擴音器',
'單本劇'=>'單元劇',
'固件'=>'韌體',
'圓珠筆'=>'原子筆',
'土豆'=>'馬鈴薯',
'土豆片'=>'洋芋片',
'土豆餅'=>'薯餅',
'塑料'=>'塑膠',
'墩布'=>'拖把',
'妖娥子'=>'鬼點子',
'宇航員'=>'太空人',
'完型填空'=>'克漏字',
'完結他'=>'完結他',
'宣布什'=>'宣布什',
'寬心丸'=>'定心丸',
'對不住'=>'對不起',
'導火索'=>'導火線',
'小菜一碟'=>'易如反掌',
'尖子'=>'資優',
'局域網路?'=>'區域網路',
'布什麼'=>'布什麼',
'幼兒園'=>'幼稚園',
'後備箱'=>'後車箱',
'復映片'=>'二輪片',
'感嘆號'=>'驚嘆號',
'慈悲殺人'=>'安樂死',
'手柄'=>'手把',
'手雷'=>'手榴彈',
'扎啤'=>'生啤酒',
'打印'=>'列印',
'打印機'=>'印表機',
'打橫泡'=>'攪局',
'打算子'=>'打算子',
'批量'=>'批次',
'拉尼娜現象'=>'反聖嬰現象',
'指節套環'=>'手指虎',
'掃描儀'=>'掃描器',
'插班生'=>'轉學生',
'擴展名'=>'副檔名',
'故事片'=>'劇情片',
'救火車'=>'消防車',
'救生盒'=>'急救箱',
'數據庫'=>'資料庫',
'數據挖掘'=>'資料探勘',
'文娛活動'=>'康樂活動',
'新學員'=>'新生',
'方便罐'=>'調理包',
'方方面面'=>'各個方面',
'旅遊農業'=>'觀光農業',
'日界線'=>'國際換日線',
'晶體管'=>'電晶體',
'智力激勵'=>'腦力激盪',
'智力玩具'=>'益智玩具',
'智能電話'=>'智慧手機',
'暗箱操作'=>'黑箱作業',
'曲別針'=>'迴紋針',
'服務器'=>'伺服器',
'本地硬盤'=>'本機硬碟',
'本科生'=>'大學生',
'本立德溶液'=>'本氏液',
'核聚變'=>'核融合',
'核裂變'=>'核分裂',
'業餘活動'=>'休閒活動',
'步談機'=>'對講機',
'殘次品'=>'瑕疵品',
'比特率'=>'位元率',
'水門汀'=>'水泥',
'沙囊'=>'砂囊',
'沸點新聞'=>'焦點新聞',
'洗手池'=>'洗手臺',
'源代碼'=>'原始碼',
'激光'=>'激光', // dont use Wiki's conversion
'火花塞'=>'火星塞',
'灰色影片'=>'大爛片',
'炊事員'=>'廚師',
'無繩電話'=>'無線電話',
'熒光劑'=>'螢光劑',
'熒光增白劑'=>'螢光劑',
'熒光燈'=>'日光燈',
'熱敏紙'=>'感熱紙',
'獼猴桃'=>'奇異果',
'生命體徵'=>'生命跡象',
'界面'=>'界面',
'發布什'=>'發布什',
'盤算子'=>'盤算子',
'目不暇接'=>'目不暇給',
'盲人學校'=>'啟明學校',
'眼前一亮'=>'眼睛一亮',
'知識產權'=>'智慧財產權',
'神算子'=>'神算子',
'票販子'=>'黃牛',
'空中大學'=>'電視大學',
'空中客車'=>'空中巴士',
'立交橋'=>'交流道',
'終結他'=>'終結他',
'網盤'=>'網路硬碟',
'編程語言'=>'程式語言',
'縮略圖'=>'縮圖',
'總結他'=>'總結他',
'老視眼'=>'老花眼',
'胡克定律'=>'虎克定律',
'航天員'=>'太空人',
'芯片'=>'晶片',
'茄子煲'=>'蒸茄子',
'蒸騰作用'=>'蒸散作用',
'處對象'=>'談戀愛',
'虛擬現實'=>'虛擬實境',
'衛生間'=>'洗手間',
'計算子'=>'計算子',
'調製解調器'=>'數據機',
'貸學金'=>'助學貸款',
'赤黴素'=>'激勃素',
'走讀生'=>'通勤生',
'超大規模集成電路'=>'超大型積體電路',
'踏腳石'=>'墊腳石',
'軟件包'=>'套裝軟體',
'軟包裝'=>'鋁箔包',
'軟罐頭'=>'調理包',
'迴形針'=>'迴紋針',
'通宵電影'=>'午夜場',
'連字符'=>'連字號',
'過家家'=>'扮家家酒',
'過街橋'=>'天橋',
'郵遞員'=>'郵差',
'重磅炸彈'=>'震撼彈',
'門戶網站'=>'入口網站',
'阿司匹林'=>'阿司匹靈',
'阿姆斯特登'=>'阿姆斯特丹',
'除塵器'=>'吸塵器',
'陳芝麻爛穀子'=>'陳腔濫調',
'集成電路'=>'積體電路',
'集成電路卡'=>'晶片卡',
'集裝箱'=>'貨櫃',
'雲存儲'=>'雲端儲存',
'雲計算'=>'雲端計算',
'零花錢'=>'零用錢',
'電影片道'=>'電視頻道',
'電暖鍋'=>'電鍋',
'面巾紙'=>'面紙',
'頭腦風暴'=>'腦力激盪',
'顯像管'=>'映像管',
'餐鴿'=>'肉鴿',
'駭客松'=>'黑客松',
'高速緩存'=>'快取記憶體',
'魔道士'=>'魔導士',
'麵包圈'=>'甜甜圈',
'黃油'=>'奶油',
'黑客'=>'駭客',
'鼻飼管'=>'鼻胃管',
];

// 轉為香港用語（假定輸入為繁）
$zh2HK_fix = [
'什麼'=>'甚麼',
'出租車'=>'的士',
'卜算子'=>'卜算子',
'對不起'=>'對不住',
'特地'=>'特意',
'神算子'=>'神算子',
'計程車'=>'的士',
'這次'=>'今次',
'阿姆斯特登'=>'阿姆斯特丹',
'零用錢'=>'零花錢',
];

// 轉為大陸用語（假定輸入為簡）
$zh2CN_fix = [
];
