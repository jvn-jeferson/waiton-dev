<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TemporaryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Tests\MailController;
use App\Http\Controllers\AdministratorController;

Auth::routes();
Route::get('/', [MainController::class, 'index'])->name('/');
Route::post('registration', [MainController::class, 'register_office'])->name('registration');
Route::get('logout', [LoginController::class, 'logout']);
Route::get('screen-recording', [HostController::class, 'screen_record'])->name('screen_recording');
Route::get('change-password/$1', [MainController::class, 'change_password'])->name('change-password');
Route::get('send-email', [PaymentController::class, 'send_email'])->name('send-email');
Route::post('payment_process', [PaymentController::class, 'payment_process'])->name('payment_process');
Route::post('update-password', [PaymentController::class, 'update_password'])->name('update-password');
Route::get('redirectuser', [MainController::class, 'redirectuser'])->name('redirectuser');
Route::get('request-reset-password', [MainController::class, 'request_reset_password'])->name('request-reset-password');
Route::post('send-password-reset-mail', [MainController::class, 'send_password_reset'])->name('send-password-reset-mail');
Route::get('password/request-reset/{token}?user={login_id}', [MainController::class, 'password_reset_granted'])->name('password.request-reset');


Route::group(['middleware' => 'auth'], function() {
    // Client routes
    Route::group(['middleware' => 'client_staff'], function() {
        Route::get('client-home', [ClientController::class, 'index'])->name('client-home');
        Route::get('data-outgoing', [ClientController::class, 'going_out'])->name('data-outgoing');
        Route::get('data-incoming', [ClientController::class, 'going_in'])->name('data-incoming');
        Route::get('settlement-history', [ClientController::class, 'history'])->name('settlement-history');
        Route::get('access-stored-info', [ClientController::class, 'access_stored_info'])->name('access-stored-info');
        Route::get('view-stored-info', [ClientController::class, 'view_stored_info'])->name('view-stored-info');
        Route::get('notification-history', [ClientController::class, 'notification_history'])->name('notification-history');
        Route::get('various-settings', [ClientController::class, 'various_settings'])->name('various-settings');
        Route::post('upload-files', [ClientController::class, 'upload_files'])->name('upload-files');
        Route::post('delete-records', [ClientController::class, 'delete_records'])->name('delete-records');
        Route::get('client-faq', [ClientController::class, 'faq'])->name('client-faq');
        Route::get('client-inquiry', [ClientController::class, 'inquiry'])->name('client-inquiry');
    });
    // End Client Routes

    Route::group(['middleware'=> 'accounting_office_staff'], function () {
        // Accounting Office routes
        Route::get('home', [HostController::class, 'index'])->name('home');
        Route::get('customer-selection', [HostController::class, 'customer_selection'])->name('customer-selection');
        Route::get('message-clients', [HostController::class, 'message_clients'])->name('message-clients');
        Route::get('client-list', [HostController::class, 'client_list'])->name('client-list');
        Route::get('account-management', [HostController::class, 'account_management'])->name('account-management');
        Route::get('plan-update', [HostController::class, 'plan_update'])->name('plan-update');
        Route::get('accounting-profile', [HostController::class, 'accounting_profile'])->name('accounting-profile');
        Route::post('register-new-client', [HostController::class, 'register_new_client'])->name('register-new-client');
        Route::post('send-notification', [HostController::class, 'send_notification'])->name('send-notification');
        Route::post('register-new-staff', [HostController::class, 'register_new_staff'])->name('register-new-staff');
        // End Accounting Office routes

        //Accounting Office Individual Routes
        Route::get('view-individual-clients/client_id={client_id}/dashboard', [HostController::class, 'view_client'])->name('individual-dashboard');
        Route::get('view-individual-clients/client_id={client_id}/contact', [HostController::class, 'contact_client'])->name('individual-contact');
        Route::get('view-individual-clients/client_id={client_id}/data-incoming', [HostController::class, 'from_client'])->name('individual-data-incoming');
        Route::get('view-individual-clients/client_id={client_id}/data-outgoing', [HostController::class, 'to_client'])->name('individual-data-outgoing');
        Route::post('view-individual-clients/client_id={client_id}/send-tax-file', [HostController::class, 'file_tax'])->name('send-tax-file');
        Route::get('view-individual-clients/client_id={client_id}/settlement-history', [HostController::class, 'financial_history_client'])->name('individual-history');
        Route::get('view-individual-clients/client_id={client_id}/access-files/{file_id}', [HostController::class, 'access_files_client'])->name('individual-history-access');
        Route::get('video-creation', [HostController::class, 'video_creation'])->name('video-creation');
        Route::post('save-video', [HostController::class, 'save_video']);
        Route::post('get-pdf-source', [HostController::class, 'pdf_source'])->name('get-pdf-source');
        //End Accounting Office Individual Routes
    });

    Route::group(['middleware' => 'administrator', 'prefix' => 'administrator'], function () {
        Route::get('registration-status', [AdministratorController::class, 'registration_status'])->name('admin-registration-status');
        Route::get('registered-client-information', [AdministratorController::class, 'registered_client_information'])->name('admin-registered-client-information');
        Route::get('home', [AdministratorController::class, 'index'])->name('admin-home');
        Route::get('contact', [AdministratorController::class, 'contact'])->name('admin-contact');
        Route::get('various-settings', [AdministratorController::class, 'settings'])->name('admin-various-settings');
        Route::get('link-change', [AdministratorController::class, 'link_change'])->name('admin-link-change');
    });
});


