@props(['idSuratMasuk', 'terusan' => []])

<x-desktop-disposisi-right-side-bottom-item>

    {{-- Aksi Radio --}}
    <div class="border rounded-md border-gray-300 shadow-sm w-1/7 text-sm p-2 grid place-items-center">
        <div class="space-y-2">
            <div class="text-center font-medium">Aksi</div>

            <label class="flex items-center space-x-1">
                <input type="radio" name="jenis_kelamin" value="teruskan" class="h-3 w-3" style="accent-color: #10b981;"
                    checked>
                <span>Teruskan</span>
            </label>

            <label class="flex items-center space-x-1">
                <input type="radio" name="jenis_kelamin" value="arsipkan" class="h-3 w-3"
                    style="accent-color: #10b981;">
                <span>Arsipkan</span>
            </label>
        </div>
    </div>

    {{-- Form --}}
    <div class="flex-1 p-1">

        {{-- FORM TERUSKAN --}}
        <div id="teruskanInputSection">
            <form action="/surat-masuk/teruskan" id="formTeruskan" method="post" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-evenly">
                    <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="idSuratMasuk" value="{{ $idSuratMasuk }}">

                    <div>
                        <x-dropdown-input-no-label labelPilihan="Pilih Tujuan Terusan" :name="'idTujuanDisposisi'"
                            :id="'idTujuanDisposisi'" :options="$terusan" :required="true" />
                    </div>

                    <div>
                        <x-file-input-no-label id="fileLampiranTeruskan" name="fileLampiran" :required="false" />
                    </div>
                </div>

                <div>
                    <x-text-area-input-no-label placeholder="Masukkan Instruksi terusan ..." name="instruksi"
                        id="instruksiTeruskan" value="{{ old('instruksi') }}" :required="true" />
                </div>
            </form>
        </div>

        {{-- FORM ARSIPKAN --}}
        <div id="arsipkanInputSection" class="hidden">
            <form action="/surat-masuk/arsipkan" id="formArsipkan" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="idSuratMasuk" value="{{ $idSuratMasuk }}">
                <input type="hidden" name="idTujuanDisposisi" value="1">
                <input type="hidden" name="idPengirimDisposisi" value="{{ auth()->user()->id }}">

                <div class="flex justify-center">
                    <x-file-input-no-label id="fileLampiranArsip" name="fileLampiran" :required="false" />
                </div>

                <div>
                    <x-text-area-input-no-label placeholder="Masukkan keterangan arsip ..." name="instruksi"
                        id="instruksiArsip" value="{{ old('instruksi') }}" :required="true" />
                </div>
            </form>
        </div>

    </div>

    {{-- BUTTON --}}
    <div class="w-1/7 text-sm p-2 grid place-items-center">

        <div id="teruskanActionSection">
            <x-green-submit-button-option-form formId="formTeruskan">
                Teruskan
            </x-green-submit-button-option-form>
        </div>

        <div id="arsipkanActionSection" class="hidden">
            <x-green-submit-button-option-form formId="formArsipkan">
                Arsipkan
            </x-green-submit-button-option-form>
        </div>

    </div>

</x-desktop-disposisi-right-side-bottom-item>


{{-- SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="jenis_kelamin"]');

        const teruskanInput = document.getElementById('teruskanInputSection');
        const arsipkanInput = document.getElementById('arsipkanInputSection');

        const teruskanAction = document.getElementById('teruskanActionSection');
        const arsipkanAction = document.getElementById('arsipkanActionSection');

        function updateUI() {
            const selected = document.querySelector('input[name="jenis_kelamin"]:checked').value;

            if (selected === 'teruskan') {
                // Show Teruskan
                teruskanInput.classList.remove('hidden');
                teruskanAction.classList.remove('hidden');

                // Hide Arsipkan
                arsipkanInput.classList.add('hidden');
                arsipkanAction.classList.add('hidden');
            } else {
                // Show Arsipkan
                arsipkanInput.classList.remove('hidden');
                arsipkanAction.classList.remove('hidden');

                // Hide Teruskan
                teruskanInput.classList.add('hidden');
                teruskanAction.classList.add('hidden');
            }
        }

        // Run once
        updateUI();

        // When radio changed
        radios.forEach(radio => {
            radio.addEventListener('change', updateUI);
        });
    });
</script>
