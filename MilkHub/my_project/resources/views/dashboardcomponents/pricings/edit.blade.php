<!-- resources/views/dashboardcomponents/pricing/edit.blade.php -->
@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
        <h1>تعديل السعر</h1>
        <form action="{{ route('pricings.update', $pricing->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">الاسم:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $pricing->name }}" required>
            </div>
            <div class="form-group">
                <label for="price">السعر:</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ $pricing->price }}" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-warning mt-3">تحديث</button>
        </form>
    </div>
@endsection
