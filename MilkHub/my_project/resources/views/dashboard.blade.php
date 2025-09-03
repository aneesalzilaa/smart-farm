@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
  <div class="text-center p-5 shadow rounded" style="max-width: 700px; background: #e6f2ff;">
    <h1 class="mb-3" style="font-weight: 700; color: #2c3e50;">مرحباً بك في لوحة تحكم مزرعتك، {{ auth()->user()->name ?? 'المستخدم' }}!</h1>
    <p class="lead mb-4" style="color: #34495e; font-size: 1.2rem;">
      هنا يمكنك متابعة الإنتاج، المبيعات، والإطعام بكل سهولة ويسر. نتمنى لك يوماً مثمراً وناجحاً.
    </p>
    <!-- أيقونة مزرعة -->
    <i class="bi bi-tree-fill" style="font-size: 100px; color: #27ae60; margin-bottom: 20px;"></i>
    <br>
    <a href="#" class="btn btn-success btn-lg px-5" style="font-weight: 600;">
      ابدأ الآن
    </a>
  </div>
</div>
</div>
@endsection
