<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderHistory;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Manajemen Pesanan: Update status pengiriman dan pembayaran.
     */
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
        
        // Hapus juga dari tabel transaksi agar tidak muncul kembali
        Transaction::where('order_id', $order->order_id)->delete();
        
        $order->delete();

        return redirect('/admin/orders')->with('success', 'Pesanan berhasil dihapus secara permanen.');
    }
}
