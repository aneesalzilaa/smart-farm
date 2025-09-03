@extends('dashboardlayout.dashboardlayout')

@section('contact')
    <div class="container-fluid">
        <div class="container-fluid"
            style="max-width: 1000px; margin: 30px auto; padding: 20px; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 8px;">

            {{-- العنوان وزر الإضافة --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="font-weight: 700; color: #2c3e50; font-size: 28px; margin: 0;">قائمة تسليمات الموردين</h2>
                <a href="{{ route('milk_supplier_deliveries.create') }}"
                    style="padding: 12px 25px; background-color: #27ae60; color: #fff; border-radius: 6px; text-decoration: none; font-weight: 600; box-shadow: 0 3px 7px rgba(39, 174, 96, 0.5); transition: background-color 0.3s ease;">
                    ➕ إضافة تسليم
                </a>
            </div>

            {{-- رسالة النجاح --}}
            @if (session('success'))
                <div
                    style="padding: 12px 20px; background-color: #d4edda; color: #155724; border-radius: 6px; margin-bottom: 20px; border: 1px solid #c3e6cb; font-weight: 600;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- جدول التسليمات --}}
            <table
                style="width: 100%; border-collapse: collapse; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                <thead>
                    <tr
                        style="background-color: #f9fafb; border-bottom: 2px solid #e0e0e0; color: #34495e; font-weight: 700; text-align: center;">
                        <th style="padding: 14px 10px;">المورد</th>
                        <th style="padding: 14px 10px;">التاريخ</th>
                        <th style="padding: 14px 10px;">كمية الصباح (كغ)</th>
                        <th style="padding: 14px 10px;">كمية المساء (كغ)</th>
                        <th style="padding: 14px 10px;">المجموع (كغ)</th>
                        <th style="padding: 14px 10px;">سعر الكغ (ل.س)</th>
                        <th style="padding: 14px 10px;">الإجمالي (ل.س)</th>
                        <th style="padding: 14px 10px;">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $delivery)
                        <tr style="border-bottom: 1px solid #eee; text-align: center; color: #2c3e50; font-weight: 600;">
                            <td style="padding: 12px;">
                                {{ $delivery->milkSupplier ? $delivery->milkSupplier->name : 'غير محدد' }}
                            </td>
                            <td style="padding: 12px;">{{ \Carbon\Carbon::parse($delivery->date)->format('Y-m-d') }}</td>
                            <td style="padding: 12px;">{{ number_format($delivery->morning_quantity) }}</td>
                            <td style="padding: 12px;">{{ number_format($delivery->evening_quantity) }}</td>
                            <td style="padding: 12px; font-weight: 700;">
                                {{ number_format($delivery->morning_quantity + $delivery->evening_quantity,) }}
                            </td>
                            <td style="padding: 12px;">{{ number_format($delivery->price_per_liter) }}</td>
                            <td style="padding: 12px;" class="fw-bold text-success">{{ number_format($delivery->total) }}</td>
                            <td style="padding: 12px;">
                                <a href="{{ route('milk_supplier_deliveries.edit', $delivery->id) }}"
                                    style="color: #2980b9; text-decoration: none; margin-right: 15px; font-weight: 700; transition: color 0.3s;">
                                    ✏️ تعديل
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 25px; text-align: center; color: #7f8c8d; font-weight: 600;">
                                لا توجد تسليمات حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- روابط الصفحات --}}
            <div style="margin-top: 25px; display: flex; justify-content: center;">
                {{ $deliveries->links() }}
            </div>
        </div>
    </div>
@endsection
