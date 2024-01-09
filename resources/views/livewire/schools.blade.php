<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">    
        <x-jet-button wire:click="createFormShow">
            {{ __('Create') }}
        </x-jet-button>
        <x-jet-button wire:click="uploadFormShow">
            {{ __('Upload Schools Data') }}
        </x-jet-button>
    </div>


     <!-- Add Staff Modal -->
     <x-jet-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                {{ __('Add School') }}
            </x-slot>

            <x-slot name="content">
                <div class="flex justify-between">
                    <div class="w-full">
                        <x-jet-label for="email" value="{{ __('Name of School') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="school.name" required autofocus />
                        <x-jet-input-error for="school.name" class="mt-2" />
                    </div>
                    
                </div>    
                <div class="w-1/2 mt-4">
                    <x-jet-label for="email" value="{{ __('LGA') }}" />
                    <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="school.lga_id">
                            <option value="">Select LGA</option>
                            @foreach($lgas as $lga)
                                <option value="{{$lga->id}}">{{$lga->name}}</option>
                             @endforeach       
                            
                        </select>   
                        <x-jet-input-error for="school.lga_id" class="mt-2" />

                    
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                @if($schoolId)
                 <x-jet-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-button>
                @else

                <x-jet-button class="ml-3" wire:click="create" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>

                @endif
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Upload Staff Data Modal -->
     <x-jet-dialog-modal wire:model="modalUploadVisible">
            <x-slot name="title">
                {{ __('Upload Bulk School Records') }}
            </x-slot>

            <x-slot name="content">
            <div class="mb-4">
                    <div x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                        <div class="flex">
                            <label for="excelFile" class="block text-gray-700 text-sm font-bold mb-2">Select
                                File:</label>
                            <div class="px-2" wire:loading wire:target="excelFile">
                                Uploading...</div>
                            {{-- <div x-show="isUploading" class="px-2">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div> --}}
                        </div>
                        <input type="file"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            wire:model="excelFile" name="excelFile" id="{{ $iteration }}">
                        @error('excelFile') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalUploadVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="upload" wire:loading.attr="disabled">
                    {{ __('Upload Data') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

</div>
