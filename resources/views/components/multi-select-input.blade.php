@props(['id', 'name', 'label', 'options' => [], 'selected' => [], 'required' => false])

<div class="w-full">
    <label class="block text-sm font-medium leading-6 text-gray-900 mb-2">
        {{ $label }}
    </label>

    {{-- Tombol Pilih Semua --}}
    <div class="flex items-center gap-2 mb-2">
        <button type="button" id="{{ $id }}-select-all"
            class="px-1 py-0.5 text-xs font-medium bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
            Pilih Semua
        </button>

        <button type="button" id="{{ $id }}-clear-all"
            class="px-1 py-0.5 text-xs font-medium bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
            Bersihkan
        </button>
    </div>

    <div>
        <select id="{{ $id }}" name="{{ $name }}[]" multiple
            @if ($required) required @endif
            class="choices-multiple block w-full rounded-md border-0 p-1.5 text-gray-900 shadow-sm ring-1 ring-inset 
                   ring-gray-300 text-sm leading-6">
            @foreach ($options as $option)
                <option value="{{ $option->id }}" @if (in_array($option->id, old($name, $selected))) selected @endif>
                    {{ $option->nama }}
                </option>
            @endforeach
        </select>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const selectElement = document.getElementById('{{ $id }}');
            const choices = new Choices(selectElement, {
                removeItemButton: true,
                placeholderValue: "Pilih item",
                searchPlaceholderValue: "Cari...",
                searchResultLimit: 100,
                shouldSort: false,
                searchFields: ['label'],
                fuseOptions: {
                    threshold: 0.3,
                },
                classNames: {
                    containerOuter: 'choices',
                    containerInner: 'choices__inner',
                    input: 'choices__input',
                    inputCloned: 'choices__input--cloned',
                    list: 'choices__list',
                    listItems: 'choices__list--multiple',
                    listSingle: 'choices__list--single',
                    listDropdown: 'choices__list--dropdown',
                    item: 'choices__item',
                    itemSelectable: 'choices__item--selectable',
                    itemDisabled: 'choices__item--disabled',
                    itemChoice: 'choices__item--choice',
                    placeholder: 'choices__placeholder',
                    group: 'choices__group',
                    groupHeading: 'choices__heading',
                    button: 'choices__button',
                    activeState: 'is-active',
                    focusState: 'is-focused',
                    openState: 'is-open',
                    disabledState: 'is-disabled',
                    highlightedState: 'is-highlighted',
                    selectedState: 'is-selected',
                    flippedState: 'is-flipped',
                    loadingState: 'is-loading',
                    noResults: 'has-no-results',
                    noChoices: 'has-no-choices'
                },
                callbackOnCreateTemplates: function(template) {
                    return {
                        choice: (classNames, data) => {
                            // Sembunyikan item yang sudah dipilih dari dropdown
                            if (data.selected) {
                                return template(`
                                    <div class="${classNames.item} ${classNames.itemChoice}" 
                                         data-choice 
                                         data-id="${data.id}" 
                                         data-value="${data.value}" 
                                         data-select-text="${this.config.itemSelectText}" 
                                         style="display: none;">
                                    </div>
                                `);
                            }
                            return template(`
                                <div class="${classNames.item} ${classNames.itemChoice} ${
                                    data.disabled ? classNames.itemDisabled : classNames.itemSelectable
                                }" 
                                     data-choice ${
                                    data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable'
                                } 
                                     data-id="${data.id}" 
                                     data-value="${data.value}" 
                                     ${data.groupId > 0 ? 'role="treeitem"' : 'role="option"'}
                                     style="padding: 10px 16px; transition: all 0.2s ease;">
                                    <span style="font-size: 14px; color: #374151;">${data.label}</span>
                                </div>
                            `);
                        }
                    };
                }
            });

            // Custom CSS untuk styling yang lebih baik
            const style = document.createElement('style');
            style.textContent = `
                .choices__list--dropdown .choices__item--selectable:hover {
                    background-color: #f3f4f6 !important;
                }
                
                .choices__list--dropdown .choices__item--selectable.is-highlighted {
                    background-color: #dbeafe !important;
                }
                
                .choices__list--dropdown {
                    border: 1px solid #d1d5db !important;
                    border-radius: 0.5rem !important;
                    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
                    max-height: 300px !important;
                }
                
                .choices__input--cloned {
                    padding: 8px 12px !important;
                    font-size: 14px !important;
                }
                
                .choices__list--multiple .choices__item {
                    background-color: #3b82f6 !important;
                    border: none !important;
                    border-radius: 0.375rem !important;
                    padding: 4px 10px !important;
                    font-size: 13px !important;
                }
                
                .choices__button {
                    border-left: 1px solid rgba(255, 255, 255, 0.3) !important;
                    padding: 0 8px !important;
                    opacity: 0.8;
                }
                
                .choices__button:hover {
                    opacity: 1;
                }
            `;
            document.head.appendChild(style);

            // Event: Pilih Semua
            document.getElementById('{{ $id }}-select-all').addEventListener('click', function() {
                // Ambil semua values dari options
                const allValues = [
                    @foreach ($options as $option)
                        '{{ $option->id }}',
                    @endforeach
                ];

                // Set nilai ke select element menggunakan Choices API
                choices.setChoiceByValue(allValues);
            });

            // Event: Bersihkan Semua
            document.getElementById('{{ $id }}-clear-all').addEventListener('click', function() {
                choices.removeActiveItems();
            });

        });
    </script>
@endpush
