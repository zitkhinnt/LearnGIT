<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/** API start */
Route::group(['prefix' => 'api'], function () {
    Route::get('/deposit-result', 'API\APIController@depositResult')->name('api.deposit_result');
    Route::post('/deposit-result', 'API\APIController@depositResult')->name('api.deposit_result');

    //API check user register after 24h Multidomain
    Route::post('/is-register-24-hours', 'API\APIController@isUserRegisterAfter24h')->name('api.user.is.register');

});
/** API End */

/** Socialite Start */
// Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider')->name("socialite");
// Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback')->name("socialite_callback");

/** Socialite End */

Route::prefix('')->group(function () {
    
    Route::middleware(['loginByKey'])->group(function (){
        /** Frontend start **/
        // Before login start
        Route::get('/about', 'Frontend\BeforeLoginController@about')->name('before_about');
        Route::get('/result-bf', 'Frontend\BeforeLoginController@result')->name('before_result');
        Route::get('/privacy-bf', 'Frontend\BeforeLoginController@privacy')->name('before_privacy');
        Route::get('/trans-bf', 'Frontend\BeforeLoginController@trans')->name('before_trans');
        Route::get('/contact-bf', 'Frontend\BeforeLoginController@contact')->name('before_contact');
        Route::get('/service-bf', 'Frontend\BeforeLoginController@service')->name('before_service');
        Route::get('/entry-bf', 'Frontend\BeforeLoginController@entry')->name('before_entry');
        Route::get('/password_forget', 'Frontend\BeforeLoginController@forgetPassword')->name('password_forget');

        Route::post('/contact-bf-store', 'Frontend\BeforeLoginController@storeContact')->name('before_contact.store');
        // Before login end

        /* bicycle-race*/
        /*  Route::get('/about-bf', 'Frontend\BeforeLoginController@about')->name('before_about');
        Route::get('/service-bf', 'Frontend\BeforeLoginController@service')->name('before_service');
        Route::get('/privacy-bf', 'Frontend\BeforeLoginController@privacy')->name('before_privacy');
        Route::get('/transaction-bf', 'Frontend\BeforeLoginController@transaction')->name('before_transaction');
        */

        //login
        Route::get('/login-smp', 'Auth\LoginController@showLoginSMPForm')->name('login_smp');

        /* end bicycle-race*/

        Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::get('/login', 'Auth\LoginController@LoginForm')->name('login.form');
        Route::post('/login', 'Auth\LoginController@login')->name('login.submit');
        Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
        Route::post('/register', 'Frontend\RegisterController@registerUser')->name('register');
        Route::post('/forget-password', 'Frontend\RegisterController@forgetPassword')->name('forget_password');

        // Login by user key
        Route::get('/login/{user_key}', 'Auth\LoginController@loginByUserKey')->name('login.user_key');
        Route::get('/user_key/{user_key}', 'Frontend\LoginController@userKeyLogin')->name('user_key');

        //Route::get('/', 'HorseraceController@index');
        Route::get('/error', 'HorseraceController@error')->name('error');
        Route::get('/home', 'Frontend\PageController@getHome')->name('home');
        Route::post('/home', 'Frontend\PageController@getHomePost')->name('home');
        Route::get('/about-one', 'Frontend\PageController@aboutOne')->name('about_one');
        Route::get('/about-two', 'Frontend\PageController@aboutTwo')->name('about_two');
        Route::get('/about-three', 'Frontend\PageController@aboutThree')->name('about_three');

        Route::get('/about', 'Frontend\PageController@getAbout')->name('about');
        Route::get('/list', 'Frontend\PageController@getList')->name('list');
        Route::get('/course', 'Frontend\PageController@getCourse')->name('course');
        Route::get('/faq', 'Frontend\PageController@getFAQ')->name('faq');
        Route::get('/agree', 'Frontend\PageController@getAgree')->name('agree');
        Route::get('/privacy', 'Frontend\PageController@getPrivacy')->name('privacy');
        Route::get('/trans', 'Frontend\PageController@getTrans')->name('trans');
        Route::get('/voice', 'Frontend\PageController@getVoice')->name('voice');
        Route::get('/d-mail', 'Frontend\PageController@getDocomoMail')->name('docomo_mail');

        // my page
        Route::get('/my-page', 'Frontend\UserController@getMyPage')->name('mypage');
        // info
        Route::post('/change-infomation', 'Frontend\UserController@changeInfo')->name('mypage.change.info');
        // mail pc
        Route::post('/change-mail-pc', 'Frontend\UserController@changeMailPC')->name('mypage.change.mail_pc');
        Route::get('/change-mail-pc-verify', 'Frontend\UserController@verifychangeMailPC');
        // mail mobile
        Route::post('/change-mail-mobile', 'Frontend\UserController@changeMailMobile')->name('mypage.change.mail_mobile');
        // password
        Route::post('/change-password', 'Frontend\UserController@changePassword')->name('mypage.change.password');

        // contact
        // Mail
        Route::get('/mail-box', 'Frontend\MailController@mailBox')->name('mail_box');
        Route::get('/mail-info/{type}/{id_mail}', 'Frontend\MailController@getMailInfo')->name('mail_info');
        Route::get('/contact', 'Frontend\MailController@getContact')->name('contact');
        Route::post('/store-contact', 'Frontend\MailController@storeContact')->name('contact.store');
        Route::post('/deleted-mail', 'Frontend\MailController@deletedMail')->name('deleted_mail');

        //point
        Route::get('/point', 'Frontend\PageController@getPoint')->name('point');
        Route::post('/charge-top-confirm',
            'Frontend\PointController@pointChargeTopConfirm')->name('point.charge_top_confirm');
        //charge top bank - credit
        Route::post('/point-charge-top-bank',
            'Frontend\PointController@getPointChargeTopBank')->name('point.charge_top_bank');
        Route::post('/point-charge-top-credit',
            'Frontend\PointController@getPointChargeTopCredit')->name('point.charge_top_credit');
        //charge top bank - credit comp
        Route::post('/point-charge-top-bank-complete',
            'Frontend\PointController@getPointChargeTopBankComp')->name('point.charge_top_bank_comp');
        Route::post('/point-charge-top-credit-complete',
            'Frontend\PointController@getPointChargeTopCreditComp')->name('point.charge_top_credit_comp');

        // prediction
        Route::get('/pre/{prediction_type_code}', 'Frontend\PredictionController@predictions')->name('pre_list');
        // dat commnet not use
        // Route::get('/pre-trial01', 'Frontend\PredictionController@predictionTrial01')->name('pre_trial01');
        // Route::get('/pre-trial02', 'Frontend\PredictionController@predictionTrial02')->name('pre_trial02');
        // Route::get('/pre-1st', 'Frontend\PredictionController@prediction1st')->name('pre_1st');
        // Route::get('/pre-2nd', 'Frontend\PredictionController@prediction2nd')->name('pre_2nd');
        // Route::get('/pre-3rd', 'Frontend\PredictionController@prediction3rd')->name('pre_3rd');
        // Route::get('/pre-4th', 'Frontend\PredictionController@prediction4th')->name('pre_4th');
        // Route::get('/pre-5th', 'Frontend\PredictionController@prediction5th')->name('pre_5th');

        // Route::get('/special', 'Frontend\PredictionController@predictionSpecial')->name('special');
        // Route::get('/crystal', 'Frontend\PredictionController@predictionCrystal')->name('crystal');
        // Route::get('/diamond', 'Frontend\PredictionController@predictionDiamond')->name('diamond');
        // Route::get('/gold', 'Frontend\PredictionController@predictionGold')->name('gold');
        // Route::get('/trial', 'Frontend\PredictionController@predictionTrail')->name('trial');

        Route::post('/buy-prediction', 'Frontend\PredictionController@buyPrediction')->name('buy_prediction');
        Route::get('/prediction-detail/{id_prediction}', 'Frontend\PredictionController@predictionDetail')->name('prediction_detail');
        Route::get('/week', 'Frontend\PredictionController@getWeek')->name('week');

        // Blog
        Route::get('/blog-detail/{blog_id}', 'Frontend\ContentController@getBlogDetail')->name('blog_detail');
        /*Route::get('/column', 'Frontend\ContentController@getColumn')->name('column');*/
        Route::get('/free', 'Frontend\ContentController@getFree')->name('free');

        // Result
        Route::get('/result-detail/{result_id}', 'Frontend\ContentController@getResultDetail')->name('result_detail');
        Route::get('/result', 'Frontend\ContentController@result')->name('result');

    /** Frontend end **/
    });
    /** Backend start **/
    Route::group(['prefix' => 'admin'], function () {

        Route::middleware(['basicAuth'])->group(function () {

            // Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.dashboard');
            Route::get('/error404', 'SystemController@error404')->name('admin.error404');

            // Login
            Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
            Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
            Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

            //    // Login - Logout
            //    Route::get('/', 'Backend\AdminLoginController@loginView')->name('admin.login');
            //    Route::get('/register', 'Backend\AdminLoginController@registerView')->name('admin.register');
            //    Route::get('/forgot-password', 'Backend\AdminLoginController@forgotPasswordView')->name('admin.forgot.password');

            // Dashboard
            Route::get('/dashboard', 'Backend\DashboardController@dashboardView')->name('admin.dashboard');
            // Holiday
            Route::get('/holiday', 'Backend\DashboardController@holiday')->name('admin.holiday');

            // User
            Route::get('/user', 'Backend\UserController@user')->name('admin.user');
            Route::get('/add-user', 'Backend\UserController@addUser')->name('admin.user.add');
            Route::get('/list-query-search-user', 'Backend\UserController@listQuerySearchUser')->name('admin.list.query.search.user');
            Route::post('/add-query-search-user', 'Backend\UserController@addQuerySearchUser')->name('admin.add.query.search.user');
            Route::post('/update-query-search-user', 'Backend\UserController@updateQuerySearchUser')->name('admin.update.query.search.user');
            Route::get('/delete-query-search-user/{id}', 'Backend\UserController@deleteQuerySearchUser')->name('delete.query.search.user');
            Route::get('/edit-user/{id}', 'Backend\UserController@editUser')->name('admin.user.edit');
            Route::post('/store-user', 'Backend\UserController@storeUser')->name('admin.user.store');
            Route::post('/update-user/{id}', 'Backend\UserController@updateUser')->name('admin.user.update');
            Route::get('/search-user', 'Backend\UserController@searchUser')->name('admin.user.search');
            Route::post('/search-user-post', 'Backend\UserController@searchUserPost')->name('admin.user.search.post');
            Route::get('/search-user-post-ajax', 'Backend\UserController@searchUserPostAjax')->name('admin.user.search.post.ajax');
            // User interim
            Route::post('/search-user-interim-post', 'Backend\UserController@searchUserInterimPost')->name('admin.user_interim.search.post');
            Route::get('/search-user-interim-post-ajax', 'Backend\UserController@searchUserInterimPostAjax')->name('admin.user_interim.search.post.ajax');
            Route::post('/deleted-user-interim', 'Backend\UserController@deletedUerInterim')->name('admin.user_interim.delete');
            Route::get('/user-interim', 'Backend\UserController@userInterim')->name('admin.user.interim');
            Route::get('/export-csv-user', 'Backend\UserController@exportCSVUser')->name('admin.user.export_csv');
            Route::get('/export-csv-user-interim', 'Backend\UserController@exportCSVUserInterim')->name('admin.user_interim.export_csv');
            // User log prediction
            Route::get('/user-access-prediction/{prediction_id}', 'Backend\UserController@userAccessPrediction')->name('admin.user.access_prediction');
            Route::get('/user-buy-prediction/{prediction_id}', 'Backend\UserController@userBuyPrediction')->name('admin.user.buy_prediction');
            Route::post('/add-user-buy-prediction', 'Backend\UserController@addUserBuyPrediction')->name('admin.user.add_buy_prediction');
            Route::post('/delete-user-buy-prediction', 'Backend\UserController@deleteUserBuyPrediction')->name('admin.user.buy_prediction.delete');
            // User log blog
            Route::get('/user-access-blog/{blog_id}', 'Backend\UserController@userAccessBlog')->name('admin.user.access_blog');
            // Update user stage
            Route::post('/add-all-user-stage', 'Backend\UserController@addAllUserStage')->name('admin.user.add_user_stage');
            Route::post('/edit-all-user-stage', 'Backend\UserController@editAllUserStage')->name('admin.user.edit_user_stage');
            Route::post('/deleted-all-user-stage', 'Backend\UserController@deletedAllUserStage')->name('admin.user.deleted_user_stage');
            // User login
            Route::get('/user-login/{id}', 'Backend\UserController@userLogin')->name('admin.user_login');
            // User buy prediction
            Route::get('/search-user-buy-prediction', 'Backend\UserController@searchUserBuyPrediction')->name('admin.user.search_buy_prediction');
            // User login history
            Route::get('/search-user-login-history', 'Backend\UserController@searchUserLoginHistory')->name('admin.user.search_login_history');
            Route::post('/user-login-history', 'Backend\UserController@userLoginHistory')->name('admin.user.login_history');
            Route::get('/user-login-history-ajax', 'Backend\UserController@userLoginHistoryAjax')->name('admin.user.login_history.ajax');
            // Payment
            Route::get('/payment', 'Backend\PaymentController@payment')->name('admin.payment');
            Route::get('/payment-ajax', 'Backend\PaymentController@paymentAjax')->name('admin.payment.ajax');
            Route::get('/deposit', 'Backend\PaymentController@deposit')->name('admin.deposit');
            Route::get('/deposit-ajax', 'Backend\PaymentController@depositAjax')->name('admin.deposit.ajax');
            Route::post('/apply-deposit', 'Backend\PaymentController@applyDeposit')->name('admin.deposit.apply');
            //add deposit manual
            Route::post('/add-deposit', 'Backend\PaymentController@addDeposit')->name('admin.deposit.add');
            Route::get('/trans-gift', 'Backend\PaymentController@gift')->name('admin.trans_gift');
            Route::get('/trans-gift-ajax', 'Backend\PaymentController@giftAjax')->name('admin.trans_gift.ajax');
            Route::post('/add-gift-bonus', 'Backend\PaymentController@addGiftBonus')->name('admin.trans_gift_bonus.add');
            Route::post('/add-gift-all', 'Backend\PaymentController@addGiftAll')->name('admin.gift_all.add');
            Route::post('/remove-gift-all', 'Backend\PaymentController@removeGiftAll')->name('admin.gift_all.remove');
            /* Content start */
            // result
            Route::get('/result', 'Backend\ContentController@result')->name('admin.result');
            Route::get('/ajax-result', 'Backend\ContentController@resultAjax')->name('admin.result.ajax');
            Route::get('/add-result', 'Backend\ContentController@addResult')->name('admin.result.add');
            Route::get('/edit-result/{result_id}', 'Backend\ContentController@editResult')->name('admin.result.edit');
            Route::post('/store-result', 'Backend\ContentController@storeResult')->name('admin.result.store');
            Route::post('/delete-result', 'Backend\ContentController@deleteResult')->name('admin.result.delete');

            // blog
            Route::get('/blog', 'Backend\ContentController@blog')->name('admin.blog');
            Route::get('/add-blog', 'Backend\ContentController@addBlog')->name('admin.blog.add');
            Route::get('/edit-blog/{blog_id}', 'Backend\ContentController@editBlog')->name('admin.blog.edit');
            Route::post('/store-blog', 'Backend\ContentController@storeBlog')->name('admin.blog.store');
            Route::get('/review-blog/{blog_id}', 'Backend\ContentController@reviewBlog')->name('admin.blog.review');
            Route::post('/delete-blog', 'Backend\ContentController@deleteBlog')->name('admin.blog.delete');

            // Gift
            Route::get('/gift', 'Backend\ContentController@gift')->name('admin.gift');
            Route::get('/add-gift', 'Backend\ContentController@addGift')->name('admin.gift.add');
            Route::get('/edit-gift/{gift_id}', 'Backend\ContentController@editGift')->name('admin.gift.edit');
            Route::post('/store-gift', 'Backend\ContentController@storeGift')->name('admin.gift.store');
            Route::post('/delete-gift', 'Backend\ContentController@deleteGift')->name('admin.gift.delete');
            /* Content end */

            /* Site start */
            // Entrance
            Route::get('/entrance', 'Backend\SiteController@getEntrance')->name('admin.entrance');
            Route::get('/add-entrance', 'Backend\SiteController@addEntrance')->name('admin.entrance.add');
            Route::get('/edit-entrance/{entrance_id}', 'Backend\SiteController@editEntrance')->name('admin.entrance.edit');
            Route::post('/store-entrance', 'Backend\SiteController@storeEntrance')->name('admin.entrance.store');
            Route::post('/delete-entrance', 'Backend\SiteController@deleteEntrance')->name('admin.entrance.delete');

            // Page
            Route::get('/page', 'Backend\SiteController@getPage')->name('admin.page');
            Route::get('/add-page', 'Backend\SiteController@addPage')->name('admin.page.add');
            Route::get('/edit-page/{page_id}', 'Backend\SiteController@editPage')->name('admin.page.edit');
            Route::post('/store-page', 'Backend\SiteController@storePage')->name('admin.page.store');
            Route::post('/delete-page', 'Backend\SiteController@deletePage')->name('admin.page.delete');

            // Point
            Route::get('/point', 'Backend\SiteController@getPoint')->name('admin.point');
            Route::post('/store-point', 'Backend\SiteController@storePoint')->name('admin.point.store');
            Route::get('/edit-point/{point_id}', 'Backend\SiteController@editPoint')->name('admin.point.edit');
            Route::post('/delete-point', 'Backend\SiteController@deletePoint')->name('admin.point.delete');

            // Venue
            Route::get('/venue', 'Backend\SiteController@getVenue')->name('admin.venue');
            Route::post('/store-venue', 'Backend\SiteController@storeVenue')->name('admin.venue.store');
            Route::get('/edit-venue/{venue_id}', 'Backend\SiteController@editVenue')->name('admin.venue.edit');
            Route::post('/delete-venue', 'Backend\SiteController@deleteVenue')->name('admin.venue.delete');

            // User stage
            Route::get('/user-stage', 'Backend\SiteController@getUserStage')->name('admin.user_stage');
            Route::post('/store-user-stage', 'Backend\SiteController@storeUserStage')->name('admin.user_stage.store');
            Route::get('/edit-user-stage/{user_stage_id}', 'Backend\SiteController@editUserStage')->name('admin.user_stage.edit');
            Route::post('/delete-user-stage', 'Backend\SiteController@deleteUserStage')->name('admin.user_stage.delete');

            // Media
            Route::get('/media', 'Backend\SiteController@getMedia')->name('admin.media');
            Route::get('/add-media', 'Backend\SiteController@addMedia')->name('admin.media.add');
            Route::get('/edit-media/{media_id}', 'Backend\SiteController@editMedia')->name('admin.media.edit');
            Route::post('/store-media', 'Backend\SiteController@storeMedia')->name('admin.media.store');
            Route::post('/delete-media', 'Backend\SiteController@deleteMedia')->name('admin.media.delete');
            /* Site end */

            // Campaign
            // Prediction
            Route::get('/prediction', 'Backend\CampaignController@prediction')->name('admin.prediction');
            Route::get('/prediction-ajax', 'Backend\CampaignController@predictionAjax')->name('admin.prediction.ajax');
            Route::get('/add-prediction', 'Backend\CampaignController@addPrediction')->name('admin.prediction.add');
            Route::get('/edit-prediction/{id}', 'Backend\CampaignController@editPrediction')->name('admin.prediction.edit');
            Route::get('/prediction-result', 'Backend\CampaignController@predictionResult')->name('admin.prediction.result');
            Route::post('/store-prediction', 'Backend\CampaignController@storePrediction')->name('admin.prediction.store');
            Route::post('/delete-prediction', 'Backend\CampaignController@deletePrediction')->name('admin.prediction.delete');
            Route::get('/review-prediction/{id_prediction}/{content}', 'Backend\CampaignController@reviewPrediction')->name('admin.prediction.review');
            // Prediction result
            Route::get('/prediction-result', 'Backend\CampaignController@predictionResult')->name('admin.prediction.result');
            Route::get('/add-prediction-result/{id_pre}', 'Backend\CampaignController@addPredictionResult')->name('admin.prediction_result.add');
            Route::get('/edit-prediction-result/{id_pre_result}', 'Backend\CampaignController@editPredictionResult')->name('admin.prediction_result.edit');
            Route::post('/store-prediction-result', 'Backend\CampaignController@storePredictionResult')->name('admin.prediction_result.store');
            // Prediction type
            Route::get('/prediction-type', 'Backend\CampaignController@predictionType')->name('admin.prediction.type');
            Route::get('/add-prediction-type', 'Backend\CampaignController@addPredictionType')->name('admin.prediction_type.add');
            Route::get('/edit-prediction-type/{id_pre_type}', 'Backend\CampaignController@editPredictionType')->name('admin.prediction_type.edit');
            Route::post('/store-prediction-type', 'Backend\CampaignController@storePredictionType')->name('admin.prediction_type.store');
            Route::post('/delete-prediction-type', 'Backend\CampaignController@deletePredictionType')->name('admin.prediction_type.delete');

            // Mail
            // Mail template
            Route::get('/mail-template', 'Backend\MailController@mailTemplate')->name('admin.mail_template');
            Route::get('/add-mail-template', 'Backend\MailController@addMailTemplate')->name('admin.mail_template.add');
            Route::get('/edit-mail-template/{id_mail_template}', 'Backend\MailController@editMailTemplate')->name('admin.mail_template.edit');
            Route::post('/store-mail-template', 'Backend\MailController@storeMailTemplate')->name('admin.mail_template.store');
            Route::post('/delete-mail-template', 'Backend\MailController@deleteMailTemplate')->name('admin.mail_template.delete');
            Route::get('/ajax-get-mail-template', 'Backend\MailController@ajaxGetMailTemplate')->name('admin.mail_template.ajax_get');
            // Mail bulk
            Route::get('/mail-bulk', 'Backend\MailController@mailBulk')->name('admin.mail_bulk');
            Route::get('/ajax-mail-bulk', 'Backend\MailController@mailBulkAjax')->name('admin.mail_bulk.ajax');
            Route::get('/add-mail-bulk', 'Backend\MailController@addMailBulk')->name('admin.mail_bulk.add');
            Route::post('/add-mail-bulk', 'Backend\MailController@addMailBulk')->name('admin.mail_bulk.add');
            Route::post('/apply-mail-bulk', 'Backend\MailController@applyMailBulk')->name('admin.mail_bulk.apply');
            Route::get('/edit-mail-bulk/{id_mail_bulk}', 'Backend\MailController@editMailBulk')->name('admin.mail_bulk.edit');
            Route::post('/store-mail-bulk', 'Backend\MailController@storeMailBulk')->name('admin.mail_bulk.store');
            Route::post('/stop-mail-bulk', 'Backend\MailController@stopMailBulk')->name('admin.mail_schedule.stop');
            Route::get('/ajax-condition-mail-bulk', 'Backend\MailController@ajaxConditionMailBulk')->name('admin.mail_bulk.ajax_condition');
            Route::get('/ajax-content-mail-bulk', 'Backend\MailController@ajaxContentMailBulk')->name('admin.mail_bulk.ajax_content');
            // Mail schedule
            Route::get('/mail-schedule', 'Backend\MailController@mailSchedule')->name('admin.mail_schedule');
            Route::get('/add-mail-schedule', 'Backend\MailController@addMailSchedule')->name('admin.mail_schedule.add');
            Route::post('/apply-mail-schedule', 'Backend\MailController@applyMailSchedule')->name('admin.mail_schedule.apply');
            Route::get('/edit-mail-schedule/{id_mail_schedule}', 'Backend\MailController@editMailSchedule')->name('admin.mail_schedule.edit');
            Route::post('/deleted-mail-schedule', 'Backend\MailController@deleteMailSchedule')->name('admin.mail_schedule.delete');
            Route::post('/store-mail-schedule', 'Backend\MailController@storeMailSchedule')->name('admin.mail_schedule.store');

            Route::get('/ajax-condition-mail-schedule', 'Backend\MailController@ajaxConditionMailSchedule')->name('admin.mail_schedule.ajax_condition');
            Route::get('/ajax-content-mail-schedule', 'Backend\MailController@ajaxContentMailSchedule')->name('admin.mail_schedule.ajax_content');
            // Mail contact
            Route::get('/mail-contact', 'Backend\MailController@mailContact')->name('admin.mail_contact');
            Route::get('/list-mail-contact', 'Backend\MailController@listMailContact')->name('admin.list.mail.contact');
            Route::get('/list-mail-contact-ajax', 'Backend\MailController@listMailContactAjax')->name('admin.list.mail.contact.ajax');
            Route::post('/send-mail-contact', 'Backend\MailController@sendMailContact')->name('admin.mail_contact.send');
            Route::post('/send-list-mail-contact', 'Backend\MailController@sendListMailContact')->name('admin.mail_contact.sendlist');
            Route::get('/admin-read-mail-contact', 'Backend\MailController@adminReadMailContact')->name('admin.mail_contact.admin_read.ajax');
            Route::post('/delete-mail-contact', 'Backend\MailController@mailContactDelete')->name('admin.mail_contact.delete');
            Route::get('/ajax-more-mail-user', 'Backend\MailController@moreMailUser')->name('admin.more-mail-user.ajax_get');
            

            Route::get('/admin-read-mail-contact', 'Backend\MailController@adminReadMailContact')->name('admin.mail_contact.admin_read');
            Route::post('/admin-deleted-mail-contact', 'Backend\MailController@adminDeletedMailContact')->name('admin.mail_contact.admin_deleted');

            Route::post('/admin-read-all-mail-contact', 'Backend\MailController@adminReadAllMailContact')->name('admin.mail_contact.admin_read_all');
            Route::post('/admin-deleted-all-mail-contact', 'Backend\MailController@adminDeletedAllMailContact')->name('admin.mail_contact.admin_deleted_all');
            // Mail block
            Route::get('/mail-ban', 'Backend\MailBanController@mailBan')->name('admin.mail_ban');
            Route::get('/edit-mail-ban/{id_mail_ban}', 'Backend\MailBanController@editMailBan')->name('admin.mail_ban.edit');
            Route::post('/store-mail-ban', 'Backend\MailBanController@storeMailBan')->name('admin.mail_ban.store');
            Route::post('/delete-mail-ban', 'Backend\MailBanController@deleteMailBan')->name('admin.mail_ban.delete');
            Route::post('/mail-contact-to-mail-ban', 'Backend\MailBanController@mailContactToMailBan')->name('admin.mail_contact.mail_ban');

            // Summary
            // Summary user stage
            Route::get('/summary-user-stage', 'Backend\SummaryController@summaryUserStage')->name('admin.summary.user_stage');
            //summary payment
            Route::get('/summary-payment', 'Backend\SummaryController@summaryPayment')->name('admin.summary.payment');
            Route::get('/ajax-get-summary-payment', 'Backend\SummaryController@ajaxSummaryPayment')->name('admin.summary.payment.ajax');

            // Deposit
            Route::get('/summary-deposit', 'Backend\SummaryController@summaryDeposit')->name('admin.summary.deposit');
            Route::get('/ajax-get-summary-deposit', 'Backend\SummaryController@ajaxSummaryDeposit')->name('admin.summary.deposit.ajax');

            // Summary gift
            Route::get('/summary-gift', 'Backend\SummaryController@summaryGift')->name('admin.summary.gift');
            Route::get('/ajax-get-summary-gift', 'Backend\SummaryController@ajaxSummaryGift')->name('admin.summary.gift.ajax');

            // Summary access
            Route::get('/summary-access', 'Backend\SummaryController@summaryAccess')->name('admin.summary.access');
            Route::get('/ajax-get-summary-access', 'Backend\SummaryController@ajaxSummaryAccess')->name('admin.summary.access.ajax');

            // Summary mail
            Route::get('/summary-mail-bulk', 'Backend\SummaryMailController@summaryMailBulk')->name('admin.summary.mail_bulk');
            Route::get('/ajax-summary-mail-bulk', 'Backend\SummaryMailController@ajaxSummaryMailBulk')->name('admin.summary.mail_bulk.ajax');
            Route::get('/summary-mail-schedule', 'Backend\SummaryMailController@summaryMailSchedule')->name('admin.summary.mail_schedule');

            // Summary media
            Route::get('/summary-media', 'Backend\SummaryController@summaryMedia')->name('admin.summary.media');
            Route::get('/ajax-summary-media', 'Backend\SummaryController@summaryMediaAjax')->name('admin.summary.media.ajax');
            Route::get('/ajax-summary-media-sort', 'Backend\SummaryController@summaryMediaSortAjax')->name('admin.summary.media_sort.ajax');

            // Summary media code
            Route::get('/summary-media-code/{media_code}', 'Backend\SummaryController@summaryMediaCode')->name('admin.summary.media_code');
            Route::get('/ajax-summary-media-code', 'Backend\SummaryController@summaryMediaCodeAjax')->name('admin.summary.media_code.ajax');

            // Summary entrance
            Route::get('/summary-entrance', 'Backend\SummaryController@summaryEntrance')->name('admin.summary.entrance');
            Route::get('/ajax-summary-entrance', 'Backend\SummaryController@summaryEntranceAjax')->name('admin.summary.entrance.ajax');

            // Summary entrance code
            Route::get('/summary-entrance-detail/{entrance_id}', 'Backend\SummaryController@summaryEntranceDetail')->name('admin.summary.entrance_detail');
            Route::get('/ajax-summary-entrance-detail', 'Backend\SummaryController@summaryEntranceDetailAjax')->name('admin.summary.entrance_detail.ajax');

            // Summary billing
            Route::get('/summary-billing', 'Backend\SummaryController@summaryBilling')->name('admin.summary.billing');

            // Summary access rank media
            Route::get('/summary-media-rank', 'Backend\SummaryController@summaryMediaRank')->name('admin.summary.media_rank');

            // Management
            Route::get('/admin', 'Backend\ManagementController@admin')->name('admin.admin');
            Route::get('/add-admin', 'Backend\ManagementController@addAdmin')->name('admin.admin.add');
            Route::get('/edit-admin/{id_admin}', 'Backend\ManagementController@editAdmin')->name('admin.admin.edit');
            Route::post('/store-admin', 'Backend\ManagementController@storeAdmin')->name('admin.admin.store');
            Route::post('/store-admin-hidden-mail', 'Backend\ManagementController@updateHiddenMailAdmin')->name('admin.update.hidden.mail');
            Route::post('/update-admin/{id_admin}', 'Backend\ManagementController@updateAdmin')->name('admin.admin.update');
            Route::post('/delete-admin', 'Backend\ManagementController@deleteAdmin')->name('admin.admin.delete');
            // Partner
            Route::get('/partner', 'Backend\ManagementController@partner')->name('admin.partner');
            Route::get('/add-partner', 'Backend\ManagementController@addPartner')->name('admin.partner.add');
            Route::get('/edit-partner/{id_partner}', 'Backend\ManagementController@editPartner')->name('admin.partner.edit');
            Route::post('/store-partner', 'Backend\ManagementController@storePartner')->name('admin.partner.store');
            Route::post('/update-partner/{id_partner}', 'Backend\ManagementController@updatePartner')->name('admin.partner.update');
            Route::post('/delete-partner', 'Backend\ManagementController@deletePartner')->name('admin.partner.delete');

            // System
            Route::get('/mail-replace', 'Backend\SystemController@mailReplace')->name('admin.mail_replace');
            Route::get('/add-mail-replace', 'Backend\SystemController@addMailReplace')->name('admin.mail_replace.add');
            Route::get('/edit-mail-replace/{id_mail_replace}', 'Backend\SystemController@editMailReplace')->name('admin.mail_replace.edit');
            Route::post('/store-mail-replace', 'Backend\SystemController@storeMailReplace')->name('admin.mail_replace.store');
            Route::post('/update-mail-replace/{id_mail_replace}', 'Backend\SystemController@updateMailReplace')->name('admin.mail_replace.update');
            Route::post('/delete-mail-replace', 'Backend\SystemController@deleteMailReplace')->name('admin.mail_replace.delete');

            // Order

            // Test mail
            Route::get('/test-mail', 'Backend\MailController@testMail')->name('admin.mail_test');
            // Test crond
            Route::get('/test-cron', 'Cron\CronMailController@testCron')->name('admin.cron_test');
            Route::get('/test-cron-reg', 'Cron\CronMailRegisterController@testCronMailRegister')->name('admin.cron_reg_test');
            Route::get('/test-cron-contact', 'Cron\CronMailContactController@testCronMailContact')->name('admin.cron_contact');

            // edit frontend
            Route::get('/edit-frontend', 'Backend\ChangeImageController@editFrontend')->name('admin.edit_frontend');
            Route::post('/update-image', 'Backend\ChangeImageController@updateImage')->name('admin.image.update');
        });
    });

/** Backend end **/

/** Partner start **/
    Route::group(['prefix' => 'partner'], function () {
        Route::get('/summary-access', 'Partner\PartnerControllers@summaryAccessPartner')->name('partner.summary.access');
        Route::get('/ajax-summary-access', 'Partner\PartnerControllers@summaryAccessPartnerAjax')->name('partner.summary.access.ajax');
        Route::get('/ajax-summary-access-sort', 'Partner\PartnerControllers@summaryAccessPartnerSortAjax')->name('partner.summary.access_sort.ajax');

        Route::get('/summary-access-detail/{media_code}', 'Partner\PartnerControllers@summaryAccessDetailPartner')->name('partner.summary.access_detail');
        Route::get('/ajax-summary-access-detail', 'Partner\PartnerControllers@summaryAccessDetailPartnerAjax')->name('partner.summary.access_detail.ajax');
    });
/** Partner end **/

});