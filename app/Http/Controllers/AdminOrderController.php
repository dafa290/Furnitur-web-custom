<?php

namespace App\Http\Controllers;

use App\Models\OrderHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = OrderHistory::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = OrderHistory::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function show($id)
    {
        $order = OrderHistory::with('user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = OrderHistory::findOrFail($id);
        
        // Also delete from transactions table to ensure it doesn't reappear
        Transaction::where('order_id', $order->order_id)->delete();
        
        $order->delete();

        return redirect('/admin/orders')->with('success', 'Pesanan berhasil dihapus secara permanen.');
    }
}
