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
use App\Http\Controllers\UserController;

Auth::routes();
//Routes accessible to guest users
//GET HEAD
Route::get('/', [MainController::class, 'index'])->name('/');
Route::get('logout', [LoginController::class, 'logout']);
Route::get('forgot-password', [UserController::class, 'forgot_password'])->name('forgot-password');
Route::get('password/request-reset/{token}?user={login_id}', [MainController::class, 'password_reset_granted'])->name('password.request-reset');
Route::get('update-password', [UserController::class, 'update_password'])->name('update-password');
Route::get('first-time-login', [UserController::class, 'first_time_login'])->name('first-time-login');
Route::get('access-record-verification', [MainController::class, 'access_record_verification'])->name('access-record-verification');
Route::get('signin', [MainController::class, 'signin'])->name('signin');
Route::get('login', [MainController::class, 'signin'])->name('login');



//POST HEAD
Route::post('registration', [UserController::class, 'ao_registration'])->name('registration');
Route::post('send-password-reset-mail', [UserController::class, 'send_password_change_link'])->name('send-password-reset-mail');
Route::post('change-existing-password', [UserController::class, 'change_password'])->name('change-existing-password');
Route::post('update-credentials', [UserController::class, 'update_credentials'])->name('update-credentials');

//Routes only accessible to logged in users
Route::group(['middleware' => 'auth'], function () {

    //Global routes


    // Client routes
    Route::group(['middleware' => 'client_staff'], function () {

        //GET HEAD
        Route::get('client-home', [ClientController::class, 'index'])->name('client-home');
        Route::get('data-outgoing', [ClientController::class, 'going_out'])->name('data-outgoing');
        Route::get('data-incoming', [ClientController::class, 'going_in'])->name('data-incoming');
        Route::get('settlement-history', [ClientController::class, 'history'])->name('settlement-history');
        Route::get('access-stored-info', [ClientController::class, 'access_stored_info'])->name('access-stored-info');
        Route::get('view-stored-info', [ClientController::class, 'view_stored_info'])->name('view-stored-info');
        Route::get('notification-history', [ClientController::class, 'notification_history'])->name('notification-history');
        Route::get('various-settings', [ClientController::class, 'various_settings'])->name('various-settings');
        Route::get('client-faq', [ClientController::class, 'faq'])->name('client-faq');
        Route::get('access-record-verification', [ClientController::class, 'access_record_verification'])->name('access-record-verification');
        Route::get('access-past-notification', [ClientController::class, 'access_past_notification'])->name('access-past-notification');
        Route::get('access-tax-history', [ClientController::class, 'access_tax_history'])->name('access-tax-history');

        //POST HEAD
        Route::post('upload-files', [ClientController::class, 'upload_files'])->name('upload-files');
        Route::post('delete-records', [ClientController::class, 'delete_records'])->name('delete-records');
        Route::post('send-inquiry', [ClientController::class, 'send_inquiry'])->name('send-inquiry');
        Route::post('download-file', [ClientController::class, 'download_file'])->name('download');
        Route::post('admit-host-upload', [ClientController::class, 'update_host_upload'])->name('admit-host-upload');
        Route::post('send-otp', [ClientController::class, 'send_otp'])->name('send-otp');
        Route::post('one-time-access', [ClientController::class, 'one_time_access'])->name('one-time-access');

        //DataTables routes
        // Route::get('messages-data', [ClientDatatablesController::class, 'messages_data'])->name('messages-data');

    });

    //Accounting Office
    Route::group(['middleware' => 'accounting_office_staff', 'prefix' => 'accounting_office'], function () {

        //GET HEAD
        Route::get('/', [HostController::class, 'index'])->name('home');
        Route::get('clients', [HostController::class, 'customer_selection'])->name('clients');
        Route::get('outbox', [HostController::class, 'message_clients'])->name('outbox');
        Route::get('clients-information', [HostController::class, 'client_list'])->name('clients-information');
        Route::get('account', [HostController::class, 'account_management'])->name('account');
        Route::get('subscription', [HostController::class, 'plan_update'])->name('subscription');
        Route::get('accounting-profile', [HostController::class, 'accounting_profile'])->name('accounting-profile');

        //POST HEAD
        Route::post('register-new-client', [HostController::class, 'register_new_client'])->name('register-new-client');
        Route::post('send-notification', [HostController::class, 'send_notification'])->name('send-notification');
        Route::post('register-new-staff', [HostController::class, 'register_new_staff'])->name('register-new-staff');
        Route::post('download-client', [HostController::class, 'download_client'])->name('download-client');
        Route::post('update-registration-info', [HostController::class, 'update_registration_info'])->name('update-registration-info');
        Route::post('get-user', [HostController::class, 'get_user'])->name('get-user');
        Route::post('update-staff', [HostController::class, 'update_staff'])->name('update-staff');
        // End Accounting Office routes
        Route::post('download-file', [HostController::class, 'download_file'])->name('download-file');
        Route::post('send-host-inquiry', [HostController::class, 'send_inquiry'])->name('send-host-inquiry');

        //Accounting Office Individual Routes
        Route::group(['prefix' => 'access-client'], function () {
            //GET HEAD
            Route::get('dashboard', [HostController::class, 'view_client'])->name('access-dashboard');
            Route::get('contact', [HostController::class, 'contact_client'])->name('access-contact');
            Route::get('inbox', [HostController::class, 'from_client'])->name('access-inbox');
            Route::get('outbox', [HostController::class, 'to_client'])->name('access-outbox');
            Route::get('taxation-history', [HostController::class, 'financial_history_client'])->name('access-taxation-history');
            Route::get('access-financial-archive', [HostController::class, 'access_files_client'])->name('access-archive');
            Route::get('notification-history', [HostController::class, 'notification_history_client'])->name('access-notification-history');
            Route::get('create-video', [HostController::class, 'create_video_client'])->name('create-video');
            Route::get('video-creation', [HostController::class, 'video_creation'])->name('video-creation');
            Route::get('created-video-list', [HostController::class, 'view_video_list'])->name('video-list');
            Route::get('view-registration-information', [HostController::class, 'view_registration_information'])->name('view-registration-information');
            Route::get('access-data-financial-record', [HostController::class, 'access_data_financial_record'])->name('access-data-financial-record');

            //POST HEAD
            Route::post('save-settings', [HostController::class, 'save_settings'])->name('save-settings');
            Route::post('message-client', [HostController::class, 'message_client'])->name('message-client');
            Route::post('send-tax-file', [HostController::class, 'file_tax'])->name('send-tax-file');
            Route::post('get-pdf-source', [HostController::class, 'pdf_source'])->name('get-pdf-source');
            Route::post('save-video', [HostController::class, 'save_video'])->name('save-video');
            Route::post('delete-file-from', [HostController::class, 'delete_file_from'])->name('delete-file-from');
            Route::post('save-taxation-history', [HostController::class, 'save_taxation_archive'])->name('save-taxation-history');
            Route::post('save-notification-history', [HostController::class, 'save_notification_archive'])->name('save-notification-archive');
            Route::post('save-url-to-database', [HostController::class, 'save_url_to_database'])->name('save-url-to-database');
            Route::post('update-client-info', [HostController::class, 'update_client_info'])->name('update-client-info');
            Route::post('update-client-credentials', [HostController::class, 'update_client_credentials'])->name('update-client-credentials');
            Route::post('update-notification-settings', [HostController::class, 'update_notification_settings'])->name('update-notification-settings');
            Route::post('mark-as-read', [HostController::class, 'mark_as_read'])->name('mark-as-read');
            Route::post('new-client-user', [HostController::class, 'register_new_client_access'])->name('new-client-user');
            Route::post('change-contact-email', [HostController::class, 'change_contact_email'])->name('change-contact-email');
        });
    });

    //Administrator routes
    Route::group(['middleware' => 'administrator', 'prefix' => 'administrator'], function () {

        //GET HEAD
        Route::get('registration-status', [AdministratorController::class, 'registration_status'])->name('admin-registration-status');
        Route::get('registered-client-information', [AdministratorController::class, 'registered_client_information'])->name('admin-registered-client-information');
        Route::get('home', [AdministratorController::class, 'index'])->name('admin-home');
        Route::get('contact', [AdministratorController::class, 'contact'])->name('admin-contact');
        Route::get('various-settings', [AdministratorController::class, 'settings'])->name('admin-various-settings');
        Route::get('link-change', [AdministratorController::class, 'link_change'])->name('admin-link-change');
    });
});
