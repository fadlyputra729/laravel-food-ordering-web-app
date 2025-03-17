<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class HistoryOrderController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin) {
            return redirect('/')->with('error', 'Unauthorized access.');
        }

        if ($request->ajax()) {
            $users = Order::with('user', 'food');
            return DataTables::of($users)
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('history-order.index');
    }
}
