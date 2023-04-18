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

    Route::GET('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::GET('logout', '\App\Http\Controllers\Auth\LoginController@logout');

    Route::GET('getCurrencies', 'CurrencyController@getCurrencies');

    //Users Operations
    Route::GET('users', 'UserController@index')->name('user.index');
    Route::GET('users/create', 'UserController@create')->name('user.create');
    Route::POST('users/store', 'UserController@store')->name('user.store');
    Route::GET('users/edit/{id}', 'UserController@edit')->name('user.edit');
    Route::POST('users/update/{id}', 'UserController@update')->name('user.update');
    Route::GET('users/delete/{id}', 'UserController@destroy')->name('user.destroy');

    //Roles and Permissions
    Route::GET('roles', 'RolePermissionController@index')->name('role.index');
    Route::GET('roles/create', 'RolePermissionController@create')->name('role.create');
    Route::POST('roles/store', 'RolePermissionController@store')->name('role.store');
    Route::GET('roles/edit/{id}', 'RolePermissionController@edit')->name('role.edit');
    Route::POST('roles/update/{id}', 'RolePermissionController@update')->name('role.update');
    Route::GET('roles/delete/{id}', 'RolePermissionController@destroy')->name('role.destroy');
    Route::GET('roles/clone/{id}', 'RolePermissionController@cloneRole')->name('role.clone');
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
    Route::POST('definitions/bookings/change/{id}', 'BookingFormController@changeStatus')->name('bookingform.change');
    Route::GET('definitions/bookings/edit/{id}', 'BookingFormController@edit')->name('bookingform.edit');
    Route::GET('definitions/bookings/status/{id}', 'BookingFormController@status')->name('bookingform.status');
    Route::POST('definitions/bookings/update/{id}', 'BookingFormController@update')->name('bookingform.update');
    Route::GET('definitions/bookings/destroy/{id}', 'BookingFormController@destroy')->name('bookingform.destroy');
    //Booking Forms end

    //Contact Forms
    Route::GET('contactforms', 'ContactFormController@index')->name('contactform.index');
    Route::POST('contactforms/change/{id}', 'ContactFormController@changeStatus');
    Route::GET('contactforms/edit/{id}', 'ContactFormController@edit')->name('contactform.edit');
    Route::GET('contactforms/status/{id}', 'ContactFormController@status')->name('contactform.status');
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
    Route::GET('reservations', 'ReservationController@index')->name('reservation.index');
    Route::GET('reservations/calendar', 'ReservationController@reservationCalendar')->name('reservation.calendar');
    Route::GET('reservations/create', 'ReservationController@create')->name('reservation.create');
    Route::POST('reservations/store', 'ReservationController@store')->name('reservation.store');
    Route::GET('reservations/edit/{id}', 'ReservationController@edit')->name('reservation.edit');
    Route::GET('reservations/download/{id}', 'ReservationController@download')->name('reservation.download');
    Route::POST('reservations/update/{id}', 'ReservationController@update')->name('reservation.update');

    //payment type
    Route::POST('reservations/addPaymentTypetoReservation', 'ReservationController@addPaymentTypetoReservation');
    Route::GET('reservations/paymenttype/edit/{id}', 'ReservationController@editPaymentType')->name('reservation.paymenttype.edit');
    Route::POST('reservations/paymenttype/update/{id}', 'ReservationController@updatePaymentType')->name('reservation.paymenttype.update');
    Route::GET('reservations/paymenttype/destroy/{id}', 'ReservationController@destroyPaymentType')->name('reservation.paymenttype.destroy');

    Route::GET('reservationbydate', 'ReservationController@allReservationByDate');
    Route::GET('reservations/destroy/{id}', 'ReservationController@destroy')->name('reservation.destroy');
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

    //Route Types
    Route::GET('definitions/routetypes', 'RouteTypeController@index')->name('routetype.index');
    Route::POST('definitions/routetypes/store', 'RouteTypeController@store')->name('routetype.store');
    Route::GET('definitions/routetypes/edit/{id}', 'RouteTypeController@edit')->name('routetype.edit');
    Route::POST('definitions/routetypes/update/{id}', 'RouteTypeController@update')->name('routetype.update');
    Route::GET('definitions/routetypes/destroy/{id}', 'RouteTypeController@destroy')->name('routetype.destroy');
    //Route Types end

    //Whatsapp
    Route::GET('whatsappforms', 'WhatsappController@index')->name('whatsapp.index');
    Route::POST('whatsappforms/store', 'WhatsappController@store')->name('whatsapp.store');
    Route::GET('whatsappforms/edit/{id}', 'WhatsappController@edit')->name('whatsapp.edit');
    Route::POST('whatsappforms/update/{id}', 'WhatsappController@update')->name('whatsapp.update');
    Route::GET('whatsappforms/destroy/{id}', 'WhatsappController@destroy')->name('whatsapp.destroy');
    //Whatsapp end

    //Discounts
    Route::GET('definitions/discounts', 'DiscountController@index')->name('discount.index');
    Route::POST('definitions/discounts/store', 'DiscountController@store')->name('discount.store');
    Route::GET('definitions/discounts/edit/{id}', 'DiscountController@edit')->name('discount.edit');
    Route::POST('definitions/discounts/update/{id}', 'DiscountController@update')->name('discount.update');
    Route::GET('definitions/discounts/destroy/{id}', 'DiscountController@destroy')->name('discount.destroy');
    //api
    Route::GET('getDiscount/{id}', 'DiscountController@getDiscount');
    //Discounts end

    //Report
    Route::GET('reports', 'ReportController@index')->name('report.index');
    Route::GET('reports/reservations', 'ReportController@reservationReport')->name('report.reservation');
    Route::GET('reports/payments', 'ReportController@paymentReport')->name('report.payment');
    Route::GET('reports/comissions', 'ReportController@comissionReport')->name('report.comission');
    Route::GET('reports/vehicleReport', 'ReportController@vehicleReport')->name('report.vehicle');
    Route::GET('reports/sourceReport', 'ReportController@sourceReport')->name('report.source');
    //Report end

});
