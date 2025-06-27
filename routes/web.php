<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\UielementsController;
use App\Http\Controllers\UtilitiesController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\AdvanceduiController;
use App\Http\Controllers\WidgetsController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\IconsController;

use App\Http\Controllers\SuperAdminLoginController;
Route::get('/superadmin/dashboard', function () {
    return view('pages.superadmindashboard');
})->name('superadmindashboard');


use App\Http\Controllers\AdminAuthController;  // we'll create this controller

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
use App\Http\Controllers\BranchController;
Route::post('/branches/store', [BranchController::class, 'store'])->name('branches.store');
Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
use App\Http\Controllers\PatientController;
Route::get('patient/register', [PatientController::class, 'showRegisterForm'])->name('patient.register.form');
Route::post('patient/register', [PatientController::class, 'register'])->name('patient.register');

Route::get('patient/login', [PatientController::class, 'showLoginForm'])->name('patient.login.form');
Route::post('patient/login', [PatientController::class, 'login'])->name('patient.login');
// web.php
Route::get('/patient/dashboard', [PatientDashboardController::class, 'showDashboard'])->name('patient.dashboard');

Route::middleware('auth:patient')->group(function () {
    Route::get('patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    Route::post('patient/logout', [PatientController::class, 'logout'])->name('patient.logout');
});

use App\Http\Controllers\PatientTestController;

// Group all patient test routes & protect with auth:patient
Route::middleware('auth:patient')->prefix('patient')->group(function () {
    Route::get('/test-step1', [PatientTestController::class, 'step1'])->name('test.step1');
    Route::post('/test-step1', [PatientTestController::class, 'storeStep1'])->name('test.step1.post');

    Route::get('/test-step2', [PatientTestController::class, 'step2'])->name('test.step2');
    Route::post('/submit-test', [PatientTestController::class, 'store'])->name('test.final.post');
    Route::post('/test/final', [PatientTestController::class, 'postFinalStep'])->name('test.final.post');
    
Route::get('/invoice/{id}', [PatientTestController::class, 'showInvoice'])->name('test.invoice');

});

    
use App\Http\Controllers\ComplaintController;
Route::get('/complaints/create', [ComplaintController::class, 'create']);
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');

Route::get('/patient-complaints/view', [ComplaintController::class, 'viewComplaints']) ->name('complaints.view');
    Route::patch('/complaints/{id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.updateStatus');
    Route::get('/complaints', [App\Http\Controllers\ComplaintController::class, 'myComplaints'])->middleware('auth');

    use App\Http\Controllers\BranchAdminController;

    // ✅ Superadmin creating branch admins
    Route::get('branch-admin/create', [BranchAdminController::class, 'create'])->name('branch-admin.create');
    Route::post('branch-admin/store', [BranchAdminController::class, 'store'])->name('branchadmin.store');
    Route::patch('/branch-admins/{id}/toggle', [BranchAdminController::class, 'toggleStatus'])->name('branchadmin.toggle');

    // ✅ Branch Admin Auth Routes
    Route::get('branch-admin/login', [BranchAdminController::class, 'showLoginForm'])->name('branchadmin.login');
    Route::post('branch-admin/login', [BranchAdminController::class, 'login'])->name('branchadmin.login.submit');
    Route::post('branch-admin/logout', [BranchAdminController::class, 'logout'])->name('branchadmin.logout');
    
   
    Route::prefix('branchadmin')
    ->name('branchadmin.')
    ->middleware(['auth:branchadmin'])
    ->group(function () {
        Route::get('tests/all', [BranchAdminController::class, 'allTests'])->name('tests.all');
    });


    Route::get('/employees', [BranchAdminController::class, 'index'])->name('branchadmin.index');
    use App\Http\Controllers\EmployeeController;
    Route::get('/employees/filter', [EmployeeController::class, 'filter'])->name('employees.filter');

    use App\Http\Controllers\InventoryController;
    Route::get('inventory-add', [InventoryController::class, 'create'])->name('inventory.create');

Route::post('inventory-add', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('inventory-items', [InventoryController::class, 'index'])->name('inventory.index');
use App\Http\Controllers\InventoryCategoryController;
Route::get('inventory-category', [InventoryCategoryController::class, 'index'])->name('inventory-category.index');
Route::post('inventory-category/store', [InventoryCategoryController::class, 'store'])->name('inventory-category.store');
Route::delete('inventory-category/{id}', [InventoryCategoryController::class, 'destroy'])->name('inventory-category.destroy');
Route::get('inventory-reports', [InventoryController::class, 'report'])->name('inventory.reports');
Route::post('inventory-reports/generate', [InventoryController::class, 'generate'])->name('inventory.reports.generate');
Route::get('inventory-stock-levels', [InventoryController::class, 'stockLevels'])->name('inventory.stock-levels');


    Route::get('/low-stock-reports', [InventoryController::class, 'lowStockReports'])->name('low.stock.reports');
    Route::patch('/low-stock-report/{id}', [InventoryController::class, 'updateLowStockReportStatus'])->name('low.stock.report.update');
    use App\Http\Controllers\NotificationController;
// In your web routes or controller before rendering a page:
    Route::get('/', function () {
        $unreadNotificationCount = \App\Models\Notification::whereNull('read_at')->count();
        $headerNotifications = \App\Models\Notification::orderBy('created_at', 'desc')->take(5)->get();
        return view('pages.superadmindashboard', compact('unreadNotificationCount', 'headerNotifications'));
    });
    
    Route::get('/header-notifications', [NotificationController::class, 'headerNotifications'])->name('header.notifications');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    use App\Http\Controllers\FinanceController;
       Route::get('/finance/revenue', [FinanceController::class, 'totalRevenue'])->name('finance.revenue');
       Route::get('finance/expenses', [FinanceController::class, 'expenses'])->name('finance.expenses');
Route::get('finance/profit-loss', [FinanceController::class, 'profitLoss'])->name('finance.profit-loss');
Route::get('finance/budget', [FinanceController::class, 'budget'])->name('finance.budget');
Route::get('finance/cash-flow', [FinanceController::class, 'cashFlow']);
use App\Http\Controllers\InvoiceController;
Route::get('finance/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

use App\Http\Controllers\PaymentController;

Route::get('finance/payments', [PaymentController::class, 'index'])->name('payments.index');

// use App\Http\Controllers\RoleController;
// Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
// Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
// Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

use App\Http\Controllers\PermissionController;

Route::get('roles.permission', [PermissionController::class, 'index'])->name('permissions.index');
Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

use App\Http\Controllers\EmployeeReportController;

Route::get('/employee-reports', [EmployeeReportController::class, 'index'])->name('employee.reports');
Route::get('/employee-reports/export', [EmployeeReportController::class, 'export'])->name('employee.reports.export');
use App\Http\Controllers\DepartmentController;

Route::resource('departments', DepartmentController::class);
use App\Http\Controllers\RoleController;

Route::resource('roles', RoleController::class);
Route::post('/roles/store-with-permission', [RoleController::class, 'storeWithPermission'])->name('roles.storeWithPermission');

use App\Http\Controllers\ManagerController;
Route::get('/managers/create', [ManagerController::class, 'create'])->name('managers.create');
Route::post('/managers/store', [ManagerController::class, 'store'])->name('managers.store');
Route::post('/managers/{id}/toggle-status', [ManagerController::class, 'toggleStatus'])->name('managers.toggleStatus');
// Show form (GET)
Route::get('/users/create', [ManagerController::class, 'create'])->name('users.create');

// Handle form submit (POST)
Route::post('/users/store', [ManagerController::class, 'store'])->name('users.store');

use App\Http\Controllers\ManagerAuthController;

Route::get('/manager/login', [ManagerAuthController::class, 'showLoginForm'])->name('manager.login');
Route::post('/manager/login', [ManagerAuthController::class, 'login'])->name('manager.login.submit');
Route::post('/manager/logout', [ManagerAuthController::class, 'logout'])->name('manager.logout');

Route::middleware('auth:manager')->group(function () {
    Route::get('/manager/manager-dashboard', [ManagerAuthController::class, 'dashboard'])->name('manager.manager-dashboard');
    Route::post('/manager/logout', [ManagerAuthController::class, 'logout'])->name('manager.logout');
});

use App\Http\Controllers\PayrollController;
Route::prefix('payroll')->controller(PayrollController::class)->group(function () {
    Route::get('/', 'index')->name('payroll.index');
    Route::get('/create', 'create')->name('payroll.create');
    Route::post('/store', 'store')->name('payroll.store');
});
use App\Http\Controllers\PerformanceReviewController;
Route::get('/performance-reviews', [PerformanceReviewController::class, 'index'])->name('performance.reviews');
Route::get('/performance-reviews/data', [PerformanceReviewController::class, 'getData'])->name('performance.reviews.data');
Route::get('/performance-reviews/{id}', [PerformanceReviewController::class, 'show'])->name('performance.reviews.show');

  use App\Http\Controllers\TestController;
Route::get('/tests/manage', [TestController::class, 'index'])->name('tests.manage');
Route::post('/tests/store', [TestController::class, 'store'])->name('tests.store');
//Route::post('/tests/update/{test}', [TestController::class, 'update'])->name('tests.update');
Route::put('tests/update/{test}', [TestController::class, 'update'])->name('tests.update');

Route::delete('/tests/delete/{test}', [TestController::class, 'destroy'])->name('tests.destroy');


use App\Http\Controllers\ChatController;

// ✅ Patient chat
Route::middleware(['auth:patient'])->group(function () {
    Route::get('/chat', [ChatController::class, 'patientIndex'])->name('chat.patient.index');
    Route::post('/chat/send', [ChatController::class, 'sendFromPatient'])->name('chat.send');
});
// Manager routes
Route::middleware(['auth:manager'])->group(function () {
    Route::get('/manager/chat', [ChatController::class, 'managerIndex'])->name('chat.manager');
    Route::get('/manager/chat/{patientId}', [ChatController::class, 'showPatientMessages'])->name('chat.manager.view');
    Route::post('/manager/chat/send', [ChatController::class, 'sendFromManager'])->name('chat.send.manager');
});


    use App\Http\Controllers\PatientReportController;
    Route::get('/patient/reports', [PatientReportController::class, 'index']);
    
          use App\Http\Controllers\AppointmentController;
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        // Route::post('/appointments/cancel/{id}', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

        Route::get('/appointments/{id}/download', [AppointmentController::class, 'download'])->name('appointments.download');
        Route::get('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::get('/appointments/{id}/reschedule', [AppointmentController::class, 'reschedule'])->name('appointments.reschedule');
        Route::get('/appointments/physical-tests', [AppointmentController::class, 'physicalTests'])->name('appointments.physical');

        // routes/web.php
use App\Http\Controllers\LowStockReportController;
    Route::get('/low-stock/report', [LowStockReportController::class, 'create'])->name('low.stock.report.create');
    Route::post('/low-stock/report', [LowStockReportController::class, 'store'])->name('low.stock.report.store');
    Route::get('/branchadmin/low-stock-reports', [LowStockReportController::class, 'index'])->name('branchadmin.low.stock.reports');

// routes/web.php
use App\Http\Controllers\BranchInventoryReportController;
    Route::get('/branchadmin/create_report', [BranchInventoryReportController::class, 'create'])->name('branchadmin.inventory.report.create');
    Route::post('/branchadmin/store_report', [BranchInventoryReportController::class, 'store'])->name('branchadmin.inventory.report.store');
    Route::get('/branchadmin/items-by-category', [BranchInventoryReportController::class, 'getItemsByCategory'])
        ->name('branchadmin.inventory.items.by.category');
    
    use App\Http\Controllers\BranchInventoryController;
    Route::get('/inventory/view_items', [BranchInventoryController::class, 'viewItems'])->name('branchadmin.inventory.view_items');
    use App\Http\Controllers\BranchStaffController;
    Route::get('/branchadmin/staff', [BranchStaffController::class, 'index'])->name('branchadmin.staff.index');
    Route::post('/branch/staff/{id}/toggle-status', [BranchStaffController::class, 'toggleStatus'])->name('branch.staff.toggleStatus');


    use App\Http\Controllers\ExpenseController;

    Route::prefix('branchadmin')
        ->name('branchadmin.') // ✅ Prefix only once
        ->middleware(['auth:branchadmin'])
        ->group(function () {
            Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
            Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
            Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        });
    
        use App\Http\Controllers\IncomeController;

        Route::prefix('branchadmin')->middleware('auth:branchadmin')->group(function () {
            Route::get('/dashboard', function () {
                return view('branchadmin.dashboard');
            })->name('branchadmin.dashboard');
        
            Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
            Route::get('/income/create', [IncomeController::class, 'create'])->name('income.create');
            Route::post('/income/store', [IncomeController::class, 'store'])->name('income.store');
            Route::get('/income/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
            Route::post('/income/{id}/update', [IncomeController::class, 'update'])->name('income.update');
            Route::delete('/income/{id}/delete', [IncomeController::class, 'destroy'])->name('income.destroy');
        });
        use App\Http\Controllers\BranchAdminTestController;

// Route::prefix('branchadmin')->middleware(['auth:branchadmin'])->group(function () {
    Route::get('/tests/pending', [BranchAdminTestController::class, 'pending'])->name('branchadmin.tests.pending');
    Route::get('/tests/completed', [BranchAdminTestController::class, 'completed'])->name('branchadmin.tests.completed');
    Route::get('/tests/all', [BranchAdminTestController::class, 'all'])->name('branchadmin.tests.all');
// });

// use App\Http\Controllers\BranchAdminAppointmentController;

// Route::prefix('branchadmin')->middleware(['auth:branchadmin'])->name('branchadmin.')->group(function () {
    
//     // 👇 List all appointments for the branch
//     Route::get('/appointments', [BranchAdminAppointmentController::class, 'index'])->name('appointments.index');
    
//     // 👇 View a single appointment
//     Route::get('/appointments/{appointment}', [BranchAdminAppointmentController::class, 'show'])->name('appointments.show');
    
//     // 👇 Reschedule appointment
//     Route::put('/appointments/{appointment}/reschedule', [BranchAdminAppointmentController::class, 'reschedule'])->name('appointments.reschedule');

//     // 👇 Cancel appointment
//     Route::put('/appointments/{appointment}/cancel', [BranchAdminAppointmentController::class, 'cancel'])->name('appointments.cancel');

//     // 👇 Assign a rider
//     Route::put('/appointments/{appointment}/assign-rider', [BranchAdminAppointmentController::class, 'assignRider'])->name('appointments.assignRider');
// });

    use App\Http\Controllers\BranchAdminReportController;
    Route::prefix('branchadmin')
    ->middleware(['auth:branchadmin'])
    ->group(function () {
        Route::get('/report/profit-loss', [BranchAdminReportController::class, 'profitLoss'])->name('branchadmin.report.profitLoss');
        Route::get('/report/income', [BranchAdminReportController::class, 'incomereport'])->name('branchadmin.report.income');
        Route::get('/report/expenses', [BranchAdminReportController::class, 'expenses'])->name('branchadmin.report.expenses');
        Route::get('/report/appointments', [BranchAdminReportController::class, 'appointments'])->name('branchadmin.report.appointments');
    });
    Route::get('/branch/profit-loss/export-pdf', [ProfitLossController::class, 'exportPdf'])->name('branch.profitloss.exportPdf');
    Route::get('/branch/profit-loss/export-excel', [ProfitLossController::class, 'exportExcel'])->name('branch.profitloss.exportExcel');
    
    use App\Http\Controllers\RiderController;

    Route::prefix('branchadmin')->middleware(['auth:branchadmin'])->group(function () {
   
        // Show all riders
        Route::get('/riders', [RiderController::class, 'index'])->name('branchadmin.riders.index');
    
        // Show form to create rider
        Route::get('/riders/create', [RiderController::class, 'create'])->name('branchadmin.riders.create');
    
        // Store rider
        Route::post('/riders', [RiderController::class, 'store'])->name('branchadmin.riders.store');
     
        Route::get('/riders/{id}', [RiderController::class, 'show'])->name('branchadmin.riders.show');
        Route::get('/branchadmin/riders/{id}/report', [RiderController::class, 'report'])
        ->name('branchadmin.riders.report');
    
    });    // routes/web.php

    use App\Http\Controllers\PatientAppointmentController;
    // use App\Http\Controllers\ReportsController;
    Route::get('/patients/appointments', [PatientAppointmentController::class, 'myAppointments'])->name('patients.appointments');

    //Route::prefix('branchadmin')->middleware(['auth:branchadmin'])->group(function () {
        Route::get('/patient/track-rider/{appointment}', [\App\Http\Controllers\PatientAppointmentController::class, 'trackRider'])->name('patient.track.rider');

        // ✅ Patient Appointments (assign date + rider)
        Route::get('/appointments', [PatientAppointmentController::class, 'index'])
            ->name('branchadmin.appointments.index');
    
        Route::post('/appointments/{appointment}/assign', [PatientAppointmentController::class, 'assignRider'])
            ->name('branchadmin.appointments.assign');
    
        // ✅ Appointments Report
        Route::get('/reports/appointments', [ReportsController::class, 'appointmentsReport'])
            ->name('branchadmin.reports.appointments');
    // web.php ya branchadmin.php mein
Route::post('/appointments/{appointment}/assign', [PatientAppointmentController::class, 'assignAppointment'])
    ->name('branchadmin.appointments.assign');
  // In routes/web.php
Route::post('/branchadmin/appointments/assign/{id}', [PatientAppointmentController::class, 'assignAppointment'])
->name('branchadmin.appointments.assign');

    // });
    Route::middleware(['auth:rider'])->group(function () {
        Route::get('/rider/assigned-patients', [PatientAppointmentController::class, 'riderAppointments'])->name('rider.assigned');
    });
    Route::get('/rider/patient-tracking/{appointment}', [PatientAppointmentController::class, 'trackPatient'])->name('rider.track.patient');


    // routes/web.php
Route::middleware(['auth:patient'])->group(function () {
    Route::get('/reviews/create/{rider_id}', [App\Http\Controllers\PatientReviewController::class, 'create'])->name('patient.reviews.create');
    Route::post('/reviews/store', [App\Http\Controllers\PatientReviewController::class, 'store'])->name('patient.reviews.store');
});

use App\Http\Controllers\RiderAuthController;

Route::get('/rider/login', [RiderAuthController::class, 'showLoginForm'])->name('rider.login');
Route::post('/rider/login', [RiderAuthController::class, 'login'])->name('rider.login.submit');
Route::post('/rider/logout', [RiderAuthController::class, 'logout'])->name('rider.logout');


Route::middleware('auth:rider')->group(function () {
    Route::get('/rider/dashboard', function () {
        return view('rider.rider-dashboard');
    })->name('rider.dashboard');
});
use App\Http\Controllers\RiderReviewController;

Route::middleware(['auth:rider'])->group(function () {
    Route::get('/rider/reviews', [RiderReviewController::class, 'index'])->name('rider.reviews');
});

Route::get('/rider/sample-update', [App\Http\Controllers\RiderVisitStatusController::class, 'index'])->name('rider.sample.index');
Route::post('/rider/sample-update/{id}', [App\Http\Controllers\RiderVisitStatusController::class, 'update'])->name('rider.sample.update');

use App\Http\Controllers\RiderSampleKitController;
// For web.php
Route::middleware('auth:rider')->group(function () {
    Route::get('/rider/sample-kits', [RiderSampleKitController::class, 'index'])->name('rider.samplekits');
    Route::put('/sample-kits/{id}', [RiderSampleKitController::class, 'update'])->name('rider.samplekits.update');

});

use App\Http\Controllers\ReportController;
Route::middleware(['auth:manager'])->group(function () {
    Route::get('/manager/reports/upload', [ReportController::class, 'uploadForm'])->name('reports.upload');
    Route::post('/manager/reports/store', [ReportController::class, 'store'])->name('reports.store');
});
use App\Http\Controllers\SampleCollectionController;
Route::get('/sample-assign', [SampleCollectionController::class, 'create'])->name('sample.assign');
Route::post('/sample-assign', [SampleCollectionController::class, 'store'])->name('sample.assign.store');

use App\Http\Controllers\KitAssignmentController;
    Route::get('/kits/assign', [KitAssignmentController::class, 'create'])->name('kits.assign');
    Route::post('/kits/assign', [KitAssignmentController::class, 'store'])->name('kits.store');
// Show assigned kits to riders
Route::get('/kits/assigned', [KitAssignmentController::class, 'viewAssignedKits'])->name('kits.assigned');

use App\Http\Controllers\PhysicalTestAppointmentController;

    Route::get('/manager/physical-tests', [PhysicalTestAppointmentController::class, 'index'])->name('physical-tests.index');
    Route::post('/manager/assign-appointment', [PhysicalTestAppointmentController::class, 'store'])->name('physical-tests.assign');
 // Show manager's assigned physical tests
Route::get('/manager/assigned-physical-tests', [PhysicalTestAppointmentController::class, 'assignedAppointments'])
->name('manager.physical.assigned');

// Update visit status
Route::post('/manager/update-visit-status', [PhysicalTestAppointmentController::class, 'updateVisitStatus'])
->name('manager.update.visit');
use App\Http\Controllers\BranchAppointmentController;

Route::middleware('auth:branchadmin')->group(function () {
    Route::get('/branch/online-appointments', [BranchAppointmentController::class, 'showOnlineRequests'])->name('branch.online.requests');
    Route::post('/branch/assign-appointment', [BranchAppointmentController::class, 'assignAppointment'])->name('branch.assign.appointment');
});


use App\Http\Controllers\AppointmentRescheduleController;

Route::get('/appointments/reschedule', [AppointmentRescheduleController::class, 'index'])->name('appointments.reschedule.view');
Route::post('/appointments/reschedule/{id}', [AppointmentRescheduleController::class, 'update'])->name('appointments.reschedule.update');
use App\Http\Controllers\AppointmentCancelController;

Route::get('/appointments/schedule', [AppointmentCancelController::class, 'index'])->name('appointments.cancel.view');
Route::post('/appointments/cancel/{id}', [AppointmentCancelController::class, 'cancel'])->name('appointments.cancel');

// Route::get('/sample-kits', [RiderSampleKitController::class, 'index'])->name('rider.samplekits');
// Route::put('/sample-kits/{id}', [RiderSampleKitController::class, 'update'])->name('rider.samplekits.update');

    // Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
// Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');



use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeMail;

Route::get('/test-mail', function () {
    Mail::to('demo@inbox.mailtrap.io')->send(
        new UserWelcomeMail('Test User', 'test@example.com', '123456', 'manager')
    );

    return '✅ Test mail sent!';
});

















    Route::get('/patient/payments', function () {
        return response()->make('
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <title>Payments - Coming Soon</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        background-color: #f8f9fa; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        height: 100vh; 
                        margin: 0;
                        color: #333;
                        text-align: center;
                    }
                    .container {
                        background: white;
                        padding: 40px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    }
                    h1 {
                        font-size: 48px;
                        margin-bottom: 10px;
                    }
                    h3 {
                        color: #6c757d;
                        margin-bottom: 20px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>💳 Payments</h1>
                    <h3>Coming Soon!</h3>
                    <p>We are working hard to bring you this feature. Stay tuned!</p>
                </div>
            </body>
            </html>
        ', 200);
    });
    