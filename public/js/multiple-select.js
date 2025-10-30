$(document).ready(function() {
    $('.select2').select2();

    $('.select2-single').select2({
        placeholder: "Pilih salah satu",
        allowClear: true
    });

    $('#units').on('change', function() {
        let selectedValues = $(this).val() || [];
        const isAllSelected = selectedValues.includes('all');

        // Ambil semua value unit (kecuali 'all')
        const allUnitValues = $('#units option').map(function() {
            const val = $(this).val();
            return val !== 'all' ? val : null;
        }).get();

        if (isAllSelected) {
            // Pilih semua unit, kecuali opsi 'all'
            $('#units').val(allUnitValues).trigger('change.select2');
        }
    });

    $('#users').on('change', function() {
        let selectedValues = $(this).val() || [];
        const isAllSelected = selectedValues.includes('all');

        // Ambil semua value unit (kecuali 'all')
        const allUnitValues = $('#users option').map(function() {
            const val = $(this).val();
            return val !== 'all' ? val : null;
        }).get();

        if (isAllSelected) {
            // Pilih semua unit, kecuali opsi 'all'
            $('#users').val(allUnitValues).trigger('change.select2');
        }
    });
});