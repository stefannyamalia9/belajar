@extends('master.master')
@section('homeActive','active')

@section('konten')
<div class="row mt-4">
    <div class="col-sm-12">
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endif

        @if (session()->has('pesan'))
            {!! session('pesan') !!}
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ url('/simpan') }}" method="POST" id="my-form">
                @csrf
                <h5 class="card-title">
                    Form Order
                    <input type="submit" value="Save" class="btn btn-sm btn-success float-right">
                </h5>

                <section class="mt-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Nama Customer</label>
                                <input type="text" name="customer" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Transaksi</label>
                                <input type="text" name="tanggal_transaksi" class="form-control tanggal" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group card" style="background: #E0F2F1">
                                <div class="card-body">
                                    <label for="">Grand Total</label>
                                    <h2>
                                        Rp <span id="grandTotal">0</span>
                                        <input type="hidden" id="grandTotalVal" name="grandtotal" value="0">
                                    </h2>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="card-title">Items
                                <button class="btn btn-xs btn-primary float-right" onclick="tambahItem(event)">tambah item</button>
                            </h5>
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
                                    <tr id="{{ time() }}">
                                        <td><input type="text" name="kode[]" class="form-control form-control-sm"></td>
                                        <td><input type="text" name="nama[]" class="form-control form-control-sm"></td>
                                        <td class="text-center"><input type="text" name="qty[]" class="form-control form-control-sm" onkeyup="updateTotal('{{ time() }}')"></td>
                                        <td><input type="text" name="harga[]" class="form-control form-control-sm" onkeyup="updateTotal('{{ time() }}')"></td>
                                        <td class="text-right">
                                            <h5 class="total">Rp 0</h5>
                                            <input type="hidden" class="totalVal" name="total[]" value="0">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('my-script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator->selector('#my-form') !!}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr('.tanggal',{
            dateFormat: 'Y-m-d',
            monthSelectorType: 'static',
        });

        function tambahItem(e){
            e.preventDefault();
            const id = Date.now();
            const itemBox = $('#items-box');
            const isiBox = `<tr id="${id}">
                                <td><input type="text" name="kode[]" class="form-control form-control-sm" required="required"></td>
                                <td><input type="text" name="nama[]" class="form-control form-control-sm" required="required"></td>
                                <td class="text-center"><input type="text" name="qty[]" class="form-control form-control-sm" onkeyup="updateTotal('${id}')" required="required"></td>
                                <td><input type="text" name="harga[]" class="form-control form-control-sm" onkeyup="updateTotal('${id}')" required="required"></td>
                                <td class="text-right">
                                    <h5 class="total" total="0">Rp 0</h5>
                                    <input type="hidden" class="totalVal" name="total[]" value="0">
                                    <button class="btn btn-xs btn-link" onclick="hapusItem('${id}', event)">hapus item</button>
                                </td>
                            </tr>`;
             $(itemBox).append(isiBox);
        }

        function hapusItem(id,e){
            e.preventDefault();
            $('#'+id).remove();
            hitungGrandTotal();
        }

        function updateTotal(id){
            const qty = $('#'+id).find('input[name="qty[]"]').val();
            const harga = $('#'+id).find('input[name="harga[]"]').val();
            const totalBox = $('#'+id).find('.total');
            const totalVal = $('#'+id).find('.totalVal');

            const total = qty * harga;
            $(totalBox).text('Rp '+formatRupiah(total));
            $(totalVal).val(total);

            hitungGrandTotal();
        }

        function hitungGrandTotal(){
            let grandTotal = 0;
            $('.totalVal').each(function(i, val){
                let totalVal = $(val).val();
                grandTotal += Number(totalVal);
            })

            $('#grandTotal').text(formatRupiah(grandTotal));
            $('#grandTotalVal').val(grandTotal);
        }

        function formatRupiah(bilangan){
			var	number_string = bilangan.toString(),
                sisa 	= number_string.length % 3,
                rupiah 	= number_string.substr(0, sisa),
                ribuan 	= number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            // Cetak hasil
            return rupiah;
		}
    </script>
@endsection

