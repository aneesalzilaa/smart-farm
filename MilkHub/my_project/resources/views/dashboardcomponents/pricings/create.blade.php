@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
      <h1>إضافة سعر جديد</h1>
        <form action="{{ route('pricings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">الاسم:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">السعر:</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success mt-3">حفظ</button>
        </form>
    </div>
@endsection
