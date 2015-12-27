<?php
Route::group(['namespace' => 'Admin', 'prefix' => 'backend'], function(){
    //Auth
    Route::controllers([
        'auth' => 'Auth\AuthController'
    ]);

    Route::group(['prefix' => '/', 'middleware' => ['admin.auth', 'menu', 'acl'], 'is' => 'administrator'], function(){
        Route::get('/', [
            'as' => 'admin.dashboard',
            'uses' => 'HomeController@dashboard'
        ]);

        Route::group(['prefix' => '/members'], function(){
            Route::get('/index', [
                'as' => 'admin.member.index',
                'uses' => 'MemberController@index'
            ]);

            Route::get('/create', [
                'as' => 'admin.member.create',
                'uses' => 'MemberController@create'
            ]);

            Route::post('/store', [
                'as' => 'admin.member.store',
                'uses' => 'MemberController@store'
            ]);

            Route::get('/{id}/edit', [
                'as' => 'admin.member.edit',
                'uses' => 'MemberController@edit'
            ]);

            Route::post('/{id}/update', [
                'as' => 'admin.member.update',
                'uses' => 'MemberController@update'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.member.delete',
                'uses' => 'MemberController@delete'
            ]);
        });

        Route::group(['prefix' => '/agents'], function(){
            Route::get('/index', [
                'as' => 'admin.agent.index',
                'uses' => 'AgentController@index'
            ]);

            Route::get('/create', [
                'as' => 'admin.agent.create',
                'uses' => 'AgentController@create'
            ]);

            Route::post('/store', [
                'as' => 'admin.agent.store',
                'uses' => 'AgentController@store'
            ]);

            Route::get('/{id}/edit', [
                'as' => 'admin.agent.edit',
                'uses' => 'AgentController@edit'
            ]);

            Route::post('/{id}/update', [
                'as' => 'admin.agent.update',
                'uses' => 'AgentController@update'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.agent.delete',
                'uses' => 'AgentController@delete'
            ]);
        });

        Route::group(['prefix' => '/viewing-schedules'], function(){
            Route::get('/index', [
                'as' => 'admin.viewing_schedule.index',
                'uses' => 'ViewingScheduleController@index'
            ]);

            Route::any('/{id}/assign-to-agent', [
                'as' => 'admin.viewing_schedule.assign_to_agent',
                'uses' => 'ViewingScheduleController@assignToAgent'
            ]);

            Route::any('/{id}/quick-edit', [
                'as' => 'admin.viewing_schedule.quick_edit',
                'uses' => 'ViewingScheduleController@quickEdit'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.viewing_schedule.delete',
                'uses' => 'ViewingScheduleController@delete'
            ]);
        });
    });
});

Route::group(['namespace' => 'Frontend'], function(){
    //Account
    Route::group(['prefix' => '/account'], function(){
        Route::get('/register', [
            'as' => 'frontend.account.register',
            'uses' => 'Auth\AuthController@getRegister'
        ]);

        Route::post('/register', [
            'as' => 'frontend.account.register.process',
            'uses' => 'Auth\AuthController@postRegister'
        ]);

        Route::get('/login', [
            'as' => 'frontend.account.login',
            'uses' => 'Auth\AuthController@getLogin'
        ]);

        Route::post('/login', [
            'as' => 'frontend.account.login.process',
            'uses' => 'Auth\AuthController@postLogin'
        ]);

        Route::get('/email', [
            'as' => 'frontend.account.email',
            'uses' => 'Auth\PasswordController@getEmail'
        ]);

        Route::post('/email', [
            'as' => 'frontend.account.email.process',
            'uses' => 'Auth\PasswordController@postEmail'
        ]);

        Route::get('/reset', [
            'as' => 'frontend.account.reset',
            'uses' => 'Auth\PasswordController@getReset'
        ]);

        Route::post('/reset', [
            'as' => 'frontend.account.reset.process',
            'uses' => 'Auth\PasswordController@postReset'
        ]);

        Route::get('/logout', [
            'as' => 'frontend.account.logout',
            'uses' => 'Auth\AuthController@getLogout'
        ]);

        Route::group(['middleware' => ['auth']], function(){
            Route::get('/dashboard', [
                'as' => 'frontend.account.dashboard',
                'uses' => 'AccountController@dashboard'
            ]);

            Route::get('profile', [
                'as' => 'frontend.account.profile',
                'uses' => 'AccountController@getProfile'
            ]);

            Route::post('profile', [
                'as' => 'frontend.account.profile.process',
                'uses' => 'AccountController@postProfile'
            ]);

            Route::get('inbox/{property_id?}', [
                'as' => 'frontend.account.inbox',
                'uses' => 'AccountController@getInbox'
            ]);

            Route::post('send_message/{property_id?}', [
                'as' => 'frontend.account.inbox.send_message',
                'uses' => 'AccountController@postSendMessage'
            ]);

            Route::get('viewings', [
                'as' => 'frontend.account.viewings',
                'uses' => 'AccountController@getViewings'
            ]);

            Route::get('viewings/calendar/data', [
                'as' => 'frontend.account.viewings.data',
                'uses' => 'AccountController@getViewingsData'
            ]);

            Route::get('viewings/calendar/my-properties/data', [
                'as' => 'frontend.account.viewings.my_properties.data',
                'uses' => 'AccountController@getViewingsMyPropertiesData'
            ]);
        });
    });

    //Property
    Route::group(['prefix' => '/property'], function(){
        Route::get('/my-properties/{for}', [
            'as' => 'frontend.property.index',
            'uses' => 'PropertyController@index'
        ]);

        Route::get('/simple-search', [
            'as' => 'frontend.property.simple_search',
            'uses' => 'PropertyController@getSimpleSearch'
        ]);

        Route::get('/search', [
            'as' => 'frontend.property.search',
            'uses' => 'PropertyController@getSearch'
        ]);

        Route::get('/{for}/{id}/view', [
            'as' => 'frontend.property.view',
            'uses' => 'PropertyController@getView'
        ]);

        Route::get('/{id}/like', [
            'as' => 'frontend.property.like',
            'uses' => 'PropertyController@getLikeProperty'
        ]);

        Route::get('/{id}/unlike', [
            'as' => 'frontend.property.unlike',
            'uses' => 'PropertyController@getUnlikeProperty'
        ]);

        Route::get('/compare', [
            'as' => 'frontend.property.compare',
            'uses' => 'PropertyController@getCompare'
        ]);

        Route::get('/{id}/compare/add', [
            'as' => 'frontend.property.compare.add',
            'uses' => 'PropertyController@getAddToComparison'
        ]);

        Route::get('/{id}/compare/remove', [
            'as' => 'frontend.property.compare.remove',
            'uses' => 'PropertyController@getRemoveFromComparison'
        ]);

        Route::get('/{id}/schedule-viewing', [
            'as' => 'frontend.property.schedule_viewing',
            'uses' => 'PropertyController@getScheduleViewing'
        ]);

        Route::post('/{id}/schedule-viewing', [
            'as' => 'frontend.property.schedule_viewing.process',
            'uses' => 'PropertyController@postScheduleViewing'
        ]);

        Route::post('/add-to-cart', [
            'as' => 'frontend.property.add_to_cart',
            'uses' => 'PropertyController@postAddToCart'
        ]);

        Route::get('/unpublish-edit/{id}', [
            'as' => 'frontend.property.set_draft_edit',
            'uses' => 'PropertyController@getDraftEdit'
        ]);

        Route::get('/create', [
            'as' => 'frontend.property.create',
            'uses' => 'PropertyController@getCreate'
        ]);

        Route::post('/create', [
            'as' => 'frontend.property.create.process',
            'uses' => 'PropertyController@postCreate'
        ]);

        Route::get('/edit/{id}', [
            'as' => 'frontend.property.edit',
            'uses' => 'PropertyController@getEdit'
        ]);

        Route::post('/edit/{id}', [
            'as' => 'frontend.property.edit.process',
            'uses' => 'PropertyController@postEdit'
        ]);

        Route::get('/details/{id}', [
            'as' => 'frontend.property.details',
            'uses' => 'PropertyController@getPropertyDetails'
        ]);

        Route::post('/details/{id}', [
            'as' => 'frontend.property.details.process',
            'uses' => 'PropertyController@postPropertyDetails'
        ]);

        Route::get('/map/{id}', [
            'as' => 'frontend.property.map',
            'uses' => 'PropertyController@getPropertyMap'
        ]);

        Route::post('/map/{id}', [
            'as' => 'frontend.property.map.process',
            'uses' => 'PropertyController@postPropertyMap'
        ]);

        Route::get('/photos/{id}', [
            'as' => 'frontend.property.photos',
            'uses' => 'PropertyController@getPropertyPhotos'
        ]);

        Route::post('/photos/{id}', [
            'as' => 'frontend.property.photos.process',
            'uses' => 'PropertyController@postPropertyPhotos'
        ]);

        Route::get('/floorplans/{id}', [
            'as' => 'frontend.property.floorplans',
            'uses' => 'PropertyController@getPropertyFloorplans'
        ]);

        Route::post('/floorplans/{id}', [
            'as' => 'frontend.property.floorplans.process',
            'uses' => 'PropertyController@postPropertyFloorplans'
        ]);

        Route::post('/photos/upload/{id}/{type}', [
            'as' => 'frontend.property.photos.upload',
            'uses' => 'PropertyController@postPropertyPhotosUpload'
        ]);

        Route::post('/photos/delete/{id}/{attachment_id}', [
            'as' => 'frontend.property.photos.delete',
            'uses' => 'PropertyController@postPropertyPhotosDelete'
        ]);

        Route::get('/packages/{id}', [
            'as' => 'frontend.property.packages',
            'uses' => 'PropertyController@getPropertyPackages'
        ]);

        Route::post('/packages/{id}', [
            'as' => 'frontend.property.packages.process',
            'uses' => 'PropertyController@postPropertyPackages'
        ]);

        Route::get('/review/{id}', [
            'as' => 'frontend.property.review',
            'uses' => 'PropertyController@getPropertyOrderReview'
        ]);

        Route::post('/review/{id}', [
            'as' => 'frontend.property.review.process',
            'uses' => 'PropertyController@postPropertyOrderReview'
        ]);

        Route::get('/payment/{id}', [
            'as' => 'frontend.property.payment',
            'uses' => 'PropertyController@getPropertyPayment'
        ]);

        Route::get('/success/{id}', [
            'as' => 'frontend.property.success',
            'uses' => 'PropertyController@getPropertySuccess'
        ]);
    });

    //Pages
    Route::get('/', [
        'as' => 'frontend.page.home',
        'uses' => 'PageController@home'
    ]);

    Route::get('/property-terms-conditions', [
        'as' => 'frontend.page.property_terms_conditions',
        'uses' => 'PageController@propertyTermsConditions'
    ]);
});

Route::post('/contact/request-call', [
    'as' => 'contact.request_call',
    'uses' => 'Frontend\ContactController@requestCall'
]);

Route::get('/address_helper/get/{type}', [
    'as' => 'address_helper.get',
    'uses' => 'AddressController@get'
]);