@props(['idName' => 'password'])
<div class="col-span-full">
    <label for="{{ $idName }}" class="block text-sm font-medium leading-6 text-gray-900">
        Password
    </label>

    <div class="mt-2">
        <input name="{{ $idName }}" type="password" id="{{ $idName }}" required
            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}"
            title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"
            class="block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm 
                   ring-1 ring-inset ring-gray-300 
                   placeholder:text-gray-400 
                   focus:ring-2 focus:ring-inset focus:ring-indigo-600
                   sm:text-sm sm:leading-6">
    </div>

    <div class="flex items-center mt-3">
        <input id="passwordToggle" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
            onclick="toggleShowPassword()">
        <label for="passwordToggle" class="ml-2 text-gray-700 text-sm">
            Show Password
        </label>
    </div>

    <div id="message" class="text-sm mt-2 text-gray-700">
        (
        <span id="letter" class="text-red-600">Mengandung huruf kecil,</span>
        <span id="capital" class="text-red-600">Mengandung huruf kapital,</span>
        <span id="number" class="text-red-600">Mengandung angka,</span>
        <span id="symbol" class="text-red-600">Mengandung simbol,</span>
        <span id="length" class="text-red-600">Minimal 8 karakter</span>
        )
    </div>
</div>
