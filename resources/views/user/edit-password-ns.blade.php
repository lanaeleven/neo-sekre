@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Password User" closeUrl="/user/atur-akun-ns" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/user/updatePasswordNs" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ auth()->user()->id }}">

                <x-block-input-container>
                    <div>
                        <x-text-input name="passwordSaatIni" id="passwordSaatIni" :required="true">Password Saat
                            Ini</x-text-input>
                    </div>
                    <div>
                        <x-new-password idName="passwordBaru" />
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
    <x-password-validation-script idName="passwordBaru" />
@endsection
