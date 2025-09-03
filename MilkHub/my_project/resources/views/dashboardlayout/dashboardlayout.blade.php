<!doctype html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> لوحة التحكم </title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/seodashlogo.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link href="https://cdn.materialdesignicons.com/7.0.96/css/materialdesignicons.min.css" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />

  @stack('styles')
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <aside class="left-sidebar">
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="#" class="text-nowrap logo-img">
                        <img src="{{ asset('assets/images/logos/logo-light.svg') }}" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>

                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                            <span class="hide-menu">الرئيسية</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('reports.daily') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:home-smile-bold-duotone" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">لوحة التحكم</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
                            <span class="hide-menu">مكونات واجهة المستخدم</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('cows.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:cow" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">الأبقار</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('feeds.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:corn" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">الأعلاف</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('milkproductions.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="fa6-solid:cow" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">الإنتاج</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('milkproductions.daily') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="solar:file-text-bold-duotone" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu"> الأنتاج اليومي للحليب </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('cowfeeds.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:food-apple-outline" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">إطعام الأبقار</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('cow.statistics') }}" aria-expanded="false">
                                <span>
                                    <!-- أيقونة الإحصائيات (يمكنك تغيير الأيقونة حسب الحاجة) -->
                                    <iconify-icon icon="mdi:chart-line" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">إحصائيات البقرة</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('pricings.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:currency-usd" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">الأسعار</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('customers.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:account-multiple" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">العملاء</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('milksales.index') }}" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:sale" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">المبيعات</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span>
                                    <iconify-icon icon="mdi:truck-outline" class="fs-6"></iconify-icon>
                                </span>
                                <span class="hide-menu">الموردين</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('milk_suppliers.index') }}" class="sidebar-link">
                                        <span>
                                            <iconify-icon icon="mdi:clipboard-list-outline"
                                                class="fs-5 me-1"></iconify-icon>
                                        </span>
                                        <span class="hide-menu">قائمة الموردين</span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{ route('milk_suppliers.report') }}" class="sidebar-link">
                                        <span class="mdi mdi-file-document-outline"></span>
                                        <span class="hide-menu">بحث وتقارير الموردين</span>
                                    </a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-small-cap">
                            <iconify-icon icon="solar:menu-dots-linear"
                                class="nav-small-cap-icon fs-6"></iconify-icon>
                            <span class="hide-menu">التوثيق</span>
                        </li>

                        @auth
                            @if (auth()->user()->role === 'admin')
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{ route('register') }}" aria-expanded="false">
                                        <span>
                                            <iconify-icon icon="solar:user-plus-rounded-bold-duotone"
                                                class="fs-6"></iconify-icon>
                                        </span>
                                        <span class="hide-menu">التسجيل</span>
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="body-wrapper">
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                                <i class="ti ti-bell-ringing"></i>
                                <div class="notification bg-primary rounded-circle"></div>
                            </a>
                        </li>
                    </ul>

                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt=""
                                        width="35" height="35" class="rounded-circle">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                    aria-labelledby="drop2">
                                    <div class="message-body px-3 py-2">
                                        <!-- رسالة ترحيبية باسم المستخدم -->
                                        <p class="mb-2 fs-5 text-center">{{ Auth::user()->name }}</p>

                                        <!-- رابط تعديل الملف الشخصي -->
                                        <a href="{{ route('profile.edit') }}"
                                            class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">ملفي الشخصي</p>
                                        </a>

                                        <!-- زر تسجيل الخروج -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-outline-primary mx-3 mt-2 d-block w-75 text-start"
                                                style="font-size: 0.85rem; padding: 0.3rem 0.6rem;">
                                                تسجيل الخروج
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>



                </nav>
            </header>
            @yield('contact')

            <!-- سكريبتات -->
            <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
            <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
            <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
            <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
            <script src="{{ asset('assets/js/app.min.js') }}"></script>
            <script src="{{ asset('assets/js/dashboard.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
            <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>
