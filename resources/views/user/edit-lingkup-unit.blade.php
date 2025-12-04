@extends('layouts.main')

@section('container')
    <x-default-page-container>
        {{-- Navbar --}}
        <x-navbar-form title="Edit Lingkup Unit" closeUrl="/user/index" />

        {{-- Error Notif --}}
        <x-error-notif />

        <x-form-body-container>
            <form action="/user/update-lingkup-unit" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $user->id }}">

                <x-block-input-container>
                    <div>
                        <x-multi-select-input id="units" name="units" label="Pilih unit" :options="$units"
                            :selected="$user->units->pluck('id')->toArray()" />
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

    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    @stack('scripts')
@endsection
