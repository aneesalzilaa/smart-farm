@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
    <div class="card col-md-8 mx-auto">
        <div class="card-body">
            <h4 class="card-title mb-4">✏️ تعديل بيانات عميل</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">الاسم:</label>
                    <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">رقم الهاتف:</label>
                    <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">كلمة المرور:</label>
                    <input type="text" name="password" class="form-control" value="{{ $customer->password }}" required>
                </div>

                <button type="submit" class="btn btn-primary">✅ تحديث</button>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">↩️ رجوع</a>
            </form>
        </div>
    </div>
</div>
@endsection
