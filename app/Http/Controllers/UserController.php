<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            session()->flash('unauthorized', 'You are not authorized to access the page ' . request()->path());
            return redirect('../home');
        }
        $user = User::findOrFail(Auth::id());

        return view('editUser', ['user' => $user]);
    }
    public function store(Request $user)
    {
        $id = Auth::id();

        $user->validate([
            'username' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'name' => 'required',
            'address' => 'required',
        ]);

        User::where('id', $id)->update([
            'name' => $user['name'],
            'username' => $user['username'],
            'address' => $user['address'],
        ]);

        Session::flash('success', 'Berhasil merubah User.');
        return redirect('/home');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        $orders = Order::where('user_id', $id)->get();
        foreach ($orders as $order) {
            foreach ($order->food as $food){
                $order->food()->detach($food->id);
            }
            $order->delete();
        }
        Session::flash('success', 'Berhasil menghapus akun.');
        return redirect('logout');
    }
}
