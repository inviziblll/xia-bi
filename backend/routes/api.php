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

// edit - отдает view на редактирование, а show - отдает view на просмотр без редактирования
//GET	/photos	index	photos.index
//GET	/photos/create	create	photos.create
//POST	/photos	store	photos.store // создаем запись
//GET	/photos/{photo}	show	photos.show
//GET	/photos/{photo}/edit	edit	photos.edit
//PUT/PATCH	/photos/{photo}	update	photos.update
//DELETE	/photos/{photo}	destroy	photos.destroy

// --- SEARCH
Route::post('/search/{id}',function (Request $request,$name ) {

    $model = '\App\Http\Controllers\\'.$name.'Controller';
    if (class_exists($model)){
        $result = new $model();
        return $result->search($request);
    }else{
        return 'Сообщение об ошибке';
    }

});


// --- TEST
Route::post('testpost', 'TestController@store');
Route::post('testpost2', 'TestController@store2');
Route::get('userslist', 'TestController@userslist');
Route::get('useritem/{id}', 'TestController@usersitem');

Route::get('shopslist', 'TestController@shopslist');
Route::get('shopsitem/{id}', 'TestController@shopsitem');
Route::post('search', 'TestController@search');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::group(['middleware' => ['auth:api']], function () {
//    Route::get('/test', function (Request $request) {
//        return response()->json(['name' => 'test']);
//    });
//});


//Route::group(['prefix' => 'api'], function() {
//    Route::get('/test', function (Request $request) {
//        return response()->json(['name' => 'test']);
//    });
//});

Route::get('/test', function () {
    return response()->json([
        'success'=> true,
        'test_response' => 'test'
    ]);
});


// --- MAIN
Route::resources(['divisions' => 'DivisionController']);
Route::resources(['users' => 'UserController']);
Route::resources(['companies' => 'CompanyController']);
Route::resources(['shifts' => 'ShiftController']);
Route::resources(['products' => 'ProductController']);
Route::resources(['roles' => 'RoleController']);
Route::resources(['shops' => 'ShopController']);
Route::resources(['cities' => 'CityController']);
Route::resources(['regions' => 'RegionController']);
Route::resources(['shoptypes' => 'ShopTypeController']);
Route::resources(['shopshifts' => 'ShopShiftController']);
Route::resources(['staffplans' => 'StaffPlanController']);
Route::resources(['producttypes' => 'ProductTypeController']);
Route::resources(['productgroups' => 'ProductGroupController']);
Route::resources(['productbrands' => 'ProductBrandController']);
Route::resources(['measuretypes' => 'MeasureTypeController']);
Route::resources(['productgroupplans' => 'ProductGroupPlanController']);
Route::resources(['productgroupplantypes' => 'ProductGroupPlanTypeController']);
Route::resources(['coeffs' => 'CoeffController']);
Route::resources(['coefftypes' => 'CoeffTypeController']);
Route::resources(['visitlogs' => 'VisitLogController']);
//Route::resources(['productremains' => 'ProductRemainController']);
Route::resources(['operations' => 'OperationController']);
Route::resources(['warehouses' => 'WarehouseController']);
Route::resources(['warehousetypes' => 'WarehouseTypeController']);
Route::resources(['checkdetails'=>'CheckDetailController']);
Route::resources(['checkheaders'=>'CheckHeaderController']);
Route::resources(['checkoperations'=>'CheckOperationController']);
Route::resources(['cashdesks'=>'CashDeskController']);
Route::resources(['checktypes'=>'CheckTypeController']);
Route::resources(['productreceiptiondetails'=>'ProductReceiptionDetailController']);
Route::resources(['productreceiptionheaders'=>'ProductReceiptionHeaderController']);
Route::resources(['productshipmentdetails'=>'ProductShipmentDetailController']);
Route::resources(['productshipmentheaders'=>'ProductShipmentHeaderController']);
Route::resources(['productremains' => 'ProductRemainController']);
Route::resources(['filetypes' => 'FileTypeController']);
// Route::resources(['filelogs' => 'FileLogController']);
Route::resources(['filelogs' => 'FileLogController']);

Route::resources(['reports' => 'ReportListController']);
Route::resources(['clients' => 'ClientController']);
Route::resources(['cards' => 'CardController']);
Route::resources(['discounts' => 'DiscountController']);
Route::resources(['shopgrades' => 'ShopGradesController']);
Route::resources(['reportshares' => 'ReportShareController']);
Route::resources(['shopcashcollections' => 'ShopCashCollectionController']);
Route::resources(['shopcashcollectionsdetails' => 'ShopCashCollectionsFactDetailController']);
Route::resources(['checkbonus' => 'CheckBonusController']);

//Route::resources(['productgroupplans' => 'ProductGroupPlanController']);
//Route::resources(['productgroupplantypes' => 'ProductGroupPlanTypeController']);
//Route::resources(['coeffs' => 'CoeffController']);
//Route::resources(['coefftypes' => 'CoeffTypeController']);
//Route::resources(['visitlogs' => 'VisitLogController']);


// Route::resources(['coeffs' => 'CoeffController']);
// Route::resources(['productgroups' => 'ProductGroupController']);
//Route::resources('productgroups', function(){
//    return 'productgroups';
//    return 'productgroups';
//});

// Route::get('productgroups', function () {
//    return 'productgroups!';
// });

// Route::post('searchremains', 'ProductRemainController@search');


Route::get('parser', 'ParserController@index');
Route::get('basepath', 'ParserController@basepath');
Route::post('upload', 'FileLogController@upload');
Route::get('directory', 'FileLogController@directory');
Route::get('filereader', 'FileLogController@file_reader');
Route::get('visitlogsearch', 'VisitLogController@search');
Route::get('remainssearch', 'ProductRemainController@search');

Route::post('shopshiftsup', 'ShopShiftController@upload');
Route::post('pgpup', 'ProductGroupPlanController@upload');

Route::post('testupload', 'UploadTestController@index');
Route::get('testreader', 'UploadTestController@reader');
Route::get('testemail', 'UploadTestController@emailreader');
Route::get('getstaffplans', 'StaffPlanController@getStaffPlans');
Route::get('getShopShifts', 'ShopShiftController@getShopShifts');


Route::get('/checkdetailheader/{id_check_header}', 'CheckDetailController@checkdetail_by_checkheader');
Route::post('/adddiscounttocheckheader/{id_check_header}', 'CheckHeaderController@checkheader_add_discount');




Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::get('me', 'AuthController@me');
Route::post('tokenCheck', 'AuthController@tokenCheck');


Route::get('reportmonth', 'ReportListController@getDivisionMonthReport');
Route::get('reportmonthpie', 'ReportListController@getDivisionPieMonthReport');