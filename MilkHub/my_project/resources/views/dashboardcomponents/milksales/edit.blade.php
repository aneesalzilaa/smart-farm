@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">

    {{-- عرض الأخطاء --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- نموذج تعديل بيع الحليب --}}
    <form action="{{ route('milksales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- نوع البيع --}}
        <div class="mb-3">
            <label for="sale_type">نوع البيع:</label>
            <select name="sale_type" id="sale_type" class="form-control" required onchange="toggleCustomerSelect()">
                <option value="">اختر...</option>
                <option value="اهالي" {{ $sale->sale_type == 'اهالي' ? 'selected' : '' }}>أهالي</option>
                <option value="معامل" {{ $sale->sale_type == 'معامل' ? 'selected' : '' }}>معامل</option>
            </select>
        </div>

        {{-- اختيار العميل (يظهر فقط إذا كان البيع لمعـامل) --}}
        <div class="mb-3" id="customer_div" style="display:none;">
            <label for="customer_id">اختيار العميل (المعامل):</label>
            <select name="customer_id" id="customer_id" class="form-control">
                <option value="">اختر...</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }} - {{ $customer->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- اختيار السعر (ثابت من جدول الأسعار) --}}
        <div class="mb-3">
            <label for="price">السعر (اختر السعر المناسب):</label>
            <select name="price" id="price" class="form-control" required>
                <option value="">اختر السعر</option>
                @foreach($pricings as $pricing)
                    <option value="{{ $pricing->price }}" {{ $sale->price == $pricing->price ? 'selected' : '' }}>
                        {{ $pricing->name }} - {{ number_format($pricing->price, 2) }} ريال
                    </option>
                @endforeach
            </select>
        </div>

        {{-- كمية البيع --}}
        <div class="mb-3">
            <label for="quantity">الكمية (لتر):</label>
            <input type="number" step="0.01" min="0" name="quantity" id="quantity" value="{{ $sale->quantity }}" class="form-control" required>
        </div>

        {{-- أزرار الحفظ والإلغاء --}}
        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('milksales.index') }}" class="btn btn-secondary">إلغاء</a>
    </form>

</div>

{{-- جافاسكريبت لإظهار وإخفاء اختيار العميل بناءً على نوع البيع --}}
<script>
    function toggleCustomerSelect() {
        const saleType = document.getElementById('sale_type').value;
        const customerDiv = document.getElementById('customer_div');
        if (saleType === 'معامل') {
            customerDiv.style.display = 'block';
        } else {
            customerDiv.style.display = 'none';
            document.getElementById('customer_id').value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleCustomerSelect();
    });
</script>

@endsection
