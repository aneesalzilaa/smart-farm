@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
<h2>إضافة بيع جديد</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('milksales.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="sale_type">نوع البيع:</label>
        <select name="sale_type" id="sale_type" class="form-control" required onchange="toggleCustomerSelect()">
            <option value="">اختر...</option>
            <option value="اهالي" {{ old('sale_type') == 'اهالي' ? 'selected' : '' }}>أهالي</option>
            <option value="معامل" {{ old('sale_type') == 'معامل' ? 'selected' : '' }}>معامل</option>
        </select>
    </div>

    <div class="mb-3" id="customer_div" style="display:none;">
        <label for="customer_id">اختيار العميل (المعامل):</label>
        <select name="customer_id" id="customer_id" class="form-control">
            <option value="">اختر...</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="price">السعر (يتم اختيار السعر المناسب من الأسعار):</label>
        <select name="price" id="price" class="form-control" required>
            <option value="">اختر السعر</option>
            @foreach($pricings as $pricing)
                <option value="{{ $pricing->price }}" {{ old('price') == $pricing->price ? 'selected' : '' }}>
                    {{ $pricing->name }} - {{ number_format($pricing->price) }} ليرة
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="quantity">الكمية (كيلو):</label>
        <input type="number" step="0.01" min="0.01" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">حفظ</button>
</form>

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

    document.addEventListener('DOMContentLoaded', toggleCustomerSelect);
</script>

</div>
@endsection
