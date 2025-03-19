<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
        ->addColumn('action', function ($row) {
          $actionBtn = '<div class="dropdown">
                        <button type="button" class="btn btn-primary" data-bs-toggle="dropdown" aria-expanded="false">
                            Aksi
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                   data-bs-id="' . $row->id . '"
                                   data-bs-status="' . $row->status . '"
                                   class="dropdown-item">Ubah</a>
                            </li>
                            <li><a class="dropdown-item btn-delete" href="#" data-id ="' . $row->id . '" >Hapus</a</li>
                        </ul>
                    </div>
                    ';
          return $actionBtn;

        })
        ->make(true);
    }

    return view('history-order.index');
  }

  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'status' => 'required|string',
    ]);

    if ($validator->passes()) {
      $data = Order::find($id);
      $data->update($validator->getData());

      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil diubah',
      ]);
    } else {
      $response = response()->json(['error' => $validator->errors()->all()]);
    }
    return $response;
  }

  public function destroy($id)
  {
    $data = Order::find($id);
    $response = response()->json([
      'status' => 'error',
      'message' => 'Data gagal dihapus'
    ]);

    if ($data->delete()) {
      $response = response()->json([
        'status' => 'success',
        'message' => 'Data berhasil dihapus',
      ]);
    }
    return $response;
  }

}
