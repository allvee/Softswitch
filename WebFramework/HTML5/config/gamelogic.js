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

function displayResult() {

    $(LEVELEND_ID).show(); //Showing the DIV    
    if (life > 0) {
        if (score >= LEVEL_TARGET) {
            //Player met the target - you can let him play next level
            $(PLAYNEXT_ID).show();
        }
        else {
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
        $(PLAYNEXT_ID).hide();
        $(PLAYAGAIN_ID).hide();
        $(GAMEOVER_ID).show();
        GAME_OVER = true;
    }
    if (GAME_OVER == false)
        clearInterval(dispResHandle);
}
