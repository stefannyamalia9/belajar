@extends('master.master')

@section('homeActive','active')
{{-- @section('page_title', $title) --}}

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

            <div class="card">
                <div class="card-body">
                    <form action="{{ url('/load') }}" method="POST">
                        @csrf
                    <h5 class="card-title">History
                        <button type="submit" class="btn btn-sm btn-dark float-right">Load</button>
                    </h5>

                    <table class="table table-striped table-hover">
                        <thead >
                            <tr>
                                <th></th>
                                <th>customer</th>
                                <th>tanggal transaksi</th>
                                <th>items</th>
                                <th>grand total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr for="{{ $item->id }}">
                                <td><input type="radio" name="id" id="{{ $item->id }}" value="{{ $item->id }}"></td>
                                <td>{{ $item->customer }}</td>
                                <td>{{ $item->transaksi }}</td>
                                <td>{{ $item->detail_count }}</td>
                                <td>Rp {{ number_format($item->grand_total, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5">Belum ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 pagination">{{ $data->links() }}</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('my-script')
    <style>
        table tr{
            cursor: pointer;
        }
    </style>

    <script>
        $('table tr').click(function(e){
            e.preventDefault();
            $(this).find('input[type="radio"]').prop('checked',true);
        })
    </script>
@endsection

