//////////////////////////
// Game Config Starts
//////////////////////////
var SCORE_ID = "#score";
var TIMER_ID = "#timer";
var LEVEL_ID = "#level";
var TARGET_ID = "#target";
var LOADING_ID = "#loading";
var LIFE_ID = "#life";

var LEVELEND_ID = "#levelEnd";
var PLAYAGAIN_ID = "#btnPlayAgain";
var PLAYNEXT_ID = "#btnPlayNext";
var GAMEOVER_ID = "#gameover";

var TOP_AREA_ID = "topArea";
var INTRO_ID = "intro";
var GAME_MAIN_ID = "gameMain";

var TIMER_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
var TIMER_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
var TIMER_TARGET_ATTRIB = "";

var SCORE_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
var SCORE_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
var SCORE_TARGET_ATTRIB = "";

var LIFE_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
var LIFE_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
var LIFE_TARGET_ATTRIB = "";

var TARGET_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
var TARGET_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
var TARGET_TARGET_ATTRIB = "";

var LEVEL_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
var LEVEL_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
var LEVEL_TARGET_ATTRIB = "";

var LOADING_TARGET = "HTML"; //HTML, STYLE, ATTRIB, REPEAT_HTML, NONE, CUSTOM
var LOADING_DISPLAY_VALUE = "ABSOLUTE"; //ABSOLUTE, PERCENTAGE
var LOADING_TARGET_ATTRIB = "";


var PLAY_STAGE_ID = "stage"; //no hash infront of id
var URL_UPDATE_TRANS = "NA";  //"http://192.168.1.18/HTML5/updateTrans.php?appid=BubbleDoze&mn=";  // user mobile no will be added to the URL

var DISPLAY_RESULT_REFRESH_RATE = 500; //in milisecond - after game ends result will also be displayed after this delay
var TRANSACTION_REFRESH_RATE = 5000; //in milisecond
var LEVEL_FAIL_MSG = "Level FAILED!";
var GAME_OVER_MSG = "Game Over!";
var LEVEL_COMPLETE_MSG = "Congratulations! Level Complete!!";

var TOP_CLEARANCE = 0;

//////////////////////////
//Game Config Ends
//////////////////////////


//////////////////////////
//Game Definition Starts
//////////////////////////
var SOUNDS = 0;
var gameAssets = [{ "name": "life", "value": 5, "maxLimit": 5 }
, { "name": "pwKillAll", "value": 1, "maxLimit": 5 }
, { "name": "pwSkipLevel", "value": 2, "maxLimit": 5}];

var gameObjects = [{ "imgURL": "img/bubble1.png", "point": 20, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble2.png", "point": 50, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble3.png", "point": -15, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble4.png", "point": 100, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble5.png", "point": -5, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble6.png", "point": -10, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble7.png", "point": 200, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble8.png", "point": 500, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble9.png", "point": 1000, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
, { "imgURL": "img/bubble10.png", "point": -100, "action": "AddPoint", "hitSound": "snd/obj1hit.mp3", "hitImgURL": "img/bubble1hit.gif" }
];

var levelDefs = [{ "allowedObjs": 4, "duration": 10, "target": 100, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.jpg", "LEVEL_MIN_DUR": 60, "LEVEL_MAX_DUR": 40}
, { "allowedObjs": 4, "duration": 60, "target": 300, "totalObjs": 20, "levelMusic": "snd/obj1hit.mp3", "bkImg": "img/level2.jpg", "LEVEL_MIN_DUR": 70, "LEVEL_MAX_DUR": 35}
, { "allowedObjs": 4, "duration": 10, "target": 500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 80, "LEVEL_MAX_DUR": 30 }
, { "allowedObjs": 5, "duration": 90, "target": 750, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 25 }
, { "allowedObjs": 5, "duration": 90, "target": 1000, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35}
, { "allowedObjs": 5, "duration": 90, "target": 1500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 6, "duration": 120, "target": 2250, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 6, "duration": 120, "target": 2500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 7, "duration": 120, "target": 2750, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 7, "duration": 120, "target": 3000, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 8, "duration": 150, "target": 3250, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 8, "duration": 150, "target": 3500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35}
, { "allowedObjs": 8, "duration": 150, "target": 3750, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 9, "duration": 150, "target": 4000, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
, { "allowedObjs": 9, "duration": 150, "target": 4500, "totalObjs": 20, "levelMusic": "snd/level1.mp3", "bkImg": "img/level1.png", "LEVEL_MIN_DUR": 90, "LEVEL_MAX_DUR": 35 }
];

var MAX_LIFE = 5;
//////////////////////////
//Game Definition Ends
//////////////////////////


var STAGE_WIDTH = document.getElementById(PLAY_STAGE_ID).offsetWidth, STAGE_HEIGHT = screen.availHeight;
var SCORE_STAGE_WIDTH = STAGE_WIDTH, SCORE_STAGE_HEIGHT = 25;
var LEND_POPUP_WIDTH = 100, LEND_POPUP_HEIGHT = 100;
var OBJ_WIDTH = 50, OBJ_HEIGHT = 50, START_X = 0, START_Y = STAGE_HEIGHT, X_GAP = 10, Y_GAP = 10, MAX_Y = OBJ_HEIGHT * 3;
var TOTAL_OBJ = 20;
var END_X = 0, END_Y = -OBJ_HEIGHT;
var HIT_ANIM_DUR = 2;
var MIN_DUR = Math.floor(STAGE_HEIGHT / 50), MAX_DUR = Math.floor(STAGE_HEIGHT / 15);
var CUR_OBJ = 0;
var TOTAL_IMGS = gameObjects.length;
var LEVEL_ALLOWED_OBJ = 4, LEVEL_DUR = 10, LEVEL_TARGET = 500;
var CUR_LEVEL = 1, TOTAL_LEVELS = levelDefs.length;
var loadingX = 10, loadingY = 10, scoreX = 10, scoreY = 10, timerX = 10, timerY = 20;

var LOADED_IMG = 0, LOADED_HIT_IMG = 0, LOADED_HIT_SND = 0, LOADED_LEVEL_MUSIC = 0, LOADED_LEVEL_BK = 0;

var gameResult = "";

var dispResHandle;
var GAME_OVER = false;

var score = 0;
var remainingTime = LEVEL_DUR;
var life = 5;

var kRect = new Array();
var kTween = new Array();
var hitTween = new Array();
var kHit = new Array()

var hitImg = new Array();
var img = new Array();
var snd = new Array();
var bkImg = new Array();
var LEVEL_MUSIC = new Array();

var w = OBJ_WIDTH, h = OBJ_HEIGHT, x = START_X, y = START_Y, xd = X_GAP, yd = Y_GAP;
var btnPlayAgain, btnPlayNext;

var kStage = new Kinetic.Stage({
    container: PLAY_STAGE_ID,
    width: STAGE_WIDTH,
    height: STAGE_HEIGHT
});

var kLayer = new Kinetic.Layer();
var imgBak = new Kinetic.Image();

kStage.add(kLayer);


function handlePlayAgain() {
    clearInterval(dispResHandle);
    handleLevelEnd(); //Call this to start over the level
}

function handlePlayNext() {
    clearInterval(dispResHandle);
    //Setting up the next level
    if (CUR_LEVEL >= TOTAL_LEVELS)
        loadLevel(1);
    else
        loadLevel(CUR_LEVEL + 1);

    handleLevelEnd(); //Call this to start the level
}

function handleGameOver() {
    clearInterval(dispResHandle);
    updateGameAsset(MAX_LIFE, "life");
    loadLevel(1);
    handleLevelEnd(); //Call this to start the level
}

function updateStage() {
    var topPadding = document.getElementById(TOP_AREA_ID).clientHeight;

    STAGE_WIDTH = document.getElementById(PLAY_STAGE_ID).clientWidth;
    STAGE_HEIGHT = window.innerHeight - topPadding-TOP_CLEARANCE;  //document.getElementById(PLAY_STAGE_ID).clientHeight;
    kStage.setWidth(STAGE_WIDTH);
    kStage.setHeight(STAGE_HEIGHT);
}


function updateGameData() {
    $("[gameData=\"score\"]").html(score);
    $("[gameData=\"life\"]").html(life);
    $("[gameData=\"resMsg\"]").html(gameResult);
}


function displayResult() {
    $(LEVELEND_ID).show(); //Showing the DIV
    $(GAMEOVER_ID).hide(); //hiding game over
    if (life > 0) {
        if (score >= LEVEL_TARGET) {
            gameResult = LEVEL_COMPLETE_MSG;
            //Player met the target - you can let him play next level
            $(PLAYNEXT_ID).show();
        }
        else {
            gameResult = LEVEL_FAIL_MSG;
            //Player failed to meet the target - hide the next level button
            $(PLAYNEXT_ID).hide();

            //Reducing Life when level failed
            if (GAME_OVER == false)
                updateGameAsset(-1, "life");

            //Allowing to play again if life is available
            if (life > 0) {
                $(PLAYAGAIN_ID).show();
            }
            else //No option to play again when no life, showing game over
            {
                $(PLAYAGAIN_ID).hide();
                $(GAMEOVER_ID).show();
                GAME_OVER = true;
            }
        }
    } else {
        gameResult = GAME_OVER_MSG;
        $(PLAYNEXT_ID).hide();
        $(PLAYAGAIN_ID).hide();
        $(GAMEOVER_ID).show();
        GAME_OVER = true;
    }
    if (GAME_OVER == false)
        clearInterval(dispResHandle);
    updateGameData();
}

function createObject(i) {
    var n = getRandomNo(0, LEVEL_ALLOWED_OBJ);
    var objInfo = { "id": i, "gameObject": n }

    kRect[i] = new Kinetic.Image({
        x: x, y: y, width: w, height: h
	, image: img[n]
	, name: objInfo
    });

    kLayer.add(kRect[i]);
	
	MIN_DUR=Math.floor(STAGE_HEIGHT / levelDefs[CUR_LEVEL-1].LEVEL_MIN_DUR);
    MAX_DUR=Math.floor(STAGE_HEIGHT / levelDefs[CUR_LEVEL-1].LEVEL_MAX_DUR);

    kTween[i] = new Kinetic.Tween({
        node: kRect[i]
		, duration: getRandomNo(MIN_DUR, MAX_DUR)
		, x: x
		, y: END_Y
    });

    x += w + getRandomNo(1, xd);
    if (x + w > STAGE_WIDTH) {
        x = START_X;
        y += OBJ_HEIGHT + getRandomNo(1, Y_GAP);
        if (y > MAX_Y)
            y = START_Y;
    }

    kTween[i].play();

}

function displayScore(n) {
    var displayValue = 0;
    
    updateGameData();
        
    displayValue = getDisplayValue(score, LEVEL_TARGET, SCORE_DISPLAY_VALUE);
    showValue(SCORE_ID, displayValue, SCORE_TARGET, SCORE_TARGET_ATTRIB);
//    $(SCORE_ID).html(score);

    displayValue = getDisplayValue(CUR_LEVEL, TOTAL_LEVELS, LEVEL_DISPLAY_VALUE);
    showValue(LEVEL_ID, displayValue, LEVEL_TARGET, LEVEL_TARGET_ATTRIB);
//    $(LEVEL_ID).html(CUR_LEVEL);

    if (TARGET_DISPLAY_VALUE=="SCORE")
        displayValue = getDisplayValue(score, LEVEL_TARGET, TARGET_DISPLAY_VALUE);
    else
        displayValue = getDisplayValue(LEVEL_TARGET, LEVEL_TARGET, TARGET_DISPLAY_VALUE);
    showValue(TARGET_ID, displayValue, TARGET_TARGET, TARGET_TARGET_ATTRIB);
//    $(TARGET_ID).html(LEVEL_TARGET);

    displayValue = getDisplayValue(life, MAX_LIFE, LIFE_DISPLAY_VALUE);
    showValue(LIFE_ID, displayValue, LIFE_TARGET, LIFE_TARGET_ATTRIB);
//    $(LIFE_ID).html(life);
}

function getDisplayValue(val, targetVal, targetType) {
    var displayValue = val;

    if (targetType == "PERCENTAGE")
        displayValue = 100 * val / targetVal;

    displayValue=Math.round(displayValue);

    return displayValue;
}

function showValue(target, val, targetType, addlInfo) {
    if (targetType == "NONE")
        return;
    else if (targetType == "CUSTOM")
        window[addlInfo](target, val);
    else if (targetType == "STYLE")
        $(target).css(addlInfo, val+"%");
    else if (targetType == "ATRIBUTE")
        $(target).attr(addlInfo, val);
    else if (targetType == "REPEAT_HTML") {
        $(target).html("");
        for (var i = 0; i < val; i++)
            $(target).append(addlInfo);
    }
    else
        $(target).html(val);
}

function displayTimer() {

    var displayValue = getDisplayValue(remainingTime, LEVEL_DUR, TIMER_DISPLAY_VALUE);

    showValue(TIMER_ID, displayValue, TIMER_TARGET, TIMER_TARGET_ATTRIB);

    updateGameData();
}

function displayLoading() {
    var gtObjects = 2*TOTAL_IMGS+TOTAL_LEVELS;
    var loadedCount = LOADED_HIT_IMG + LOADED_IMG + LOADED_LEVEL_BK;

    var displayValue = getDisplayValue(loadedCount, gtObjects, LOADING_DISPLAY_VALUE);

    showValue(LOADING_ID, displayValue, LOADING_TARGET, LOADING_TARGET_ATTRIB);

}


function loadLevel(levelNo) {
    if (levelNo <= 0 || levelNo > TOTAL_LEVELS)
        return;

    var objInfo = { "id": -1, "gameObject": -1 }

    imgBak.destroy();
    imgBak = new Kinetic.Image({
        x: 0, y: 0, width: STAGE_WIDTH, height: STAGE_HEIGHT
	, image: bkImg[levelNo - 1]
	, name: objInfo
    });

    if (SOUNDS == 1) {
        LEVEL_MUSIC[CUR_LEVEL - 1].stop();
        LEVEL_MUSIC[levelNo - 1].play();
    }
//    kLayer.add(imgBak);

    LEVEL_ALLOWED_OBJ = levelDefs[levelNo - 1].allowedObjs;
    LEVEL_DUR = levelDefs[levelNo - 1].duration;
    LEVEL_TARGET = levelDefs[levelNo - 1].target;
    TOTAL_OBJ = levelDefs[levelNo - 1].totalObjs;
    CUR_LEVEL = levelNo;
    localStorage.currentLevel = CUR_LEVEL;
}

function evtHandler(evt) {
    var shape = evt.targetNode;
    var i = 0;
    var n = 0;
    var touchPos;

    if (evt.type == 'touchstart' || evt.type == 'touchend' || evt.type == 'touchmove') {
        touchPos = kStage.getTouchPosition();
    }
    else {
        touchPos = kStage.getMousePosition();
    }

    var x = touchPos.x;
    var y = touchPos.y;

    var evtObjInfo = shape.getName();
    i = evtObjInfo.id;
    n = evtObjInfo.gameObject;

    if (i < 0 || i >= TOTAL_OBJ)
        return;

    if (remainingTime <= 0)
        return;

    if (SOUNDS == 1) {
        snd[n].play();
    }
    kTween[i].pause();

    var curX=kRect[i].getX(), curY=kRect[i].getY();
    score += gameObjects[n].point;

    displayScore(n);
    kRect[i].destroy();
    kTween[i].destroy();

    var objInfo = { "id": -1, "gameObject": -1 } //setting up id as -1 so that this event handler ignores this objects

    kHit[i] = new Kinetic.Image({
        x: curX, y: curY, width: OBJ_WIDTH, height: OBJ_HEIGHT
	, image: hitImg[n]
	, name: objInfo
    });

    kLayer.add(kHit[i]);

    hitTween[i] = new Kinetic.Tween({
        node: kHit[i],
        duration: HIT_ANIM_DUR,
        opacity: 0,
        onFinish: function() {
            kHit[i].destroy();
            hitTween[i].destroy();                        
        }
    });
    hitTween[i].play();

    createObject(i);
}

function handleLevelEnd(evt) {
    GAME_OVER = false;
    try {
        for (i = 0; i < TOTAL_OBJ; i++) {
            kRect[i].destroy();
            kTween[i].destroy();
        }
    } catch (e) { }
    
    $(LEVELEND_ID).hide();
    main();
}

function updateGameAsset(inc, asset) {
    var tmp = 0;
    for (i = 0; i < gameAssets.length; i++) {
        if (gameAssets[i].name == asset) {
            tmp = gameAssets[i].value;
            tmp += inc;
            if (tmp < 0)
                tmp = 0;
            if (tmp > gameAssets[i].maxLimit)
                tmp = gameAssets[i].maxLimit;
            gameAssets[i].value = tmp;
            localStorage[asset] = tmp;
            window[asset] = tmp;
            return;
        }
    }

}

function loadGameAsset(asset) {
    for(var i=0; i<gameAssets.length; i++)
    {
        if (gameAssets[i].name == asset)
            return gameAssets[i].value;
    }
    return null;
}


function main() {
    updateStage();
    $(window).resize(updateStage);
    if (life <= 0) {
        GAME_OVER = true;
        dispResHandle=setInterval(displayResult, DISPLAY_RESULT_REFRESH_RATE);
        return;
    }
    score = 0;
    remainingTime = LEVEL_DUR;


    for (i = 0; i < TOTAL_OBJ; i++) {
        createObject(i);
    }

    displayScore(0);
    var reinitObj = setInterval(function() {
        objX = kRect[CUR_OBJ].getAttr('x');
        objY = kRect[CUR_OBJ].getAttr('y');
        if (objY + OBJ_WIDTH <= 0) {
            kRect[CUR_OBJ].destroy();
            kTween[CUR_OBJ].destroy();
            createObject(CUR_OBJ);
        }

        CUR_OBJ++;
        if (CUR_OBJ >= TOTAL_OBJ)
            CUR_OBJ = 0;

        remainingTime--;
        displayTimer();
        if (remainingTime <= 0) {
            clearInterval(reinitObj);
            dispResHandle = setInterval(displayResult, DISPLAY_RESULT_REFRESH_RATE);
        }
    }, 1000);
}

function updateTransaction(dt, status) {
    var data = JSON.parse(dt);

    if (data == null)
        return;
    for (i = 0; i < data.length; i++) {
        if (data[i].transactionType == "Add") {
            updateGameAsset(data[i].value, data[i].assetName);
        }
    }
}


function startGame() {
    var tmp = HTTP_GET["topClearance"]

    if (tmp == null)
        TOP_CLEARANCE = 0;
    else
        TOP_CLEARANCE = parseInt(tmp);
    
    if (localStorage.currentLevel != null)
        CUR_LEVEL = parseInt(localStorage.currentLevel);
    if (CUR_LEVEL >= TOTAL_LEVELS)
        CUR_LEVEL = 1;

    for (i = 0; i < gameAssets.length; i++) {
        if (localStorage[gameAssets[i].name] == null)
            window[gameAssets[i].name] = gameAssets[i].value;
        else {
            window[gameAssets[i].name] = parseInt(localStorage[gameAssets[i].name]);
            gameAssets[i].value = parseInt(localStorage[gameAssets[i].name]);
        }
    }

    if (URL_UPDATE_TRANS != "NA") {
        setInterval(function() {
            if (mn == null)
                var mn = "";
            $.get(URL_UPDATE_TRANS + mn, updateTransaction);
        }, TRANSACTION_REFRESH_RATE);
    }
    
    for (i = 0; i < TOTAL_LEVELS; i++) {
        if (SOUNDS == 1) {
            LEVEL_MUSIC[i] = new buzz.sound(levelDefs[i].levelMusic, {
                preload: true,
                autoplay: false,
                loop: true
            });
        }
        bkImg[i] = new Image();
        bkImg[i].src = levelDefs[i].bkImg;
        bkImg[i].onload = function() {
            LOADED_LEVEL_BK++;
            displayLoading();
        };
    }


    for (i = 1; i <= TOTAL_IMGS; i++) {
        if (SOUNDS == 1) {
            snd[i - 1] = new buzz.sound(gameObjects[i - 1].hitSound, {
                preload: true,
                autoplay: false,
                loop: false
            });
        }
        img[i - 1] = new Image();
        img[i - 1].src = gameObjects[i - 1].imgURL;
        img[i - 1].onload = function() {
            LOADED_IMG++;
            displayLoading();
        };
        hitImg[i - 1] = new Image();
        hitImg[i - 1].src = gameObjects[i - 1].hitImgURL;
        hitImg[i - 1].onload = function() {
            LOADED_HIT_IMG++;
            displayLoading();
        };
    }

    var objLoading = setInterval(function() {
        if (LOADED_IMG < TOTAL_IMGS) {
            return;
        }

        if (LOADED_HIT_IMG < TOTAL_IMGS) {
            return;
        }


        if (LOADED_LEVEL_BK < TOTAL_LEVELS) {
            return;
        }
        $(LOADING_ID).hide();
        $(INTRO_ID).hide();
        $(GAME_MAIN_ID).show();
        clearInterval(objLoading);
        loadLevel(CUR_LEVEL);
        main();
    }, 100);
    kLayer.on('click touchstart', evtHandler);

    $(LEVELEND_ID).hide();

    $(PLAYAGAIN_ID).click(handlePlayAgain);
    $(PLAYNEXT_ID).click(handlePlayNext);
    $(GAMEOVER_ID).click(handleGameOver);
}
