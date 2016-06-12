<?php
Route::group(['namespace' => 'Admin', 'prefix' => 'backend'], function(){
    //Auth
    Route::controllers([
        'auth' => 'Auth\AuthController'
    ]);

    Route::group(['prefix' => '/', 'middleware' => ['admin.auth', 'menu', 'acl']], function(){
        Route::get('/', [
            'as' => 'admin.dashboard',
            'uses' => 'HomeController@dashboard'
        ]);

        Route::group(['prefix' => '/account'], function(){
            Route::get('/update', [
                'as' => 'admin.account.update',
                'uses' => 'AccountController@account_update'
            ]);

            Route::post('/save', [
                'as' => 'admin.account.save',
                'uses' => 'AccountController@account_save'
            ]);
        });

        //Admin
        Route::group(['prefix' => '/members', 'is' => 'administrator'], function(){
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

        Route::group(['prefix' => '/agents', 'is' => 'administrator'], function(){
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

        Route::group(['prefix' => '/viewing-schedules', 'is' => 'administrator'], function(){
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

        Route::group(['prefix' => '/customer-inquiry', 'is' => 'administrator|agent'], function(){
            Route::get('/{type}/index', [
                'as' => 'admin.customer_inquiry.index',
                'uses' => 'CustomerInquiryController@index'
            ]);

            Route::any('/{id}/assign-to-agent', [
                'as' => 'admin.customer_inquiry.assign_to_agent',
                'uses' => 'CustomerInquiryController@assignToAgent'
            ]);

            Route::any('/{id}/conversation', [
                'as' => 'admin.customer_inquiry.conversation',
                'uses' => 'CustomerInquiryController@conversation'
            ]);
        });

        //Agent
        Route::group(['prefix' => '/my-viewing-schedules', 'is' => 'agent'], function(){
            Route::get('/index', [
                'as' => 'agent.viewing_schedule.index',
                'uses' => 'Agent\ViewingScheduleController@index'
            ]);

            Route::any('/{id}/quick-edit', [
                'as' => 'agent.viewing_schedule.quick_edit',
                'uses' => 'Agent\ViewingScheduleController@quickEdit'
            ]);
        });

        //Properties
        Route::group(['prefix' => '/properties', 'is' => 'administrator|agent'], function(){
            Route::get('/index', [
                'as' => 'admin.property.index',
                'uses' => 'PropertyController@index'
            ]);

            Route::get('/{type}/index', [
                'as' => 'admin.property.index.agent',
                'uses' => 'PropertyController@indexAgent'
            ]);

            Route::get('/{id}/view', [
                'as' => 'admin.property.view',
                'uses' => 'PropertyController@view',
            ]);

            Route::get('/create', [
                'as' => 'admin.property.create',
                'uses' => 'PropertyController@create'
            ]);

            Route::post('/store', [
                'as' => 'admin.property.store',
                'uses' => 'PropertyController@store'
            ]);

            Route::group(['middleware' => ['can' => 'admin.can_edit']], function(){
                Route::get('/{id}/edit', [
                    'as' => 'admin.property.edit',
                    'uses' => 'PropertyController@edit',
                    'middleware' => ['admin.can_edit']
                ]);

                Route::post('/{id}/update', [
                    'as' => 'admin.property.update',
                    'uses' => 'PropertyController@update'
                ]);

                Route::get('/{id}/media', [
                    'as' => 'admin.property.media',
                    'uses' => 'PropertyController@media'
                ]);

                Route::post('/{id}/media/upload/{type}', [
                    'as' => 'admin.property.media.upload',
                    'uses' => 'PropertyController@photosUpload'
                ]);

                Route::get('/{id}/media/download/{type}', [
                    'as' => 'admin.property.media.download',
                    'uses' => 'PropertyController@photosDownload'
                ]);

                Route::get('/{id}/media/download/{type}/clear', [
                    'as' => 'admin.property.media.download.clear',
                    'uses' => 'PropertyController@photosDownloadClear'
                ]);

                Route::post('/{id}/media/delete/{attachment_id}', [
                    'as' => 'admin.property.media.delete',
                    'uses' => 'PropertyController@photosDelete'
                ]);

                Route::post('/{id}/media/delete/all/{type}', [
                    'as' => 'admin.property.media.delete_all',
                    'uses' => 'PropertyController@photosDeleteAll'
                ]);

                Route::get('/{id}/media/rotate/{dir}/{attachment_id}', [
                    'as' => 'admin.property.media.rotate',
                    'uses' => 'PropertyController@photosRotate'
                ]);

                Route::post('/{id}/delete', [
                    'as' => 'admin.property.delete',
                    'uses' => 'PropertyController@delete'
                ]);

                Route::post('/{id}/media/reorder', [
                    'as' => 'admin.property.media.reorder',
                    'uses' => 'PropertyController@photosReorder'
                ]);
            });
        });

        Route::group(['prefix' => '/properties', 'is' => 'administrator'], function(){
            Route::any('/{id}/assign-to-agent', [
                'as' => 'admin.property.assign_to_agent',
                'uses' => 'PropertyController@assignToAgent'
            ]);

            Route::post('/{id}/delete/force', [
                'as' => 'admin.property.delete.force',
                'uses' => 'PropertyController@deleteForce'
            ]);

            Route::post('/{id}/restore', [
                'as' => 'admin.property.restore',
                'uses' => 'PropertyController@restore'
            ]);
        });

        //Pages
        Route::group(['prefix' => '/pages', 'is' => 'administrator'], function(){
            Route::get('/index', [
                'as' => 'admin.page.index',
                'uses' => 'PageController@index'
            ]);

            Route::get('/{lang}/create', [
                'as' => 'admin.page.create',
                'uses' => 'PageController@create'
            ]);

            Route::post('/{lang}/store', [
                'as' => 'admin.page.store',
                'uses' => 'PageController@store'
            ]);

            Route::get('/{lang}/{id}/edit', [
                'as' => 'admin.page.edit',
                'uses' => 'PageController@edit'
            ]);

            Route::post('/{lang}/{id}/update', [
                'as' => 'admin.page.update',
                'uses' => 'PageController@update'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.page.delete',
                'uses' => 'PageController@delete'
            ]);
        });

        //Testimonials
        Route::group(['prefix' => '/testimonials', 'is' => 'administrator'], function(){
            Route::get('/index', [
                'as' => 'admin.testimonial.index',
                'uses' => 'TestimonialController@index'
            ]);

            Route::get('/{lang}/create', [
                'as' => 'admin.testimonial.create',
                'uses' => 'TestimonialController@create'
            ]);

            Route::post('/{lang}/store', [
                'as' => 'admin.testimonial.store',
                'uses' => 'TestimonialController@store'
            ]);

            Route::get('/{lang}/{id}/edit', [
                'as' => 'admin.testimonial.edit',
                'uses' => 'TestimonialController@edit'
            ]);

            Route::post('/{lang}/{id}/update', [
                'as' => 'admin.testimonial.update',
                'uses' => 'TestimonialController@update'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.testimonial.delete',
                'uses' => 'TestimonialController@delete'
            ]);
        });

        //Main Banners
        Route::group(['prefix' => '/main-banners', 'is' => 'administrator'], function(){
            Route::get('/index', [
                'as' => 'admin.main_banner.index',
                'uses' => 'MainBannerController@index'
            ]);

            Route::get('/{lang}/create', [
                'as' => 'admin.main_banner.create',
                'uses' => 'MainBannerController@create'
            ]);

            Route::post('/{lang}/store', [
                'as' => 'admin.main_banner.store',
                'uses' => 'MainBannerController@store'
            ]);

            Route::get('/{lang}/{id}/edit', [
                'as' => 'admin.main_banner.edit',
                'uses' => 'MainBannerController@edit'
            ]);

            Route::post('/{lang}/{id}/update', [
                'as' => 'admin.main_banner.update',
                'uses' => 'MainBannerController@update'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.main_banner.delete',
                'uses' => 'MainBannerController@delete'
            ]);
        });

        Route::group(['prefix' => 'blog', 'namespace' => 'Post', 'is' => 'administrator'], function(){
            //Category
            Route::group(['prefix' => '/categories'], function(){
                Route::get('/index', [
                    'as' => 'admin.post.category.index',
                    'uses' => 'CategoryController@index'
                ]);

                Route::get('/{lang}/create', [
                    'as' => 'admin.post.category.create',
                    'uses' => 'CategoryController@create'
                ]);

                Route::post('/{lang}/store', [
                    'as' => 'admin.post.category.store',
                    'uses' => 'CategoryController@store'
                ]);

                Route::get('/{lang}/{id}/edit', [
                    'as' => 'admin.post.category.edit',
                    'uses' => 'CategoryController@edit'
                ]);

                Route::post('/{lang}/{id}/update', [
                    'as' => 'admin.post.category.update',
                    'uses' => 'CategoryController@update'
                ]);

                Route::post('/{id}/delete', [
                    'as' => 'admin.post.category.delete',
                    'uses' => 'CategoryController@delete'
                ]);
            });

            //Tag
            Route::group(['prefix' => '/tags'], function(){
                Route::get('/index', [
                    'as' => 'admin.post.tag.index',
                    'uses' => 'TagController@index'
                ]);

                Route::get('/{lang}/create', [
                    'as' => 'admin.post.tag.create',
                    'uses' => 'TagController@create'
                ]);

                Route::post('/{lang}/store', [
                    'as' => 'admin.post.tag.store',
                    'uses' => 'TagController@store'
                ]);

                Route::get('/{lang}/{id}/edit', [
                    'as' => 'admin.post.tag.edit',
                    'uses' => 'TagController@edit'
                ]);

                Route::post('/{lang}/{id}/update', [
                    'as' => 'admin.post.tag.update',
                    'uses' => 'TagController@update'
                ]);

                Route::post('/{id}/delete', [
                    'as' => 'admin.post.tag.delete',
                    'uses' => 'TagController@delete'
                ]);
            });

            //Post
            Route::group(['prefix' => '/posts'], function(){
                Route::get('/index', [
                    'as' => 'admin.post.index',
                    'uses' => 'PostController@index'
                ]);

                Route::get('/{lang}/create', [
                    'as' => 'admin.post.create',
                    'uses' => 'PostController@create'
                ]);

                Route::post('/{lang}/store', [
                    'as' => 'admin.post.store',
                    'uses' => 'PostController@store'
                ]);

                Route::get('/{lang}/{id}/edit', [
                    'as' => 'admin.post.edit',
                    'uses' => 'PostController@edit'
                ]);

                Route::post('/{lang}/{id}/update', [
                    'as' => 'admin.post.update',
                    'uses' => 'PostController@update'
                ]);

                Route::post('/{id}/delete', [
                    'as' => 'admin.post.delete',
                    'uses' => 'PostController@delete'
                ]);
            });
        });

        //Area
        Route::group(['prefix' => '/location/area', 'is' => 'administrator'], function(){
            Route::get('/index', [
                'as' => 'admin.location.area.index',
                'uses' => 'LocationController@indexArea'
            ]);

            Route::get('/create', [
                'as' => 'admin.location.area.create',
                'uses' => 'LocationController@createArea'
            ]);

            Route::post('/store', [
                'as' => 'admin.location.area.store',
                'uses' => 'LocationController@storeArea'
            ]);

            Route::get('/{id}/edit', [
                'as' => 'admin.location.area.edit',
                'uses' => 'LocationController@editArea'
            ]);

            Route::post('/{id}/update', [
                'as' => 'admin.location.area.update',
                'uses' => 'LocationController@updateArea'
            ]);

            Route::post('/{id}/delete', [
                'as' => 'admin.location.area.delete',
                'uses' => 'LocationController@deleteArea'
            ]);
        });

        //Others
        Route::get('/members/find/autocomplete', [
            'as' => 'admin.member.find.auto_complete',
            'uses' => 'MemberController@findAutocomplete'
        ]);

        Route::get('/packages/{id}/features/{all?}', [
            'as' => 'admin.package.features',
            'uses' => 'PackageController@features'
        ]);
    });
});

Route::group([
    'namespace' => 'Frontend',
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect']
], function(){
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

            Route::post('message/send/{property_id?}', [
                'as' => 'frontend.account.inbox.send_message',
                'uses' => 'AccountController@postSendMessage'
            ]);

            Route::get('message/replies/{property_id}', [
                'as' => 'frontend.account.inbox.get_replies',
                'uses' => 'AccountController@getReplies'
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

        Route::get('/{id}/view', [
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

        Route::get('/{id}/toggle_like', [
            'as' => 'frontend.property.toggle_like',
            'uses' => 'PropertyController@getToggleLikeProperty'
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
            'as' => 'frontend.property.set_unpublish',
            'uses' => 'PropertyController@getUnpublish'
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

        Route::get('/photos/rotate/{dir}/{id}/{attachment_id}', [
            'as' => 'frontend.property.photos.rotate',
            'uses' => 'PropertyController@getPropertyPhotosRotate'
        ]);

        Route::post('/photos/reorder/{id}/{type}', [
            'as' => 'frontend.property.photos.reorder',
            'uses' => 'PropertyController@postPropertyPhotosReorder'
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

        Route::get('/xml/lamudi', [
            'as' => 'frontend.property.xml.lamudi',
            'uses' => 'PortalController@getXMLLamudi'
        ]);
    });

    //Pages
    Route::get('/', [
        'as' => 'frontend.page.home',
        'uses' => 'PageController@home'
    ]);

    Route::any('contact', [
        'as' => 'frontend.page.contact',
        'uses' => 'ContactController@contact'
    ]);

    Route::any('referral-listing', [
        'as' => 'frontend.page.referral_listing',
        'uses' => 'PageController@referralListing'
    ]);

    Route::get('resources', [
        'as' => 'frontend.page.resources',
        'uses' => 'PageController@resources'
    ]);

    Route::get('resources/category/{category}', [
        'as' => 'frontend.page.resources.category',
        'uses' => 'PageController@resources'
    ]);

    Route::get('resources/{slug}', [
        'as' => 'frontend.page.resources.post',
        'uses' => 'PageController@resourcePost'
    ]);

    Route::get('{identifier}', [
        'as' => 'frontend.page.static_page',
        'uses' => 'PageController@staticPage'
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