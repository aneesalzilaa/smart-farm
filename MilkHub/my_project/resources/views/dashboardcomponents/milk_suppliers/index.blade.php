@extends('dashboardlayout.dashboardlayout')

@section('contact')
<div class="container-fluid">
  <div class="container-fluid" style="max-width: 900px; margin: auto; padding: 20px;">

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap;">
      <h2 style="font-weight: bold; color: #333; margin: 0;">قائمة الموردين</h2>

      <div>
        <a href="{{ route('milk_suppliers.create') }}"
           style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; margin-right: 10px; display: inline-block; margin-bottom: 8px;">
           ➕ إضافة مورد
        </a>

        <a href="{{ route('milk_supplier_deliveries.index') }}"
           style="padding: 10px 20px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px; font-weight: 600; display: inline-block; margin-bottom: 8px;">
           📋 قائمة التسليمات
        </a>
      </div>
    </div>

    @if (session('success'))
      <div style="color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        {{ session('success') }}
      </div>
    @endif

    <table style="width: 100%; border-collapse: collapse; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
      <thead>
        <tr style="background-color: #f9fafb; text-align: center; font-weight: 600; color: #555;">
          <th style="padding: 12px; border: 1px solid #ddd;">الاسم</th>
          <th style="padding: 12px; border: 1px solid #ddd;">الهاتف</th>
          <th style="padding: 12px; border: 1px solid #ddd;">الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($suppliers as $supplier)
          <tr style="text-align: center; border-bottom: 1px solid #eee; transition: background-color 0.3s;">
            <td style="padding: 10px;">{{ $supplier->name }}</td>
            <td style="padding: 10px;">{{ $supplier->phone ?? '-' }}</td>
            <td style="padding: 10px;">
              <a href="{{ route('milk_suppliers.edit', $supplier) }}"
                 style="color: #007bff; text-decoration: none; margin-right: 10px; font-weight: 600;">
                 ✏️ تعديل
              </a>
              <form action="{{ route('milk_suppliers.destroy', $supplier) }}" method="POST"
                    style="display:inline-block" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: 600;">
                  🗑️ حذف
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="3" style="padding: 20px; text-align: center; color: #777;">لا يوجد موردين حالياً</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
