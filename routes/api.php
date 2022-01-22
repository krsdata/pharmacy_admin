<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With, auth-token');
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Origin: *");


Route::group(['prefix' => 'v2'], function () {
    Route::post('/login', 'Api\UserController@login');
    Route::post('/register', 'Api\UserController@member/registration');
    Route::get('/logout', 'Api\UserController@logout')->middleware('auth:api');
    Route::match(['post','get'], 'email_verification', 'UserController@emailVerification');
    Route::match(['post','get'], 'forgotPassword', 'Api\UserController@forgotPassword');
    Route::match(['post','get'], 'password/reset', 'Api\UserController@resetPassword');
    Route::match(['post','get'], 'changePassword', 'Api\UserController@changePassword');
    Route::match(['post','get'], 'mChangePassword', 'Api\UserController@mChangePassword');

});

Route::middleware('auth:api')->group( function () {

    Route::group([
        'prefix' => 'v2'
    ], function()
    {   
        Route::match(['post','get'],'member/updateProfile', 'Api\UserController@updateProfile');
        Route::match(['post','get'],'inviteUser', 'Api\UserController@inviteUser');

        // getMatch
        Route::match(['post','get'],'getMatch', 'Api\ApiController@getMatch');
        // Contest
        Route::match(['post','get'],'getContestByMatch', 'Api\ApiController@getContestByMatch');
        Route::match(['post','get'],'getMyContest', 'Api\ApiController@getMyContest');
        Route::match(['post','get'],'joinContest', 'Api\ApiController@joinContest');
        //Create Team
        Route::match(['post','get'],'createTeam', 'Api\ApiController@createTeam');
        Route::match(['post','get'],'cloneMyTeam', 'Api\ApiController@cloneMyTeam');
        Route::match(['post','get'],'getMyTeam', 'Api\ApiController@getMyTeam');
        // Get Players
        Route::match(['post','get'],'getPlayer', 'Api\ApiController@getPlayer');
        //Transaction
        Route::match(['post','get'],'getWallet', 'Api\ApiController@getWallet');
        Route::match(['post','get'],'addMoney', 'Api\ApiController@addMoney');
        Route::match(['post','get'],'transactionHistory', 'Api\PaymentController@transactionHistory');
        // Leaderboard , getpoints and prizedistribution
        Route::match(['post','get'],'leaderBoard', 'Api\ApiController@leaderBoard');
        Route::match(['post','get'],'getPoints', 'Api\ApiController@getPoints');
        Route::match(['post','get'],'getPrizeBreakup', 'Api\ApiController@getPrizeBreakup');
        Route::match(['post','get'],'prizeDistribution', 'Api\ApiController@prizeDistribution');

        Route::match(['post','get'],'joinNewContestStatus', 'Api\ApiController@joinNewContestStatus');

        Route::match(['post','get'],'getScore', 'Api\ApiController@getScore');
        

    });
});

// Without AuthM
Route::group([
    'prefix' => 'v2'
], function()
{   
    Route::match(['post','get'],'getPlaying11', 'Api\ApiController@getPlaying11');
    Route::match(['post','get'],'changeMobile', 'Api\UserController@changeMobile');
    Route::match(['post','get'],'login', 'Api\UserController@login');
        
    Route::match(['post','get'],'withdrawAmount', 'Api\ApiController@withdrawAmount');
    Route::match(['post','get'],'getProfile', 'Api\UserController@getProfile');

    Route::match(['get','post'], 'updateLiveMatchStatus', [
        'as' => 'updateLiveMatchStatus',
        'uses' => 'Api\ApiController@updateMatchDataByStatus'
    ]);

    Route::match(['get','post'], 'getPlayerPoints', [
        'as' => 'getPlayerPoints',
        'uses' => 'Api\ApiController@getPlayerPoints'
    ]);
    
    Route::match(['get','post'], 'automateCreateContest', [
        'as' => 'automateCreateContest',
        'uses' => 'Api\ApiController@automateCreateContest'
    ]);

    Route::match(['get','post'], 'verification', [
        'as' => 'verification',
        'uses' => 'Api\ApiController@verification'
    ]);

    Route::match(['get','post'], 'playerAnalytics', [
        'as' => 'playerAnalytics',
        'uses' => 'Api\ApiController@playerAnalytics'
    ]);
    Route::match(['get','post'], 'getMyPlayedMatches', [
        'as' => 'getMyPlayedMatches',
        'uses' => 'Api\ApiController@getMyPlayedMatches'
    ]);

    Route::match(['post','get'],'updateMatchDataByMatchId/{match_id}/{status}', 'Api\ApiController@updateMatchDataByMatchId'); 
    Route::match(['get','post'], 'generateOtp', [
        'as' => 'generateOtp',
        'uses' => 'Api\UserController@generateOtp'
    ]);

    Route::match(['get','post'], 'verifyOtp', [
        'as' => 'verifyOtp',
        'uses' => 'Api\UserController@verifyOtp'
    ]);

    Route::match(['post','get'],'myReferralDetails', 'Api\UserController@myReferralDetails');

    Route::match(['post','get'],'updateAfterLogin', 'Api\UserController@updateAfterLogin');

    Route::match(['post','get'],'inviteUser', 'Api\UserController@inviteUser');

    Route::match(['post','get'],'verifyDocument', 'Api\UserController@verifyDocument');

    Route::match(['post','get'],'apkUpdate', 'Api\ApiController@apkUpdate');

    Route::match(['post','get'],'contestFillNotify', 'Api\ApiController@contestFillNotify');
    

    Route::match(['post','get'],'deviceNotification', 'Api\UserController@deviceNotification');
    Route::match(['post','get'],'sendPushNotification', 'Api\UserController@sendPushNotification');

    // cron from backedn
    Route::match(['post','get'],'getMatchDataFromApiAdmin', 'Api\CronController@getMatchDataFromApi');

    Route::match(['post','get'],'getPlayingMatchHistory', 'Api\ApiController@getPlayingMatchHistory');

    Route::match(['post','get'],'captureScreenTime', 'Api\ApiController@captureScreenTime');

    Route::match(['post','get'],'getMatchHistory', 'Api\ApiController@getMatchHistory');
    Route::match(['post','get'],'updateMatchDataByStatusAdmin/{status}', 'Api\CronController@updateMatchDataByStatus');
    // system API
    Route::match(['post','get'],'storeMatchInfo/{fileName}', 'Api\ApiController@storeMatchInfo');
    Route::match(['post','get'],'getMatchDataFromApi', 'Api\ApiController@getMatchDataFromApi');
    Route::match(['post','get'],'updateMatchDataByStatus/{status}', 'Api\ApiController@updateMatchDataByStatus');
    Route::match(['post','get'],'updatePlayerFromCompetition', 'Api\ApiController@updatePlayerFromCompetition');
    Route::match(['post','get'],'updatePlayerByMatch/{match_id}', 'Api\ApiController@getCompetitionByMatchId');
    Route::match(['post','get'],'getSquad/{match_id}', 'Api\ApiController@getSquad');
    Route::match(['post','get'],'updateAllSquad', 'Api\ApiController@updateAllSquad');
    Route::match(['post','get'],'createContest/{match_id}', 'Api\ApiController@createContest');
    Route::match(['post','get'],'updateMatchDataById/{match_id}', 'Api\ApiController@updateMatchDataById');

    Route::match(['post','get'],'updateMatchStatus', 'Api\ApiController@updateMatchStatus');

    Route::match(['post','get'],'saveMatchDataByMatchId/{match_id}', 'Api\ApiController@saveMatchDataByMatchId');
    Route::match(['post','get'],'updateMatchInfo', 'Api\ApiController@updateMatchInfo');
    Route::match(['post','get'],'updateSquad/{match_id}', 'Api\ApiController@updateSquad');
    Route::match(['post','get'],'updateLiveMatchFromApp', 'Api\ApiController@updateLiveMatchFromApp');
    Route::match(['post','get'],'updatePoints', 'Api\ApiController@updatePoints');
    Route::match(['post','get'],'getPointsByMatch', 'Api\ApiController@getPointsByMatch');
    Route::match(['post','get'],'updatePointAfterComplete', 'Api\ApiController@updatePointAfterComplete');
    Route::match(['post','get'],'updateUserMatchPoints', 'Api\ApiController@updateUserMatchPoints');



    //User API
    Route::match(['post','get'],'member/registration', 'Api\UserController@registration');
    Route::match(['post','get'],'member/customerLogin', 'Api\UserController@login');
    Route::match(['post','get'],'email_verification','Api\UserController@emailVerification');
    Route::match(['post','get'],'member/updateProfile', 'Api\UserController@updateProfile');
    Route::match(['post','get'],'member/logout', 'Api\UserController@logout');
    Route::match(['post','get'],'temporaryPassword', 'Api\UserController@temporaryPassword');
    Route::match(['post','get'],'resetPassword', 'Api\UserController@resetPassword');


    // auth required API
    Route::match(['post','get'],'joinNewContestStatus', 'Api\ApiController@joinNewContestStatus');
    Route::match(['post','get'],'getScore', 'Api\ApiController@getScore');
    Route::match(['post','get'],'transactionHistory', 'Api\PaymentController@transactionHistory');
    Route::match(['post','get'],'getMatch', 'Api\ApiController@getMatch');
    Route::match(['post','get'],'getPlayer', 'Api\ApiController@getPlayer');
    Route::match(['post','get'],'getContestByMatch', 'Api\ApiController@getContestByMatch');
    Route::match(['post','get'],'cloneMyTeam', 'Api\ApiController@cloneMyTeam');
    Route::match(['post','get'],'createTeam', 'Api\ApiController@createTeam');
    Route::match(['post','get'],'getMyTeam', 'Api\ApiController@getMyTeam');
    Route::match(['post','get'],'joinContest', 'Api\ApiController@joinContest');
    Route::match(['post','get'],'getMyContest', 'Api\ApiController@getMyContest');
    Route::match(['post','get'],'prizeDistribution', 'Api\PaymentController@prizeDistribution');
    Route::match(['post','get'],'getWallet', 'Api\ApiController@getWallet');
    Route::match(['post','get'],'addMoney', 'Api\ApiController@addMoney');
    Route::match(['post','get'],'leaderBoard', 'Api\ApiController@leaderBoard');
    Route::match(['post','get'],'getPrizeBreakup', 'Api\ApiController@prizeBreakup');
    Route::match(['post','get'],'getContestStat', 'Api\ApiController@getContestStat');
    Route::match(['post','get'],'getPoints', 'Api\ApiController@getPoints');
    Route::match(['post','get'],'saveDocuments', 'Api\ApiController@saveDocuments');    
    Route::match(['post','get'],'isLineUp', 'Api\ApiController@isLineUp');
    Route::match(['post','get'],'matchAutoCancel', 'Api\ApiController@matchAutoCancel');

    //added by manoj
    Route::match(['post','get'],'uploadbase64Image', 'Api\ApiController@uploadbase64Image');
    Route::match(['post','get'],'member/uploadImages', 'Api\ApiController@uploadImages');
    Route::match(['post','get'],'member/updateProfile', 'Api\UserController@updateProfile');
    Route::match(['post','get'],'updateProfile', 'Api\UserController@updateProfile');

    Route::match(['post','get'],'getAnalytics', 'Api\ApiController@getAnalytics');

    Route::match(['post','get'],'getNotification', 'Api\ApiController@getNotification');
    Route::match(['post','get'],'paytmCallBack', 'Api\ApiController@paytmCallBack');

    Route::match(['post','get'],'callBackUrl', 'Api\ApiController@paytmCallBack');

    Route::match(['post','get'],'paytmCallBack', 'Api\ApiController@paytmCallBack');


    Route::match(['post','get'],'paymentCallback', 'Api\ApiController@paymentCallback');


    Route::match(['post','get'],'checkSingnature', 'Api\ApiController@checkSingnature'); 

    Route::match(['post','get'],'eventLog', 'Api\ApiController@eventLog');
    
    Route::match(['post','get'],'getContestByType', 'Api\ApiController@getContestByType');

    Route::match(['post','get'],'detectDevice', 'Api\ApiController@detectDevice');

    Route::match(['post','get'],'playerPoints', 'Api\ApiController@playerPoints');
    
    Route::match(['post','get'],'playerStat', 'Api\ApiController@playerStat');
    Route::match(['post','get'],'distributePrize', 'Api\ApiController@distributePrize');
    Route::match(['post','get'],'affiliateProgram', 'Api\ApiController@affiliateProgram');

    Route::match(['post','get'],'getSquadByMatch/{match_id}', 'Api\ApiController@getSquadByMatch');
    Route::match(['post','get'],'createAutoTeam', 'Api\MegaController@createAutoTeam');
    
    Route::match(['post','get'],'removePrizeAfterAbandon', 'Api\ApiController@removePrizeAfterAbandon');
    
    
   } 
);



// if URL not found
Route::group([
    'prefix' => 'v2'
], function()
{
    // if route not found
    Route::any('{any}', function(){
        $data = [
            'status'=>0,
            'code'=>400,
            'message' => 'Bad request'
        ];
        return \Response::json($data);
    });
});

