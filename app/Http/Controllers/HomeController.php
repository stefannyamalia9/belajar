<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JSvalidation;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $validator = JSvalidation::make([
            'customer'  => 'required',
            'tanggal_transaksi' => 'required',
            'kode'      => 'required',
            'nama'      => 'required',
            'qty'       => 'required|numeric',
            'harga'     => 'required|numeric'
        ]);

        return view('home')->with([
            'validator' => $validator
        ]);
    }

    public function simpan(Request $r)
    {
        $validator = Validator::make($r->all(), [
            'customer'  => 'required',
            'tanggal_transaksi'   => 'required',
            'kode.*'      => 'required',
            'nama.*'      => 'required',
            'qty.*'       => 'required|numeric',
            'harga.*'     => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect('/')->withErrors($validator);
        }

        DB::beginTransaction();

        try {
            $customer = strip_tags($r->customer);
            $tanggal  = strip_tags($r->tanggal_transaksi);
            $grandtotal = $r->grandtotal;

            $order = Order::create([
                'user_id'   => Auth::user()->id,
                'customer' => $customer,
                'transaksi' => $tanggal,
                'grand_total' => $grandtotal,
            ]);

            foreach ($r->kode as $key => $val) {
                $kode = $r->kode;
                $barang = $r->nama;
                $qty = $r->qty;
                $harga = $r->harga;
                $total = $r->total;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'kode_barang' => $kode[$key],
                    'barang'    => $barang[$key],
                    'qty'   => $qty[$key],
                    'harga' => $harga[$key],
                    'total' => $total[$key],
                ]);
            }

            DB::commit();
            return redirect('/')->with(['pesan' => '<div class="alert alert-success">Data Order berhasil diinputkan</div>']);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/')->with(['pesan' => '<div class="alert alert-danger">' . $e->getMessage() . '</div>']);
        }
    }

    public function history()
    {
        $data = Order::query()
            ->withCount('detail')
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->addSelect(DB::raw('ROW_NUMBER() OVER(ORDER BY id DESC) AS nomor'))
            ->simplePaginate(15);

        return view('history', compact('data'));
    }

    public function load(Request $r)
    {
        $id = $r->id;
        $validator = Validator::make($r->all(), [
            'id' => 'required',
        ],[
            'id.required' => 'Data order wajib dipilih terlebih dahulu'
        ]);

        if($validator->fails()){
           return redirect('/history')->withErrors($validator);
        }

        $data = Order::query()
                    ->with('detail')
                    ->where('id', $id)
                    ->first();

        return view('detail', compact('data'));
    }
}
