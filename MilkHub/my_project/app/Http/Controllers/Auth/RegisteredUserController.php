<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
         $messages = [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'يجب أن يكون الاسم نصًا',
            'name.max' => 'الاسم طويل جدًا',

            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.string' => 'صيغة البريد غير صحيحة',
            'email.lowercase' => 'يجب كتابة البريد بأحرف صغيرة',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح',
            'email.max' => 'البريد الإلكتروني طويل جدًا',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل',

            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 8 أحرف',

            'role.required' => 'نوع المستخدم مطلوب',
            'role.in' => 'نوع المستخدم غير صالح',
        ];

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'],
        ], $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
