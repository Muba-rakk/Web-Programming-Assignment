@extends('layouts.app')

@section('title', 'Form Peminjaman Buku')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-book"></i> Form Peminjaman Buku Perpustakaan
                    </h4>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Whoops!</strong> Terdapat kesalahan pada input Anda:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('books.store') }}" id="bookLoanForm">
                        @csrf

                        <x-input 
                            label="Nama Lengkap" 
                            name="nama" 
                            type="text"
                            placeholder="Masukkan nama lengkap Anda"
                            :required="true"
                        />

                        <x-input 
                            label="NIM (Nomor Induk Mahasiswa)" 
                            name="nim" 
                            type="text"
                            placeholder="Contoh: 2201234567"
                            :required="true"
                        />

                        <div class="mb-3">
                            <label for="buku_dipinjam" class="form-label">
                                Buku yang Dipinjam <span class="text-danger">*</span>
                            </label>
                            <select 
                                name="buku_dipinjam" 
                                id="buku_dipinjam" 
                                class="form-select @error('buku_dipinjam') is-invalid @enderror"
                                required
                            >
                                <option value="">-- Pilih Buku --</option>
                                <option value="Pemrograman Web dengan Laravel" {{ old('buku_dipinjam') == 'Pemrograman Web dengan Laravel' ? 'selected' : '' }}>
                                    Pemrograman Web dengan Laravel
                                </option>
                                <option value="Database MySQL untuk Pemula" {{ old('buku_dipinjam') == 'Database MySQL untuk Pemula' ? 'selected' : '' }}>
                                    Database MySQL untuk Pemula
                                </option>
                                <option value="Algoritma dan Struktur Data" {{ old('buku_dipinjam') == 'Algoritma dan Struktur Data' ? 'selected' : '' }}>
                                    Algoritma dan Struktur Data
                                </option>
                                <option value="Machine Learning dengan Python" {{ old('buku_dipinjam') == 'Machine Learning dengan Python' ? 'selected' : '' }}>
                                    Machine Learning dengan Python
                                </option>
                                <option value="Jaringan Komputer" {{ old('buku_dipinjam') == 'Jaringan Komputer' ? 'selected' : '' }}>
                                    Jaringan Komputer
                                </option>
                            </select>
                            @error('buku_dipinjam')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_peminjaman" class="form-label">
                                Tanggal Peminjaman <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="tanggal_peminjaman" 
                                id="tanggal_peminjaman"
                                class="form-control datepicker @error('tanggal_peminjaman') is-invalid @enderror" 
                                placeholder="Pilih tanggal peminjaman"
                                value="{{ old('tanggal_peminjaman') }}"
                                required
                                readonly
                            >
                            @error('tanggal_peminjaman')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pengembalian" class="form-label">
                                Tanggal Pengembalian <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="tanggal_pengembalian" 
                                id="tanggal_pengembalian"
                                class="form-control datepicker @error('tanggal_pengembalian') is-invalid @enderror" 
                                placeholder="Pilih tanggal pengembalian"
                                value="{{ old('tanggal_pengembalian') }}"
                                required
                                readonly
                            >
                            @error('tanggal_pengembalian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <x-button type="reset" variant="secondary">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </x-button>
                            
                            <x-button type="submit" variant="primary">
                                <i class="bi bi-save"></i> Submit Peminjaman
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tanggal_peminjaman').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
            language: 'id'
        });

        $('#tanggal_pengembalian').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
            language: 'id'
        });

        $('#tanggal_peminjaman').on('changeDate', function(e) {
            var selectedDate = e.date;
            var minReturnDate = new Date(selectedDate);
            minReturnDate.setDate(minReturnDate.getDate() + 1);
            
            $('#tanggal_pengembalian').datepicker('setStartDate', minReturnDate);
        });
    });
</script>
@endpush
