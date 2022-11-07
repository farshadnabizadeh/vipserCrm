<?php

use Illuminate\Support\Facades\Route;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

Route::GET('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::GET('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE';
});

Route::group(['middleware' => ['auth']], function(){

    Route::GET('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::GET('logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::GET('getCurrencies', 'CurrencyController@getCurrencies');

    //Users Operations
    Route::GET('definitions/users', 'UserController@index')->middleware(['middleware' => 'permission:show users'])->name('user.index');
    Route::GET('definitions/users/create', 'UserController@create')->middleware(['middleware' => 'permission:create users']);
    Route::POST('definitions/users/store', 'UserController@store')->middleware(['middleware' => 'permission:create users'])->name('user.store');
    Route::GET('definitions/users/edit/{id}', 'UserController@edit')->middleware(['middleware' => 'permission:edit users'])->name('user.edit');
    Route::POST('definitions/users/update/{id}', 'UserController@update')->middleware(['middleware' => 'permission:edit users'])->name('user.update');
    Route::GET('definitions/users/delete/{id}', 'UserController@destroy')->middleware(['middleware' => 'permission:delete users'])->name('user.destroy');

    //Roles and Permissions
    Route::GET('roles', 'RolePermissionController@index')->middleware(['middleware' => 'permission:show roles'])->name('role.index');
    Route::GET('roles/create', 'RolePermissionController@create')->middleware(['middleware' => 'permission:create roles'])->name('role.create');
    Route::POST('roles/store', 'RolePermissionController@store')->middleware(['middleware' => 'permission:create roles'])->name('role.store');
    Route::GET('roles/edit/{id}', 'RolePermissionController@edit')->middleware(['middleware' => 'permission:edit roles'])->name('role.edit');
    Route::POST('roles/update/{id}', 'RolePermissionController@update')->middleware(['middleware' => 'permission:edit roles'])->name('role.update');
    Route::GET('roles/delete/{id}', 'RolePermissionController@destroy')->middleware(['middleware' => 'permission:delete roles'])->name('role.destroy');
    Route::GET('roles/clone/{id}', 'RolePermissionController@cloneRole')->middleware(['middleware' => 'permission:edit roles'])->name('role.clone');
    //Roles and Permissions end

    //Customers
    Route::GET('customers', 'CustomersController@index')->name('customer.index');
    Route::POST('customers/store', 'CustomersController@store')->name('customer.store');
    Route::POST('customers/save', 'CustomersController@save')->name('customer.save');
    Route::GET('customers/edit/{id}', 'CustomersController@edit')->name('customer.edit');
    Route::POST('customers/update/{id}', 'CustomersController@update')->name('customer.update');
    Route::GET('customers/destroy/{id}', 'CustomersController@destroy')->name('customer.destroy');
    //Customers end

    //Vehicles
    Route::GET('vehicles', 'VehicleController@index')->name('vehicle.index');
    Route::POST('vehicles/store', 'VehicleController@store')->name('vehicle.store');
    Route::POST('vehicles/save', 'VehicleController@save')->name('vehicle.save');
    Route::GET('vehicles/edit/{id}', 'VehicleController@edit')->name('vehicle.edit');
    Route::POST('vehicles/update/{id}', 'VehicleController@update')->name('vehicle.update');
    Route::GET('vehicles/destroy/{id}', 'VehicleController@destroy')->name('vehicle.destroy');
    //Vehicles end

    //Brands
    Route::GET('brands', 'BrandController@index')->name('brand.index');
    Route::POST('brands/store', 'BrandController@store')->name('brand.store');
    Route::GET('brands/edit/{id}', 'BrandController@edit')->name('brand.edit');
    Route::POST('brands/update/{id}', 'BrandController@update')->name('brand.update');
    Route::GET('brands/destroy/{id}', 'BrandController@destroy')->name('brand.destroy');
    //Brands end

    //Booking Forms
    Route::GET('definitions/bookings', 'BookingFormController@index')->name('bookingform.index');
    Route::POST('definitions/bookings/change/{id}', 'BookingFormController@changeStatus');
    Route::GET('definitions/bookings/edit/{id}', 'BookingFormController@edit')->name('bookingform.edit');
    Route::POST('definitions/bookings/update/{id}', 'BookingFormController@update')->name('bookingform.update');
    Route::GET('definitions/bookings/destroy/{id}', 'BookingFormController@destroy')->name('bookingform.destroy');
    //Booking Forms end

    //Contact Forms
    Route::GET('contactforms', 'ContactFormController@index')->name('contactform.index');
    Route::POST('contactforms/change/{id}', 'ContactFormController@changeStatus');
    Route::GET('contactforms/edit/{id}', 'ContactFormController@edit')->name('contactform.edit');
    Route::POST('contactforms/update/{id}', 'ContactFormController@update')->name('contactform.update');
    Route::GET('contactforms/destroy/{id}', 'ContactFormController@destroy')->name('contactform.destroy');
    //Contact Forms end

    //Comissions
    Route::POST('addComissiontoReservation', 'ReservationController@addComissiontoReservation');

    //Payments Types
    Route::GET('definitions/payment_types', 'PaymentTypeController@index')->name('paymenttype.index');
    Route::POST('definitions/payment_types/store', 'PaymentTypeController@store')->name('paymenttype.store');
    Route::GET('definitions/payment_types/edit/{id}', 'PaymentTypeController@edit')->name('paymenttype.edit');
    Route::POST('definitions/payment_types/update/{id}', 'PaymentTypeController@update')->name('paymenttype.update');
    Route::GET('definitions/payment_types/destroy/{id}', 'PaymentTypeController@destroy')->name('paymenttype.destroy');
    //Payment Types end

    //Reservations
    Route::GET('definitions/reservations', 'ReservationController@index');
    Route::GET('definitions/reservations/calendar', 'ReservationController@reservationCalendar');
    Route::GET('definitions/reservations/create', 'ReservationController@create');
    Route::POST('definitions/reservations/store', 'ReservationController@store');
    Route::GET('definitions/reservations/edit/{id}', 'ReservationController@edit');
    Route::GET('definitions/reservations/download/{id}', 'ReservationController@download');
    Route::POST('definitions/reservations/update/{id}', 'ReservationController@update');
    Route::POST('definitions/reservations/addCustomertoReservation', 'ReservationController@addCustomertoReservation')->middleware(['middleware' => 'permission:create reservation']);

    //payment type
    Route::POST('definitions/reservations/addPaymentTypetoReservation', 'ReservationController@addPaymentTypetoReservation')->middleware(['middleware' => 'permission:create reservation']);
    Route::GET('definitions/reservations/paymenttype/edit/{id}', 'ReservationController@editPaymentType')->middleware(['middleware' => 'permission:edit reservation']);
    Route::POST('definitions/reservations/paymenttype/update/{id}', 'ReservationController@updatePaymentType')->middleware(['middleware' => 'permission:edit reservation']);
    Route::GET('definitions/reservations/paymenttype/destroy/{id}', 'ReservationController@destroyPaymentType')->middleware(['middleware' => 'permission:delete reservation']);

    Route::GET('reservationbydate', 'ReservationController@allReservationByDate')->middleware(['middleware' => 'permission:show reservation']);
    Route::GET('definitions/reservations/destroy/{id}', 'ReservationController@destroy')->middleware(['middleware' => 'permission:delete reservation']);
    //Reservations end

    //Sources
    Route::GET('definitions/sources', 'SourceController@index')->name('source.index');
    Route::POST('definitions/sources/store', 'SourceController@store')->name('source.store');
    Route::GET('definitions/sources/edit/{id}', 'SourceController@edit')->name('source.edit');
    Route::POST('definitions/sources/update/{id}', 'SourceController@update')->name('source.update');
    Route::GET('definitions/sources/destroy/{id}', 'SourceController@destroy')->name('source.destroy');
    //Sources end

    //Form Statuses
    Route::GET('definitions/formstatuses', 'FormStatusesController@index')->name('formstatus.index');
    Route::POST('definitions/formstatuses/store', 'FormStatusesController@store')->name('formstatus.store');
    Route::GET('definitions/formstatuses/edit/{id}', 'FormStatusesController@edit')->name('formstatus.edit');
    Route::POST('definitions/formstatuses/update/{id}', 'FormStatusesController@update')->name('formstatus.update');
    Route::GET('definitions/formstatuses/destroy/{id}', 'FormStatusesController@destroy')->name('formstatus.destroy');
    //Form Statuses end

    //Services
    Route::GET('definitions/services', 'ServiceController@index')->middleware(['middleware' => 'permission:show services']);
    Route::POST('definitions/services/store', 'ServiceController@store')->middleware(['middleware' => 'permission:create services']);
    Route::GET('definitions/services/edit/{id}', 'ServiceController@edit')->middleware(['middleware' => 'permission:edit services']);
    Route::POST('definitions/services/update/{id}', 'ServiceController@update')->middleware(['middleware' => 'permission:edit services']);
    Route::GET('definitions/services/destroy/{id}', 'ServiceController@destroy')->middleware(['middleware' => 'permission:delete services']);
    //api
    Route::GET('getService/{id}', 'ServiceController@getService')->middleware(['middleware' => 'permission:show services']);
    //Services end

    //Discounts
    Route::GET('definitions/discounts', 'DiscountController@index');
    Route::POST('definitions/discounts/store', 'DiscountController@store');
    Route::GET('definitions/discounts/edit/{id}', 'DiscountController@edit');
    Route::POST('definitions/discounts/update/{id}', 'DiscountController@update');
    Route::GET('definitions/discounts/destroy/{id}', 'DiscountController@destroy');
    //api
    Route::GET('getDiscount/{id}', 'DiscountController@getDiscount')->middleware(['middleware' => 'permission:show discount']);
    //Discounts end

    //Report
    Route::GET('reports/reservations', 'ReportController@reservationReport');
    Route::GET('reports/payments', 'ReportController@paymentReport');
    Route::GET('reports/comissions', 'ReportController@comissionReport');
    Route::GET('reports/serviceReport', 'ReportController@serviceReport');
    Route::GET('reports/therapistReport', 'ReportController@therapistReport');
    Route::GET('reports/sourceReport', 'ReportController@sourceReport');
    //Report end

});
