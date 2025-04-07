<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register-step1');
    }

    public function storeStep1(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'string', 'unique:users'],
            'nid' => ['required', 'string', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'phone' => $request->phone,
            'nid' => $request->nid,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'name' => $request->first_name . ' ' . $request->last_name,
        ]);

        Auth::login($user);

        return redirect()->route('register.step2');
    }

    public function step2(): View
    {
        return view('auth.register-step2');
    }

    public function storeStep2(Request $request): RedirectResponse
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_address' => ['required', 'string'],
            'trade_license' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
            'tin_certificate' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
            'bin_certificate' => ['required', 'file', 'mimes:jpg,png,pdf', 'max:2048'],
            'is_owner' => ['required', 'boolean'],
        ]);

        // Store files
        $tradeLicensePath = $request->file('trade_license')->store('company-documents');
        $tinCertificatePath = $request->file('tin_certificate')->store('company-documents');
        $binCertificatePath = $request->file('bin_certificate')->store('company-documents');

        // Create company
        $company = Company::create([
            'name' => $request->company_name,
            'address' => $request->company_address,
            'trade_license_path' => $tradeLicensePath,
            'tin_certificate_path' => $tinCertificatePath,
            'bin_certificate_path' => $binCertificatePath,
        ]);

        // Update user
        $user = Auth::user();
        $user->update([
            'company_id' => $company->id,
            'is_owner' => $request->is_owner,
            'is_admin' => true,
        ]);

        // Handle additional user if not owner
        if (!$request->is_owner) {
            return redirect()->route('register.step3');
        }

        return redirect()->route('register.step4');
    }

    public function step3(): View
    {
        return view('auth.register-step3');
    }

    public function storeStep3(Request $request): RedirectResponse
    {
        $request->validate([
            'phone' => ['required', 'string', 'unique:users'],
            'nid' => ['required', 'string', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $company = Auth::user()->company;

        $user = User::create([
            'phone' => $request->phone,
            'nid' => $request->nid,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'password' => Hash::make($request->password),
            'name' => $request->first_name . ' ' . $request->last_name,
            'company_id' => $company->id,
            'is_owner' => true,
            'is_admin' => true,
        ]);

        return redirect()->route('register.step4');
    }

    public function step4(): View
    {
        return view('auth.register-step4');
    }

    public function storeStep4(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => ['required', 'in:enterprise,transporter'],
        ]);

        $company = Auth::user()->company;
        $company->update([
            'type' => $request->type,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
