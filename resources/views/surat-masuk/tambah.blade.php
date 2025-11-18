@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Tambah Surat Masuk" closeUrl="/surat-masuk/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/surat-masuk/tambah" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="idPosisiDisposisi" value="1">
                <input type="hidden" name="status" value="Belum Diteruskan">

                <x-block-input-container>
                    <div>
                        <x-text-input name="nomorSurat" id="nomorSurat" value="{{ old('nomorSurat') }}"
                            :required="true">Nomor Surat</x-text-input>
                    </div>
                    <div>
                        <x-dropdown-input :label="'Sifat Surat'" labelPilihan='Pilih Sifat Surat' :name="'sifatSurat'"
                            :id="'sifatSurat'" :options="$sifatSurat" :required="true"></x-dropdown-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalSurat" id="tanggalSurat" value="{{ old('tanggalSurat') }}"
                            :required="true">Tanggal Surat</x-date-input>
                    </div>
                    <div>
                        <x-date-input name="tanggalAgenda" id="tanggalAgenda" value="{{ old('tanggalAgenda') }}"
                            :required="true">Tanggal Agenda</x-date-input>
                    </div>
                    <div>
                        <x-text-input name="pengirim" id="pengirim" value="{{ old('pengirim') }}"
                            :required="true">Pengirim</x-text-input>
                    </div>
                    <div>
                        <label for="idPengirim" class="block text-sm font-medium leading-6 text-gray-900">
                            User
                        </label>
                        <div class="mt-2">
                            <select id="idPengirim" name="idPengirim" @required(true)
                                class="block w-full rounded-md border-0 p-2 text-gray-900 shadow-sm 
                   ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset 
                   focus:ring-indigo-600 text-sm leading-6">
                                <option value="">Pilih User</option>
                                @foreach ($pengirim as $p)
                                    <option value="{{ $p->id }}" @selected(old('idPengirim') == $p->id)>
                                        {{ $p->namaJabatan }}
                                    </option>
                                @endforeach
                                <option value="lainnya" @selected(old('idPengirim') == 'lainnya')>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <x-text-area-input label="Perihal" name="perihal" id="perihal" value="{{ old('perihal') }}"
                            :required="true" />
                    </div>

                    <div>
                        <x-dropdown-input :label="'Lampiran'" labelPilihan='Keterangan Lampiran' :name="'lampiran'"
                            :id="'lampiran'" :options="$lampiran" :required="true"></x-dropdown-input>
                    </div>


                    <div class="mb-4">
                        <label for="fileSurat" class="block text-sm font-medium text-gray-700">
                            Upload Surat
                        </label>
                        <div class="mt-2">
                            <input type="file" name="fileSurat" id="fileSurat" required
                                class="p-2 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer 
                   bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 
                   @error('fileSurat') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror">

                            @error('fileSurat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-block-input-container>

                <div class="mt-6 flex items-center justify-center gap-x-6 md:hidden">
                    <x-green-submit-button>
                        Simpan
                    </x-green-submit-button>
                </div>

        </x-form-body-container>

        <div class="pt-2 items-center justify-center gap-x-6 hidden md:flex bg-slate-200">
            <x-green-submit-button>
                Simpan
            </x-green-submit-button>
        </div>

        </form>

    </x-default-page-container>

    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        new TomSelect('#idPengirim', {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
    </script>
@endsection
