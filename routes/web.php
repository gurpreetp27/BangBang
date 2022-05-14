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

// Route::get('/', function () {
//     return view('welcome');
// });

  Auth::routes();

  //language route here
  Route::get('/en', 'HomeController@changeLanguage')->defaults('locale','en');
  Route::get('/ro', 'HomeController@changeLanguage')->defaults('locale','ro');
  Route::get('/de', 'HomeController@changeLanguage')->defaults('locale','de');

  //Clear Cache facade value:
  Route::get('/clear-cache', function() {
      $exitCode = Artisan::call('cache:clear');
      return '<h1>Cache facade value cleared</h1>';
  });

  //Reoptimized class loader:
  Route::get('/optimize', function() {
      $exitCode = Artisan::call('optimize');
      return '<h1>Reoptimized class loader</h1>';
  });

  //Route cache:
  Route::get('/route-cache', function() {
      $exitCode = Artisan::call('route:cache');
      return '<h1>Routes cached</h1>';
  });

  //Clear Route cache:
  Route::get('/route-clear', function() {
      $exitCode = Artisan::call('route:clear');
      return '<h1>Route cache cleared</h1>';
  });


  //Clear Config cache:
  Route::get('/config-clear', function() {
      $exitCode = Artisan::call('config:clear');
      return '<h1>Route cache cleared</h1>';
  });

  //Clear View cache:
  Route::get('/view-clear', function() {
      $exitCode = Artisan::call('view:clear');
      return '<h1>View cache cleared</h1>';
  });

  Route::get('chnage/email/{token}/{id}', 'HomeController@changeEmail');
  Route::get('cron/alertemail', 'CronjobController@sendAlertEmail');
  Route::get('cron/check/membership', 'CronjobController@checkMembership');


  Route::group(['middleware' => ['is_lang']], function($router)
  {
  Route::get('/', 'HomeController@index')->name('home');
  Route::resource('member', 'MemberController');
  Route::get('user/logout', 'MemberController@logout');

  /*Klik&pay routes*/
  Route::get('return_klik', 'MemberController@return_klik')->name('return_klik');

  /*Paypal routes*/
  Route::get('return_paypal', 'MemberController@return_paypal')->name('return_paypal');
  Route::get('cancel_paypal', 'MemberController@cancel_paypal')->name('cancel_paypal');

  /*Header Manu routes*/
  Route::get('/home', 'HomeController@index')->name('home');
  Route::get('contact', 'HomeController@contact');
  Route::post('contact', 'HomeController@contact');

  Route::get('reviews', 'HomeController@reviews');

  // Route for Review Controller //
  Route::post('reviews/savereview','ReviewController@saveReview');

  Route::get('results', 'HomeController@results');
  Route::get('bets-day', 'HomeController@betsDay')->name('bets_day');
  Route::post('results/searchbymonth', 'HomeController@searchbymonth');

  /*Signup links*/

  Route::get('terms-conditions', 'PageController@termsCondition');
  Route::get('privacy-policy', 'PageController@privacyPolicy');
  Route::get('gdpr', 'PageController@gdpr');



/* Copied from admin */
   Route::get('review/allreview','ReviewController@review');
   Route::post('review/deleteReview','ReviewController@deleteReview');
   Route::get('review/edit/{rid}','ReviewController@editReview');
   Route::post('review/edit/save','ReviewController@editReviewSave');


   /* Manage Account By User In Admin*/

   Route::get('manageaccount/user','ManageAccountController@updateInfo');
   Route::post('manageaccount/user','ManageAccountController@updateInfo');
   Route::get('manageaccount/user/delete','ManageAccountController@deleteAccount');
   Route::get('manageaccount/membership','ManageAccountController@getMembership');
   Route::get('manageaccount/renew/membership','ManageAccountController@getRenew');
   Route::post('manageaccount/renew/membership','MemberController@renew');

   Route::get('manageaccount/recurrency/membership/{type}','ManageAccountController@recurrencyMembership');

   Route::post('manageaccount/recurrency/membership','MemberController@recurrencyMembership');

   Route::get('manageaccount/view/recurrency','ManageAccountController@viewRecurrencyMembership');




});

/*
|------------------------------------------------------
|Admin Site Code
|------------------------------------------------------
*/

Route::get('admin/login', 'Admin\AdminLoginController@login');
// Route::get('admin/login', 'AdminLoginController@login');


Route::group(['middleware' => ['is_admin'], 'namespace' => 'Admin', 'prefix' => 'admin'], function($router)
{
    Route::get('home', 'AdminLoginController@home');
    Route::get('/', 'AdminLoginController@login');
    Route::get('/logout', 'AdminLoginController@logout');
   
   // AddContent Controller Routes
   Route::get('addcontent/sport','AddContentController@addSport');   
   Route::post('addcontent/sport/save','AddContentController@sportSave');   
   Route::post('addcontent/sport/remove','AddContentController@removesport');   
   Route::get('addcontent/sport/edit/{aid}','AddContentController@editsport');   
   Route::post('addcontent/sport/edit/save','AddContentController@editSavesport'); 


   Route::get('addcontent/competition','AddContentController@addCompetition');   
   Route::post('addcontent/competition/save','AddContentController@competitionSave');   
   Route::post('addcontent/competition/remove','AddContentController@removecompetition');   
   Route::get('addcontent/competition/edit/{aid}','AddContentController@editCompetition');   
   Route::post('addcontent/competition/edit/save','AddContentController@editSaveCompetition');

   Route::get('addcontent/player','AddContentController@addplayer');   
   Route::post('addcontent/player/save','AddContentController@playerSave');   
   Route::post('addcontent/player/remove','AddContentController@removeplayer');   
   Route::get('addcontent/player/edit/{aid}','AddContentController@editplayer');   
   Route::post('addcontent/player/edit/save','AddContentController@editSaveplayer'); 


   Route::get('addcontent/team','AddContentController@addteam');   
   Route::post('addcontent/team/save','AddContentController@teamSave');   
   Route::post('addcontent/team/remove','AddContentController@removeteam');   
   Route::get('addcontent/team/edit/{aid}','AddContentController@editteam');   
   Route::post('addcontent/team/edit/save','AddContentController@editSaveteam'); 



   Route::get('addcontent/tiptype','AddContentController@addtiptype');   
   Route::post('addcontent/tiptype/save','AddContentController@tiptypeSave');   
   Route::post('addcontent/tiptype/remove','AddContentController@removetiptype');   
   Route::get('addcontent/tiptype/edit/{aid}','AddContentController@edittiptype');   

   Route::post('addcontent/tiptype/edit/save','AddContentController@editSavetiptype'); 


  Route::get('addcontent/plan','AddContentController@addplan');
  Route::post('addcontent/plan/save','AddContentController@planSave'); 
  Route::post('addcontent/plan/remove','AddContentController@removeplan'); 
  Route::get('addcontent/plan/edit/{aid}','AddContentController@editplan'); 
  Route::post('addcontent/plan/edit/save','AddContentController@editSaveplan');


  Route::get('addcontent/betcategory','AddContentController@addbetcategory');
  Route::post('addcontent/betcategory/save','AddContentController@betcategorySave'); 
  Route::post('addcontent/betcategory/remove','AddContentController@betcategoryremove'); 
  Route::get('addcontent/betcategory/edit/{aid}','AddContentController@editbetcategory'); 
  Route::post('addcontent/betcategory/edit/save','AddContentController@editSavebetcategory');


  //Routes for bet Controller 

  Route::get('bets/addnewbet/singlebet','BetController@addnewbetSingel');   
  Route::get('bets/addnewbet/multiplebet','BetController@addnewbetMultiple');   
  Route::post('bets/addsinglesave','BetController@addSinglesave');   
  Route::post('bets/addmultiplesave','BetController@addmultiplesave');
  Route::get('bets/allbets','BetController@getAllBets');
  Route::post('bets/allbets/changeStatus','BetController@changeStatus');
  Route::post('bets/allbets/remove','BetController@remove');
  Route::post('bets/allbets/getdetail','BetController@Getdetail');
  Route::get('bets/allbets/edit/{betid}','BetController@editbet');
  Route::post('bets/allbets/edit/save','BetController@editbetSave');
  Route::post('bets/allbets/edit/single/save','BetController@editbetSingleSave');

  
   /*Membership*/
   Route::get('memberships/users','MembershipController@users')->name('memberships');
   Route::get('memberships/users/edit/{id}','MembershipController@edit');
   Route::post('memberships/users/edit/{id}','MembershipController@update');
   Route::get('memberships/users/ban/{id}','MembershipController@banUser');
   Route::get('memberships/users/unban/{id}','MembershipController@unbanUser');
   Route::get('memberships/users/delete/{id}','MembershipController@deleteUser');
   Route::get('memberships/users/delete/{id}','MembershipController@deleteUser');
   Route::get('memberships/users/updatedate/{id}','MembershipController@updateMembership');
   Route::post('memberships/users/updatedate/{id}','MembershipController@updateMembership');
   Route::get('memberships/users/exportxls','MembershipController@exportXls');
   Route::get('memberships/users/send/message','MembershipController@sendMessage');
   Route::post('memberships/users/send/message','MembershipController@sendMessage');
   Route::get('memberships/add/user','MembershipController@addMember');
   Route::post('memberships/add/user','MembershipController@addMember');

   /* Result Controller Route*/

   Route::get('result/allresult','ResultController@allresult');
   Route::get('result/monthlyresult','ResultController@monthlyresult');
   Route::post('result/getdetail','ResultController@getdetail');
   Route::post('result/search','ResultController@getSearch');
   Route::post('result/searchbymonth','ResultController@searchbymonth');

   /*Review Controller Routes*/
   Route::get('review/allreview','ReviewController@review');
   Route::post('review/changeStatus','ReviewController@changeStatus');
   Route::post('review/deleteReview','ReviewController@deleteReview');
   Route::get('review/edit/{rid}','ReviewController@editReview');
   Route::post('review/edit/save','ReviewController@editReviewSave');
   Route::any('review/add','ReviewController@create');


   /* Template Controller Routes */

    Route::get('template/alltemplate','TemplateController@getAll');
    Route::get('template/addnew','TemplateController@addnew');
    Route::post('template/addnew/save','TemplateController@addnewSave');
    Route::post('template/deletetemplate','TemplateController@deletetemplate');
    Route::get('template/edit/{rid}','TemplateController@editTemplate');
    Route::post('template/edit/save','TemplateController@editSave');


});