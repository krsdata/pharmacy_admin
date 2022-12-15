<?php
if (App::environment('prod')) {
    \URL::forceScheme('https');
}
    Route::match(['get','post'],'admin/updatePoint', 'Modules\Admin\Http\Controllers\UpdatePlayerPointsController@updatePoint');

    Route::get('admin/forgot-password', 'Modules\Admin\Http\Controllers\AuthController@forgetPassword');
    Route::post('password/email', 'Modules\Admin\Http\Controllers\AuthController@sendResetPasswordLink');
    Route::get('admin/password/reset', 'Modules\Admin\Http\Controllers\AuthController@resetPassword');
    Route::get('admin/logout', 'Modules\Admin\Http\Controllers\AuthController@logout');
    Route::get('admin/login', 'Modules\Admin\Http\Controllers\AuthController@index');

    Route::post('admin/blog/ajax', 'Modules\Admin\Http\Controllers\BlogController@ajax');
    Route::get('admin/error', 'Modules\Admin\Http\Controllers\PageController@error');

    Route::post('admin/login', function (App\Admin $user) {

        $credentials = ['email' => Input::get('email'), 'password' => Input::get('password')];

        $admin_auth = auth()->guard('admin');
        $user_auth =  auth()->guard('web'); //Auth::attempt($credentials);

        if ($admin_auth->attempt($credentials) or $user_auth->attempt($credentials)) {
            return Redirect::to('admin');
        } else {
            return redirect()
                        ->back()
                        ->withInput()
                        ->withErrors(['message'=>'Invalid email or password. Try again!']);
        }
    });
 


    Route::group(['middleware' => ['admin']], function () {

        Route::get('admin', 'Modules\Admin\Http\Controllers\AdminController@index');
        /*------------User Model and controller---------*/
        
        Route::post('login', [ 'as' => 'custom.login', 'uses' => 'FrontEndController@login']);

        Route::match(['get','post'],'admin/saveMatchFromApi', 
            [ 
                'as' => 'saveMatchFromApi', 
                'uses' => 'Modules\Admin\Http\Controllers\FlashMatchController@updateMatchDataByStatus'
            ]
        );

        Route::match(['get','post'],'admin/oldMatch', 
            [ 
                'as' => 'oldMatch', 
                'uses' => 'Modules\Admin\Http\Controllers\FlashMatchController@oldMatch'
            ]
        );

        Route::match(['get','post'],'admin/getMatchReport', 
            [ 
                'as' => 'getMatchReport', 
                'uses' => 'Modules\Admin\Http\Controllers\ReportController@getMatchReport'
            ]
        );

        Route::match(['get','post'],'admin/downloadMatchReport', 
            [ 
                'as' => 'downloadMatchReport', 
                'uses' => 'Modules\Admin\Http\Controllers\ReportController@downloadMatchReport'
            ]
        );

        Route::match(['get','post'],'admin/bankAccount', 
            [ 
                'as' => 'bankAccount', 
                'uses' => 'Modules\Admin\Http\Controllers\DocumentController@bankAccount'
            ]
        );

        Route::bind('documents', function ($value, $route) {
            return Modules\Admin\Models\Document::find($value);
        });

        Route::resource(
            'admin/documents',
            'Modules\Admin\Http\Controllers\DocumentController',
            [
                'names' => [
                    'edit'      => 'documents.edit',
                    'show'      => 'documents.show',
                    'destroy'   => 'documents.destroy',
                    'update'    => 'documents.update',
                    'store'     => 'documents.store',
                    'index'     => 'documents',
                    'create'    => 'documents.create',
                ]
                    ]
        );

        

        Route::bind('updatePlayerPoints', function ($value, $route) {
            return Modules\Admin\Models\UpdatePlayerPoints::find($value);
        });
        Route::resource(
            'admin/updatePlayerPoints',
            'Modules\Admin\Http\Controllers\UpdatePlayerPointsController',
            [
            'names' => [
                'edit' => 'updatePlayerPoints.edit',
                'show' => 'updatePlayerPoints.show',
                'destroy' => 'updatePlayerPoints.destroy',
                'update' => 'updatePlayerPoints.update',
                'store' => 'updatePlayerPoints.store',
                'index' => 'updatePlayerPoints',
                'create' => 'updatePlayerPoints.create',
            ]
                ]
        );
        //wallets
         Route::bind('wallets', function ($value, $route) {
            return Modules\Admin\Models\Wallets::find($value);
        });
        Route::resource(
            'admin/wallets',
            'Modules\Admin\Http\Controllers\WalletsController',
            [
                'names' => [
                    'edit' => 'wallets.edit',
                    'show' => 'wallets.show',
                    'destroy' => 'wallets.destroy',
                    'update' => 'wallets.update',
                    'store' => 'wallets.store',
                    'index' => 'wallets',
                    'create' => 'wallets.create',
                ]
            ]
        );

        Route::bind('competition', function ($value, $route) {
            return Modules\Admin\Models\Competition::find($value);
        });
        Route::resource(
            'admin/competition',
            'Modules\Admin\Http\Controllers\CompetitionController',
            [
                'names' => [
                    'edit' => 'competition.edit',
                    'show' => 'competition.show',
                    'destroy' => 'competition.destroy',
                    'update' => 'competition.update',
                    'store' => 'competition.store',
                    'index' => 'competition',
                    'create' => 'competition.create',
                ]
            ]
        );
        // Prize distribution
        Route::bind('prizeDistribution', function ($value, $route) {
            return Modules\Admin\Models\PrizeDistribution::find($value);
        });
        Route::resource(
            'admin/prizeDistribution',
            'Modules\Admin\Http\Controllers\PrizeDistributionController',
            [
                'names' => [
                    'edit' => 'prizeDistribution.edit',
                    'show' => 'prizeDistribution.show',
                    'destroy' => 'prizeDistribution.destroy',
                    'update' => 'prizeDistribution.update',
                    'store' => 'prizeDistribution.store',
                    'index' => 'prizeDistribution',
                    'create' => 'prizeDistribution.create',
                ]
            ]
        );


        Route::bind('user', function ($value, $route) {
            return Modules\Admin\Models\User::find($value);
        });

        Route::resource(
            'admin/user',
            'Modules\Admin\Http\Controllers\UsersController',
            [
            'names' => [
                'edit' => 'user.edit',
                'show' => 'user.show',
                'destroy' => 'user.destroy',
                'update' => 'user.update',
                'store' => 'user.store',
                'index' => 'user',
                'create' => 'user.create',
            ]
                ]
        );

        Route::bind('errorLog', function ($value, $route) {
            return Modules\Admin\Models\ErrorLog::find($value);
        });

        Route::resource(
            'admin/errorLog',
            'Modules\Admin\Http\Controllers\ErrorLogController',
            [
            'names' => [
                'edit' => 'errorLog.edit',
                'show' => 'errorLog.show',
                'destroy' => 'errorLog.destroy',
                'update' => 'errorLog.update',
                'store' => 'errorLog.store',
                'index' => 'errorLog',
                'create' => 'errorLog.create',
            ]
                ]
        );


        Route::bind('menu', function ($value, $route) {
            return Modules\Admin\Models\Menu::find($value);
        });

        Route::resource(
            'admin/menu',
            'Modules\Admin\Http\Controllers\MenuController',
            [
            'names' => [
                'edit' => 'menu.edit',
                'show' => 'menu.show',
                'destroy' => 'menu.destroy',
                'update' => 'menu.update',
                'store' => 'menu.store',
                'index' => 'menu',
                'create' => 'menu.create',
            ]
                ]
        );

        Route::bind('apkUpdate', function ($value, $route) {
            return Modules\Admin\Models\ApkUpdate::find($value);
        });

        Route::resource(
            'admin/apkUpdate',
            'Modules\Admin\Http\Controllers\ApkUpdateController',
            [
            'names' => [
                'edit' => 'apkUpdate.edit',
                'show' => 'apkUpdate.show',
                'destroy' => 'apkUpdate.destroy',
                'update' => 'apkUpdate.update',
                'store' => 'apkUpdate.store',
                'index' => 'apkUpdate',
                'create' => 'apkUpdate.create',
            ]
                ]
        );

        Route::resource(
            'admin/clientuser',
            'Modules\Admin\Http\Controllers\ClientUsersController',
            [
            'names' => [
                'edit' => 'clientuser.edit',
                'show' => 'clientuser.show',
                'destroy' => 'clientuser.destroy',
                'update' => 'clientuser.update',
                'store' => 'clientuser.store',
                'index' => 'clientuser',
                'create' => 'clientuser.create',
            ]
                ]
        );



        /*------------User Category and controller---------*/

        Route::bind('category', function ($value, $route) {
            return Modules\Admin\Models\Category::find($value);
        });

        Route::resource(
            'admin/category',
            'Modules\Admin\Http\Controllers\CategoryController',
            [
                'names' => [
                    'edit'      => 'category.edit',
                    'show'      => 'category.show',
                    'destroy'   => 'category.destroy',
                    'update'    => 'category.update',
                    'store'     => 'category.store',
                    'index'     => 'category',
                    'create'    => 'category.create',
                ]
                    ]
        );
        /*---------End---------*/

        Route::bind('banner', function ($value, $route) {
            return Modules\Admin\Models\Banner::find($value);
        });

        Route::resource(
            'admin/banner',
            'Modules\Admin\Http\Controllers\BannerController',
            [
                'names' => [
                    'edit'      => 'banner.edit',
                    'show'      => 'banner.show',
                    'destroy'   => 'banner.destroy',
                    'update'    => 'banner.update',
                    'store'     => 'banner.store',
                    'index'     => 'banner',
                    'create'    => 'banner.create',
                ]
                    ]
        );

        Route::bind('bannerOffer', function ($value, $route) {
            return Modules\Admin\Models\BannerOffer::find($value);
        });

        Route::resource(
            'admin/bannerOffer',
            'Modules\Admin\Http\Controllers\BannerOffersController',
            [
                'names' => [
                    'edit'      => 'bannerOffer.edit',
                    'show'      => 'bannerOffer.show',
                    'destroy'   => 'bannerOffer.destroy',
                    'update'    => 'bannerOffer.update',
                    'store'     => 'bannerOffer.store',
                    'index'     => 'bannerOffer',
                    'create'    => 'bannerOffer.create',
                ]
                    ]
        );


        /*---------Contact Route ---------*/

         Route::bind('contact', function ($value, $route) {
            return Modules\Admin\Models\Contact::find($value);
        });

        Route::resource(
            'admin/contact',
            'Modules\Admin\Http\Controllers\ContactController',
            [
            'names' => [
                'edit' => 'contact.edit',
                'show' => 'contact.show',
                'destroy' => 'contact.destroy',
                'update' => 'contact.update',
                'store' => 'contact.store',
                'index' => 'contact',
                'create' => 'contact.create',
            ]
                ]
        );
        Route::bind('contestType', function ($value, $route) {
            return Modules\Admin\Models\ContestType::find($value);
        });

        Route::resource(
            'admin/contestType',
            'Modules\Admin\Http\Controllers\ContestTypeController',
            [
            'names' => [
                'edit' => 'contestType.edit',
                'show' => 'contestType.show',
                'destroy' => 'contestType.destroy',
                'update' => 'contestType.update',
                'store' => 'contestType.store',
                'index' => 'contestType',
                'create' => 'contestType.create',
            ]
                ]
        );

        
        Route::get(
            'admin/match/cancelContest',
            'Modules\Admin\Http\Controllers\MatchController@cancelContest')->name('cancelContest');

        Route::get(
            'admin/match/cancelMatch',
            'Modules\Admin\Http\Controllers\MatchController@cancelMatch')->name('cancelMatch');

        Route::get(
            'admin/match/triggerEmail',
            'Modules\Admin\Http\Controllers\MatchController@triggerEmail')->name('triggerEmail');

        Route::bind('match', function ($value, $route) {
            return App\Models\Match::find($value);
        });

        Route::resource(
            'admin/match',
            'Modules\Admin\Http\Controllers\MatchController',
            [
            'names' => [
                'edit' => 'match.edit',
                'show' => 'match.show',
                'destroy' => 'match.destroy',
                'update' => 'match.update',
                'store' => 'match.store',
                'index' => 'match',
                'create' => 'match.create',
            ]
                ]
        );

        Route::get('admin/comment/showComment/{id}', 'Modules\Admin\Http\Controllers\CommentController@showComment');

        
        Route::post('admin/import', 'Modules\Admin\Http\Controllers\PharmacyListController@import');

        Route::resource(
            'admin/complaint',
            'Modules\Admin\Http\Controllers\CompaintController',
            [
            'names' => [
                'index' => 'complaint',
            ]
                ]
        );

        
        Route::get(
            'admin/contestReports',
            'Modules\Admin\Http\Controllers\MatchContestController@contestReports')->name('contestReports');
        
       Route::get(
            'admin/matchTeams',
            'Modules\Admin\Http\Controllers\MatchContestController@matchTeams')->name('matchTeams');

        Route::bind('matchTeams', function ($value, $route) {
            return Modules\Admin\Models\MatchTeams::find($value);
        });

       
        
  
        // programs
        Route::bind('program', function ($value, $route) {
            return Modules\Admin\Models\Program::find($value);
        });

        Route::resource(
            'admin/program',
            'Modules\Admin\Http\Controllers\ProgramController',
            [
            'names' => [
                'edit' => 'program.edit',
                'show' => 'program.show',
                'destroy' => 'program.destroy',
                'update' => 'program.update',
                'store' => 'program.store',
                'index' => 'program',
                'create' => 'program.create',
            ]
                ]
        );
  
      

        Route::bind('setting', function ($value, $route) {
            return Modules\Admin\Models\Settings::find($value);
        });

        Route::resource(
            'admin/setting',
            'Modules\Admin\Http\Controllers\SettingsController',
            [
            'names' => [
                'edit'      => 'setting.edit',
                'show'      => 'setting.show',
                'destroy'   => 'setting.destroy',
                'update'    => 'setting.update',
                'store'     => 'setting.store',
                'index'     => 'setting',
                'create'    => 'setting.create',
            ]
                ]
        );


        Route::bind('blog', function ($value, $route) {
            return Modules\Admin\Models\Blogs::find($value);
        });

        Route::resource(
            'admin/blog',
            'Modules\Admin\Http\Controllers\BlogController',
            [
            'names' => [
                'edit' => 'blog.edit',
                'show' => 'blog.show',
                'destroy' => 'blog.destroy',
                'update' => 'blog.update',
                'store' => 'blog.store',
                'index' => 'blog',
                'create' => 'blog.create',
            ]
                ]
        );


        Route::bind('role', function ($value, $route) {
            return Modules\Admin\Models\Role::find($value);
        });

        Route::resource(
            'admin/role',
            'Modules\Admin\Http\Controllers\RoleController',
            [
            'names' => [
                'edit' => 'role.edit',
                'show' => 'role.show',
                'destroy' => 'role.destroy',
                'update' => 'role.update',
                'store' => 'role.store',
                'index' => 'role',
                'create' => 'role.create',
            ]
                ]
        );


        Route::bind('content', function ($value, $route) {
            return Modules\Admin\Models\Page::find($value);
        });
        Route::resource(
            'admin/content',
            'Modules\Admin\Http\Controllers\PageController',
            [
            'names' => [
                'edit' => 'content.edit',
                'show' => 'content.show',
                'destroy' => 'content.destroy',
                'update' => 'content.update',
                'store' => 'content.store',
                'index' => 'content',
                'create' => 'content.create',
            ]
                ]
        );

        

        Route::match(['get','post'], 'admin/permission', 'Modules\Admin\Http\Controllers\RoleController@permission');

        /*----------End---------*/

        Route::match(['get','post'], 'admin/profile', 'Modules\Admin\Http\Controllers\AdminController@profile');

        Route::match(['get','post'], 'admin/monthly-report/{name}', 'Modules\Admin\Http\Controllers\MonthlyReportController@corporateUser');
        Route::match(['get','post'], 'admin/corporate-monthly-report', 'Modules\Admin\Http\Controllers\MonthlyReportController@index');

        /*-- 22-12-21--*/
        Route::bind('dashboardUsers', function ($value, $route) {
            return Modules\Admin\Models\AdminLogin::find($value);
        });

        Route::resource(
            'admin/dashboardUsers',
            'Modules\Admin\Http\Controllers\DashboardUsersController',
            [
            'names' => [
                'edit' => 'dashboardUsers.edit',
                'show' => 'dashboardUsers.show',
                'destroy' => 'dashboardUsers.destroy',
                'update' => 'dashboardUsers.update',
                'store' => 'dashboardUsers.store',
                'index' => 'dashboardUsers',
                'create' => 'dashboardUsers.create',
            ]
                ]
        );
        /*-- 23-12-21 by sajal--*/
        Route::bind('pharmacyList', function ($value, $route) {
            return Modules\Admin\Models\PharmacyList::find($value);
        });

        Route::resource(
            'admin/pharmacyList',
            'Modules\Admin\Http\Controllers\PharmacyListController',
            [
            'names' => [
                'edit' => 'pharmacyList.edit',
                'show' => 'pharmacyList.show',
                'destroy' => 'pharmacyList.destroy',
                'update' => 'pharmacyList.update',
                'store' => 'pharmacyList.store',
                'index' => 'pharmacyList',
                'create' => 'pharmacyList.create',
            ]
                ]
        );

         /*-- 24-12-21 by sajal--*/
        Route::bind('inventory', function ($value, $route) {
            return Modules\Admin\Models\Inventory::find($value);
        });

        Route::resource(
            'admin/inventory',
            'Modules\Admin\Http\Controllers\InventoryController',
            [
            'names' => [
                'edit' => 'inventory.edit',
                'show' => 'inventory.show',
                'destroy' => 'inventory.destroy',
                'update' => 'inventory.update',
                'store' => 'inventory.store',
                'index' => 'inventory',
                'create' => 'inventory.create'
            ]
                ]
        );

         Route::match(['get','post'],'admin/inventory-return', 
            [ 
                'as' => 'inventory-return', 
                'uses' => 'Modules\Admin\Http\Controllers\InventoryController@inventoryReturn'
            ]
        );

        Route::match(['get','post'],'admin/inventory-intake', 
            [ 
                'as' => 'intake', 
                'uses' => 'Modules\Admin\Http\Controllers\InventoryController@intake'
            ]
        );

        Route::match(['get','post'],'admin/unknown-item', 
            [ 
                'as' => 'unknown-item', 
                'uses' => 'Modules\Admin\Http\Controllers\InventoryController@unknownItem'
            ]
        );

        

        Route::match(['get','post'],'admin/return_store', 
            [ 
                'as' => 'return_store', 
                'uses' => 'Modules\Admin\Http\Controllers\InventoryController@return_store'
            ]
        );

        /*-- 25-12-21 by sajal--*/
        Route::bind('boxList', function ($value, $route) {
            return Modules\Admin\Models\BoxList::find($value);
        });

        Route::resource(
            'admin/boxList',
            'Modules\Admin\Http\Controllers\BoxListController',
            [
            'names' => [
                'edit' => 'boxList.edit',
                'show' => 'boxList.show',
                'destroy' => 'boxList.destroy',
                'update' => 'boxList.update',
                'store' => 'boxList.store',
                'index' => 'boxList',
                'create' => 'boxList.create'
            ]
                ]
        );

        Route::match(['get','post'],'admin/return_save', 
            [ 
                'as' => 'return_save', 
                'uses' => 'Modules\Admin\Http\Controllers\InventoryController@return_save'
            ]
        );

        Route::match(['get','post'],'admin/inventory-box-details', 
            [ 
                'as' => 'inventory-box-details', 
                'uses' => 'Modules\Admin\Http\Controllers\BoxListController@inventoryBoxDetails'
            ]
        );

    });
