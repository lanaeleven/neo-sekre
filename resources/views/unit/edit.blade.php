@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Unit" closeUrl="/unit/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/unit/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $unit->id }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="namaUnit" id="namaUnit" value="{{ old('namaUnit', $unit->nama ?? '') }}"
                            :required="true">Nama Unit</x-text-input>
                    </div>

                </x-block-input-container>

        </x-form-body-container>

        <x-desktop-submit-container>
            <x-green-submit-button>
                Simpan
            </x-green-submit-button>
        </x-desktop-submit-container>

        </form>

    </x-default-page-container>
@endsection
