<?php

namespace App\Http\Controllers\Metrics;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class billingController extends Controller
{
    /**
     * get billing total and month
     */
    public function __invoke()
    {
        $ordersCompleted = Order::where('status', 'preparando')->get();


        $billingTotal = $ordersCompleted->sum('total');


        $billingTodayAgo = $ordersCompleted->filter(function ($order) {
            $startTodayAgo = Carbon::now()->subDay(1)->startOfDay();
            $startEndDayAgo = Carbon::now()->subDay(1)->endOfDay();

            if ($order->created_at >= $startTodayAgo && $order->created_at <= $startEndDayAgo) {
                return true;
            }
            return false;
        })->sum('total');


        $billingToday = $ordersCompleted->filter(function ($order) {
            $today = Carbon::now()->startOfDay();
            $endDay = Carbon::now()->endOfDay();

            if ($order->created_at >= $today && $order->created_at <= $endDay) {
                return true;
            }
            return false;
        })->sum('total');


        $billingMonthAgo = $ordersCompleted->filter(function ($order) {
            $startMonthAgo = Carbon::now()->subMonth(1)->startOfMonth();
            $endMonthAgo = Carbon::now()->subMonth(1)->endOfMonth();

            if ($order->created_at >= $startMonthAgo && $order->created_at <= $endMonthAgo) {
                return true;
            }
            return false;
        })->sum('total');



        $billingMonth = $ordersCompleted->filter(function ($order) {
            $currentMonth = Date::now()->format('m');
            $currentYear =  Date::now()->format('Y');

            if ($order->created_at->format('m') == $currentMonth && $order->created_at->format('Y') == $currentYear) {
                return true;
            }
            return false;
        })->sum('total');




        $billingTrimesterAgo = $ordersCompleted->filter(function ($order) {
            $starTrimesterAgo = Carbon::now()->subMonths(6)->startOfMonth();
            $endTrimesterAgo = Carbon::now()->subMonths(3)->endOfMonth();;

            if ($order->created_at <= $endTrimesterAgo && $order->created_at >= $starTrimesterAgo) {
                return true;
            }
            return false;
        })->sum('total');


        $billingCurrentTrimester = $ordersCompleted->filter(function ($order) {
            $startCurrentTrimester = Carbon::now()->subMonth(2)->startOfMonth();
            $endCurrentTrimester = Carbon::now()->endOfMonth();

            if ($order->created_at >= $startCurrentTrimester && $order->created_at <= $endCurrentTrimester) {
                return true;
            }
            return false;
        })->sum('total');



        //calc result current trimester
        if ($billingTrimesterAgo == 0) {

            $resultCurrentTrimester = $billingCurrentTrimester > 0 ? 100 : 0;
        } else {
            $resultCurrentTrimester = ($billingCurrentTrimester - $billingTrimesterAgo) / $billingTrimesterAgo * 100;

            $resultCurrentTrimester = round($resultCurrentTrimester);
        }


        //calc result current month
        if ($billingMonthAgo == 0) {
            $resultCurrentMonth = $billingMonth > 0 ? 100 : 0;
        } else {
            $resultCurrentMonth = ($billingMonth - $billingMonthAgo) / $billingMonthAgo * 100;

            $resultCurrentMonth = round($resultCurrentMonth);
        }
        

        //calc result current day

        if ($billingTodayAgo == 0) {
            $resultCurrentDay = $billingToday > 0 ? 100 : 0;
        } else {
            $resultCurrentDay = ($billingToday - $billingTodayAgo) / $billingTodayAgo * 100;

            $resultCurrentDay = round($resultCurrentDay);
        }

       return response()->json([
    'billingTotal' => $billingTotal,

    'billingMonth' => [
        'value' => $billingMonth,
        'variation' => $resultCurrentMonth,
    ],

    'billingToday' => [
        'value' => $billingToday,
        'variation' => $resultCurrentDay,
    ],

    'billingCurrentTrimester' => [
        'value' => $billingCurrentTrimester,
        'variation' => $resultCurrentTrimester,
    ],
]);

    }
}