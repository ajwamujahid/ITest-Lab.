<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // ✅ This line is required!
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\RiderVisit;
use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomePatientMail;

class PatientController extends Controller
{
    public function showRegisterForm()
    {
        $branches = Branch::all();
        return view('patients.register', compact('branches'));
    }
     
    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:patients,email',
            'password'   => 'required|confirmed|min:6',
            'dob'        => 'required|date',
            'gender'     => 'required|in:Male,Female,Other',
            'branch_id'  => 'required|exists:branches,id',
            'phone'      => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:500',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    
        $patient = Patient::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'dob'        => $request->dob,
            'gender'     => $request->gender,
            'branch_id'  => $request->branch_id,
            'phone'      => $request->phone,
            'address'    => $request->address,
        ]);
    
        // ✅ Send welcome email using queue
        Mail::to($patient->email)->queue(new WelcomePatientMail($patient));
    
        return redirect()->route('patient.login.form')->with('success', 'Registered successfully! Please login.');
    }
    

    public function showLoginForm()
    {
        return view('patients.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('patient')->attempt($credentials)) {
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    // public function dashboard()
    // {
    //     $patient = Auth::guard('patient')->user();

    //     $visits = RiderVisit::with(['rider', 'testRequest.tests'])
    //         ->where('patient_id', auth()->id())
    //         ->latest()
    //         ->get();
    //         $reminders = DB::table('patient_reminders')
    //         ->where('patient_id', auth()->id())
    //         ->orderBy('created_at', 'desc')
    //         ->take(3)
    //         ->get();
    
    //     return view('patients.dashboard', compact('patient', 'visits', 'reminders'));
    // }
    public function dashboard()
    {
        $now = Carbon::now();
    
        // Rider Reminder
        $riderReminder = Appointment::where('patient_id', Auth::guard('patient')->id())
            ->where('rider_id', '!=', null)
            ->whereBetween('appointment_date', [
                $now->copy()->addMinutes(14),
                $now->copy()->addMinutes(16),
            ])
            ->first();
    
        // Day Before Reminder
        $dayBeforeReminder = Appointment::where('patient_id', Auth::guard('patient')->id())
            ->whereBetween('appointment_date', [
                $now->copy()->addDay()->subMinutes(1),
                $now->copy()->addDay()->addMinutes(1),
            ])
            ->first();
    
        $patient = Auth::guard('patient')->user();
    
        $visits = RiderVisit::with(['rider', 'testRequest.tests'])
            ->where('patient_id', $patient->id)
            ->latest()
            ->get();
    
        // ✅ This was missing!
        $reminders = DB::table('patient_reminders')
            ->where('patient_id', $patient->id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
            // dd([
            //     'now' => $now->toDateTimeString(),
            //     'riderReminder' => $riderReminder,
            //     'dayBeforeReminder' => $dayBeforeReminder,
            // ]);
            // dd([
            //     'now' => Carbon::now()->toDateTimeString(),
            //     'riderReminder' => $riderReminder,
            //     'dayBeforeReminder' => $dayBeforeReminder,
            // ]);
            
        return view('patients.dashboard', compact(
            'patient',
            'visits',
            'reminders',
            'riderReminder',
            'dayBeforeReminder'
        ));
    }
    
    public function showDashboard()
    {
        $now = Carbon::now();
    
        // 🔔 Rider arriving in 15 minutes
        $inFifteen = $now->copy()->addMinutes(15)->format('H:i');
        $today = $now->format('Y-m-d');
    
        $riderReminder = Appointment::where('patient_id', Auth::id())
            ->where('rider_id', '!=', null)
            ->whereDate('appointment_date', $today)
            ->whereTime('appointment_time', $inFifteen)
            ->first();
    
            $targetDate = $now->copy()->addDay()->format('Y-m-d');
            $targetTime = $now->copy()->addDay()->format('H:i');
        
            $dayBeforeReminder = Appointment::where('patient_id', Auth::id())
                ->whereDate('appointment_date', $targetDate)
                ->whereTime('appointment_time', $targetTime)
                ->first();
                dd([
                    'now' => $now->toDateTimeString(),
                    'auth_id' => Auth::id(),
                    'route_hit' => true,
                ]);
                

        return view('patients.dashboard', compact('riderReminder', 'dayBeforeReminder'));
    }
       
    
    
    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('patient.login');
    }
    
}
