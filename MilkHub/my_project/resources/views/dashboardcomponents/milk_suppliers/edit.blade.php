@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
<div class="container-fluid" style="max-width: 500px; margin: 40px auto; background: #fff; padding: 30px 25px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <h2 style="margin-bottom: 25px; font-weight: 700; color: #2c3e50; text-align: center;">تعديل بيانات المورد</h2>

    <form action="{{ route('milk_suppliers.update', $milkSupplier) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #34495e;">الاسم:</label>
            <input type="text" id="name" name="name" value="{{ $milkSupplier->name }}" required
                style="width: 100%; padding: 10px 12px; border: 1.5px solid #bdc3c7; border-radius: 6px; font-size: 16px; transition: border-color 0.3s ease;">
        </div>

        <div style="margin-bottom: 25px;">
            <label for="phone" style="display: block; margin-bottom: 8px; font-weight: 600; color: #34495e;">الهاتف:</label>
            <input type="text" id="phone" name="phone" value="{{ $milkSupplier->phone }}"
                style="width: 100%; padding: 10px 12px; border: 1.5px solid #bdc3c7; border-radius: 6px; font-size: 16px; transition: border-color 0.3s ease;">
        </div>

        <button type="submit"
            style="width: 100%; padding: 12px 0; background-color: #27ae60; color: white; font-weight: 700; font-size: 17px; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.3s ease;">
            💾 تحديث
        </button>
    </form>
</div>
</div>
<script>
    // إضافة تأثير عند التركيز على الحقول
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.style.borderColor = '#27ae60';
            input.style.outline = 'none';
        });
        input.addEventListener('blur', () => {
            input.style.borderColor = '#bdc3c7';
        });
    });
</script>
@endsection
