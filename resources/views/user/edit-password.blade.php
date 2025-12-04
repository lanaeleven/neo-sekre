@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Password User" closeUrl="/user/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/user/updatePassword" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">

                <x-block-input-container>
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
