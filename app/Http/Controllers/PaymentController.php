<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user', 'course')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $users = User::all();
        $courses = Course::all();
        return view('payments.create', compact('users', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'status' => 'required',
        ]);

        Payment::create($request->all());
        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('user', 'course');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $users = User::all();
        $courses = Course::all();
        return view('payments.edit', compact('payment', 'users', 'courses'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'status' => 'required',
        ]);

        $payment->update($request->all());
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
