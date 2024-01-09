<div class="p-6">
    


     <!-- Add Staff Modal -->
     <x-jet-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                {{ __('Update LGA Salary') }}
            </x-slot>

            <x-slot name="content">
               
                <div class="w-1/2 mt-4">
                    <x-jet-label for="email" value="{{ __('LGA') }}" />
                    <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="percent">
                            <option value="">Select Percentage</option>
                            @foreach($percents as $percent)
                                <option value="{{$percent}}">{{$percent}}%</option>
                             @endforeach       
                            
                        </select>   
                        <x-jet-input-error for="percent" class="mt-2" />

                    
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Save') }}
                </x-jet-button>

                
            </x-slot>
        </x-jet-dialog-modal>

        <!-- Upload Staff Data Modal -->
     

</div>
