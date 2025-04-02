<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Payment;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalCourses = Course::count();
        $totalRevenue = Payment::sum('amount');
        $lastMonthRevenue = Payment::whereMonth('payment_date', now()->subMonth()->month)->sum('amount');
        $revenueGrowth = $lastMonthRevenue ? round(($totalRevenue - $lastMonthRevenue) / $lastMonthRevenue * 100, 2) : 0;
        $lastMonthUsers = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $userGrowth = $lastMonthUsers ? round(($totalUsers - $lastMonthUsers) / $lastMonthUsers * 100, 2) : 0;
        $newCoursesThisWeek = Course::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthlyPayments = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereYear('payment_date', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
        $monthlyUsers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
        $allMonths = range(1, 12);
        foreach ($allMonths as $month) {
            if (!isset($monthlyPayments[$month])) {
                $monthlyPayments[$month] = 0;
            }
            if (!isset($monthlyUsers[$month])) {
                $monthlyUsers[$month] = 0;
            }
        }
        ksort($monthlyPayments);
        ksort($monthlyUsers);

        $recentCourses = Course::with('user', 'category')
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['user', 'course'])
            ->orderBy('payment_date', 'desc')
            ->take(5)
            ->get()
            ->map(function ($payment) {
                $payment->payment_date = \Carbon\Carbon::parse($payment->payment_date);
                return $payment;
            });
        return view('admin.index', compact('totalUsers', 'totalCourses', 'totalRevenue', 'monthlyPayments', 'monthlyUsers', 'revenueGrowth', 'userGrowth', 'newCoursesThisWeek', 'recentCourses', 'recentPayments'));
    }
}
