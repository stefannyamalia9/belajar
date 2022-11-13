@extends('master.master')
@section('homeActive','active')

@section('konten')
<div class="row mt-4">
    <div class="col-sm-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    Form Order
                </h5>

                <section class="mt-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Nama Customer</label>
                                <input type="text" name="customer" class="form-control" disabled value="{{ $data->customer }}">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Transaksi</label>
                                <input type="text" name="tanggal_transaksi" class="form-control" disabled value="{{ $data->transaksi }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group card" style="background: #E0F2F1">
                                <div class="card-body">
                                    <label for="">Grand Total</label>
                                    <h2>
                                        Rp <span id="grandTotal">{{ number_format($data->grand_total,0,',','.') }}</span>
                                    </h2>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-title">Items</h5>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-sm table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="100">KODE BARANG</th>
                                        <th width="200">NAMA BARANG</th>
                                        <th width="70" class="text-center">QTY</th>
                                        <th width="80">HARGA</th>
                                        <th width="50" class="text-right">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody id="items-box">
                                    @foreach ($data->detail as $item)
                                    <tr>
                                        <td>{{ $item->kode_barang }}</td>
                                        <td>{{ $item->barang }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td>{{ number_format($item->harga,0,',','.') }}</td>
                                        <td class="text-right">
                                            <h5 class="total">Rp {{ number_format($item->total,0,',','.') }}</h5>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('my-script')

@endsection

