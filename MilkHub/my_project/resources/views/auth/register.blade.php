<!doctype html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>إنشاء حساب جديد</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/seodashlogo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
         data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/logo-light.svg') }}" alt="logo" />
                                </a>
                                <p class="text-center">إنشاء حساب جديد</p>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    {{-- الاسم --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label">الاسم</label>
                                        <input type="text" name="name" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name') }}" required autofocus>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- البريد الإلكتروني --}}
                                    <div class="mb-3">
                                        <label for="email" class="form-label">البريد الإلكتروني</label>
                                        <input type="email" name="email" id="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- كلمة المرور --}}
                                    <div class="mb-3 position-relative">
                                        <label for="password" class="form-label">كلمة المرور</label>
                                        <input type="password" name="password" id="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               required>
                                        <button type="button" id="togglePassword"
                                                style="position: absolute; top: 38px; right: 10px; border: none; background: transparent;">
                                            <iconify-icon icon="mdi:eye-off-outline" id="iconToggle" width="24" height="24"></iconify-icon>
                                        </button>
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- تأكيد كلمة المرور --}}
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="form-control" required>
                                    </div>

                                    {{-- نوع المستخدم --}}
                                    <div class="mb-3">
                                        <label for="role" class="form-label">نوع المستخدم</label>
                                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                            <option value="">اختر نوع المستخدم</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>أدمن</option>
                                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                                        </select>
                                        @error('role')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- زر الإنشاء --}}
                                    <button type="submit" class="btn btn-primary w-100 py-2 fs-5">إنشاء حساب</button>

                                    {{-- رابط تسجيل الدخول --}}
                                    <div class="text-center mt-3">
                                        <p class="fs-6">هل لديك حساب؟ <a href="{{ route('login') }}" class="text-primary">تسجيل الدخول</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    {{-- Show/Hide Password --}}
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        const iconToggle = document.querySelector('#iconToggle');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            iconToggle.setAttribute('icon', type === 'password' ? 'mdi:eye-off-outline' : 'mdi:eye-outline');
        });
    </script>
</body>

</html>
