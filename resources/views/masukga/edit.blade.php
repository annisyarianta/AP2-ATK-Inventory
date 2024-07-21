@extends('layouts.master')
@section('content')

<!-- MAIN -->

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h2>Edit Barang Masuk</h2>
            </div>
            <div class="panel-body">
                <form id="aksi" action="/masukga/{{$barangmasuk->id}}/update" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="barang_id">Nama Barang</label>
                        <select name="barang_id" class="form-control" id="barang_id">
                            @foreach ($barang as $brg)
                            <option value="{{$brg->id}}" @if ($barangmasuk->barang_id == $brg->id)
                                selected
                                @endif>
                                {{$brg->namabarang}}
                            </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group{{$errors->has('tanggalmasuk') ? ' has-error ' : ''}}">
                        <label for="tanggalmasuk">Tanggal Barang Masuk</label>
                            <input name="tanggalmasuk" type="text" class="form-control" id="tanggalmasuk" value="{{$barangmasuk->tanggalmasuk}}">
                        @if ($errors->has('tanggalmasuk'))
                        <span class="help-block">{{$errors->first('tanggalmasuk')}}</span>
                        @endif
                    </div>
    
                    <div class="form-group{{$errors->has('jumlahmasuk') ? ' has-error ' : ''}}">
                        <label for="jumlahmasuk">Jumlah Barang Masuk</label>
                        <input name="jumlahmasuk" type="number" class="form-control" id="jumlahmasuk" value="{{$barangmasuk->jumlahmasuk}}">
                        @if ($errors->has('jumlahmasuk'))
                        <span class="help-block">{{$errors->first('jumlahmasuk')}}</span>
                        @endif
                    </div>
    
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- END MAIN -->

@endsection