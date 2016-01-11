SCORE_ID = "#score";
TIMER_ID = "#timer";
LEVEL_ID = "#level";
TARGET_ID = "#target";
LOADING_ID = "#loading";
LIFE_ID = "#life";

LEVELEND_ID = "#levelEnd";
PLAYAGAIN_ID = "#btnPlayAgain";
PLAYNEXT_ID = "#btnPlayNext";
GAMEOVER_ID = "#gameover";

TOP_AREA_ID = "topArea";
INTRO_ID = "#intro";
GAME_MAIN_ID = "#gameMain";


TIMER_TARGET = "STYLE"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
TIMER_DISPLAY_VALUE = "PERCENTAGE"; //ABSOLUTE, PERCENTAGE
TIMER_TARGET_ATTRIB = "width";

SCORE_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
SCORE_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
SCORE_TARGET_ATTRIB = "";

LIFE_TARGET = "REPEAT_HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
LIFE_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
LIFE_TARGET_ATTRIB = "<li><img src=\"img/icon-heart.png\"> </li>";

TARGET_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
TARGET_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
TARGET_TARGET_ATTRIB = "";

LEVEL_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
LEVEL_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
LEVEL_TARGET_ATTRIB = "";

LOADING_TARGET = "STYLE"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
LOADING_DISPLAY_VALUE = "PERCENTAGE"; //ABSOLUTE, PERCENTAGE
LOADING_TARGET_ATTRIB = "width";


PLAY_STAGE_ID = "stage"; //no hash infront of id
URL_UPDATE_TRANS = "http://dev.doze.my/updateTrans.php?appid=BubbleDoze&mn=";  // user mobile no will be added to the URL

DISPLAY_RESULT_REFRESH_RATE = 500; //in milisecond - after game ends result will also be displayed after this delay
TRANSACTION_REFRESH_RATE = 60000; //in milisecond

SOUNDS = 0;
var gameAssets = [{ "name": "life", "value": 5, "maxLimit": 5 }
, { "name": "pwKillAll", "value": 1, "maxLimit": 5 }
, { "name": "pwSkipLevel", "value": 2, "maxLimit": 5}];

gameObjects = [{ "imgURL": "img/bubble-1.png", "point": 200, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-1.png" }
, { "imgURL": "img/bubble-2.png", "point": 150, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-2.png" }
, { "imgURL": "img/bubble-3.png", "point": 250, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-3.png" }
, { "imgURL": "img/bubble-4.png", "point": 350, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-4.png" }
, { "imgURL": "img/bubble-5.png", "point": -175, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-5.png" }
, { "imgURL": "img/bubble-6.png", "point": 425, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-6.png" }
, { "imgURL": "img/bubble-7.png", "point": 500, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-7.png" }
, { "imgURL": "img/bubble-8.png", "point": -275, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-8.png" }
, { "imgURL": "img/bubble-9.png", "point": 900, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-9.png" }
, { "imgURL": "img/bubble-10.png", "point": -375, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble-hit-10.png" }
];

levelDefs = [{ "allowedObjs": 4, "duration": 60, "target": 1999, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.jpg" }
, { "allowedObjs": 4, "duration": 60, "target": 2999, "totalObjs": 20, "levelMusic": "snd/obj1hit.mp3", "bkImg": "img/level2.jpg" }
, { "allowedObjs": 4, "duration": 60, "target": 3999, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 5, "duration": 90, "target": 5999, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 5, "duration": 90, "target": 9999, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 5, "duration": 90, "target": 1499, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 6, "duration": 120, "target": 2299, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 6, "duration": 120, "target": 2599, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 7, "duration": 120, "target": 2750, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 7, "duration": 120, "target": 3000, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 8, "duration": 150, "target": 3250, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 8, "duration": 150, "target": 3500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 8, "duration": 150, "target": 3750, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 9, "duration": 150, "target": 4000, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
, { "allowedObjs": 9, "duration": 150, "target": 4500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png" }
];

STAGE_WIDTH = document.getElementById(PLAY_STAGE_ID).offsetWidth;
STAGE_HEIGHT = screen.availHeight;
MAX_LIFE = 5;
TOP_CLEARANCE = 0;