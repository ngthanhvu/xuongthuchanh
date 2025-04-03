<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;


class CouponController extends Controller
{
    public function index()
    {
        $title = 'Quản lý mã giảm giá';
        $coupons = Coupon::with('creator')->paginate(10);
        return view('admin.coupon.index', compact('coupons', 'title'));
    }


    public function create()
    {
        $title = 'Tạo mã giảm giá';
        $users = User::whereIn('role', ['admin', 'owner'])->get();
        return view('admin.coupon.create', compact('users', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'required|numeric|min:0',
            'max_discount_amount' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        Coupon::create([
            'code' => $request->code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_discount_amount' => $request->max_discount_amount,
            'usage_limit' => $request->usage_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->boolean('is_active', true, false),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.coupon.index')->with('success', 'Mã giảm giá đã được tạo thành công.');
    }

    public function show(Coupon $coupon)
    {
        $title = 'Chi tiết mã giảm giá';
        $coupon->load('creator', 'payments');
        return view('admin.coupon.show', compact('coupon', 'title'));
    }

    public function edit($id)
    {
        $title = 'Sửa mã giảm giá';
        $coupon = Coupon::findOrFail($id);
        $users = User::whereIn('role', ['admin', 'owner'])->get();
        return view('admin.coupon.edit', compact('coupon', 'users', 'title'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $coupon->update([
            'code' => $request->code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_value' => $request->min_order_value,
            'max_discount_amount' => $request->max_discount_amount,
            'usage_limit' => $request->usage_limit,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => $request->has('is_active'),


        ]);

        return redirect()->route('admin.coupon.index')->with('success', 'Mã giảm giá đã được cập nhật thành công.');
    }

    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return redirect()->route('admin.coupon.index')->with('success', 'Mã giảm giá đã được xóa thành công.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
            'order_amount' => 'required|numeric|min:0' // Tổng giá trị đơn hàng
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không tồn tại.'
            ], 404);
        }

        // Kiểm tra tính hợp lệ của coupon
        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn.'
            ], 400);
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($request->order_amount < $coupon->min_order_value) {
            return response()->json([
                'success' => false,
                'message' => "Đơn hàng phải có giá trị tối thiểu {$coupon->min_order_value} để sử dụng mã này."
            ], 400);
        }

        // Tính toán số tiền giảm giá
        $discount = 0;
        if ($coupon->discount_type === 'percentage') {
            $discount = ($coupon->discount_value / 100) * $request->order_amount;
            if ($coupon->max_discount_amount && $discount > $coupon->max_discount_amount) {
                $discount = $coupon->max_discount_amount;
            }
        } else { // fixed
            $discount = $coupon->discount_value;
        }

        $final_amount = max(0, $request->order_amount - $discount);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount_amount' => $discount,
            'final_amount' => $final_amount,
            'coupon_id' => $coupon->id
        ]);
    }
}
