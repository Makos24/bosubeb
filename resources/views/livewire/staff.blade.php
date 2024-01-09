<div class="p-6">
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">    
        <x-jet-button wire:click="createFormShow">
            {{ __('Add Record') }}
        </x-jet-button>
        <x-jet-button class="mx-1" wire:click="uploadFormShow">
            {{ __('Upload Staff Data') }}
        </x-jet-button>
    </div>


    @if($fail)
   <div class="alert alert-danger" role="alert">
      <strong>Errors:</strong>
      
      <ul>
         @foreach ($fail as $failure)
            @foreach ($failure->errors() as $error)
                <li>{{ $error }}</li>
            @endforeach
         @endforeach
      </ul>
   </div>
@endif


     <!-- Add Staff Modal -->
     <x-jet-dialog-modal wire:model="modalFormVisible">
            <x-slot name="title">
                {{ __('Add Staff Record') }}
            </x-slot>

            <x-slot name="content">
                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="firstname" value="{{ __('First Name') }}" />
                        <x-jet-input id="firstname" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.firstname" required autofocus />
                        <x-jet-input-error for="staff.firstname" class="mt-2" />
                        
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="surname" class="mx-2" value="{{ __('Surname') }}" />
                        <x-jet-input id="surname" class="block mt-1 mx-2 w-full" type="text" wire:model.debounce.800ms="staff.surname" required autofocus />
                        <x-jet-input-error for="staff.surname" class="mt-2" />
                    </div>
                </div>   
                <div class="flex justify-between mb-4">  
                    <div class="w-2/3">
                        <x-jet-label for="othername" value="{{ __('Other Name') }}" />
                        <x-jet-input id="othername" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.othername" required autofocus />
                    </div>
                    <div class="w-2/3">
                            <x-jet-label for="gender" class="mx-2 mb-1" value="{{ __('Gender') }}" />
                            <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mx-2" wire:model="staff.gender">
                                <option value="">Select Gender</option>
                                @foreach($data['genders'] as $title)
                                        <option value="{{$title['value']}}">
                                            {{$title['title']}}
                                        </option>
                                @endforeach
                                
                            </select> 
                            <x-jet-input-error for="staff.gender" class="mt-2" />   
                        </div>
                </div>

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="phone" value="{{ __('Phone Number') }}" />
                        <x-jet-input id="phone" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.phone" required autofocus />
                        <x-jet-input-error for="staff.phone" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="email" class="mx-2" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 mx-2 w-full" type="text" wire:model.debounce.800ms="staff.email" required autofocus />
                    </div>
                </div> 
                
                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="nin" value="{{ __('NIN Number') }}" />
                        <x-jet-input id="nin" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.nin" required autofocus />
                        <x-jet-input-error for="staff.nin" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        
                    </div>
                </div> 

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="lga_id" value="{{ __('LGA') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.lga_id">
                            <option value="">Select LGA</option>
                            @foreach($lgas as $lga)
                                <option value="{{$lga->id}}">{{$lga->name}}</option>
                             @endforeach       
                            
                        </select>   
                        <x-jet-input-error for="staff.lga_id" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="email" class="mx-2" value="{{ __('School') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mx-2" wire:model="staff.school_id">
                            <option value="">Select School</option>
                            @foreach($schools as $school)
                                <option value="{{$school->id}}">{{$school->name}}</option>
                            @endforeach
                        </select>    
                        <x-jet-input-error for="staff.school_id" class="mt-2" />
                    </div>
                </div>
                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="email" value="{{ __('Qualification') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.qualification">
                            <option value="">Select Qualification</option>
                            @foreach($data['qualifications'] as $title)
                                        <option value="{{$title['value']}}">
                                            {{$title['title']}}
                                        </option>
                                @endforeach
                            
                        </select>   
                        <x-jet-input-error for="staff.qualification" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="email" class="mx-2" value="{{ __('Status') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mx-2" wire:model="staff.status">
                            <option value="">Select Status</option>
                            @foreach($data['status'] as $title)
                                        <option value="{{$title['value']}}">
                                            {{$title['title']}}
                                        </option>
                                @endforeach
                            
                        </select>   
                        <x-jet-input-error for="staff.status" class="mt-2" /> 
                    </div>
                </div>   

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="phone" value="{{ __('Date of Birth') }}" />
                        <x-jet-input id="phone" class="block mt-1 w-full" type="date" wire:model.debounce.800ms="staff.dob" required autofocus />
                        <x-jet-input-error for="staff.dob" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="email" class="mx-2" value="{{ __('Date of 1st Appointment') }}" />
                        <x-jet-input id="email" class="block mt-1 mx-2 w-full" type="date" wire:model.debounce.800ms="staff.dofa" required autofocus />
                        <x-jet-input-error for="staff.dofa" class="mt-2" />
                    </div>
                </div> 

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="email" value="{{ __('Cadre') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.cadre">
                            <option value="">Select Cadre</option>
                            @foreach($data['cadre'] as $title)
                                        <option value="{{$title['value']}}">
                                            {{$title['title']}}
                                        </option>
                                @endforeach
                            
                        </select>   
                        <x-jet-input-error for="staff.cadre" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="email" class="mx-2" value="{{ __('Remark') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mx-2" wire:model="staff.remark">
                            <option value="">Select remark</option>
                            @foreach($data['remarks'] as $title)
                                        <option value="{{$title['value']}}">
                                            {{$title['title']}}
                                        </option>
                                @endforeach
                            
                        </select>   
                        <x-jet-input-error for="staff.remark" class="mt-2" /> 
                    </div>
                </div> 

                <div class="flex justify-between mb-4">
                    <div class="w-1/4">
                        <x-jet-label for="email" value="{{ __('Current Grade Level') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.grade">
                            <option value="">Select grade</option>
                            @for($i=1; $i <= 17; $i++)
                                        <option value="{{$i}}">
                                            GL{{sprintf("%02d", $i)}}
                                        </option>
                            @endfor
                            
                        </select>   
                        <x-jet-input-error for="staff.grade" class="mt-2" />
                        
                    </div>
                    <div class="w-1/4 mx-2">
                        <x-jet-label for="email" value="{{ __('Current Step') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.step">
                            <option value="">Select step</option>
                            @for($i=1; $i <= 15; $i++)
                                        <option value="{{$i}}">
                                            Step{{sprintf("%02d", $i)}}
                                        </option>
                            @endfor
                            
                        </select>   
                        <x-jet-input-error for="staff.step" class="mt-2" />
                        
                    </div>
                    <div class="w-1/4 mx-2">
                        <x-jet-label for="email" value="{{ __('Salary Grade Level') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.salary_grade">
                            <option value="">Select grade</option>
                            @for($i=1; $i <= 17; $i++)
                                        <option value="{{$i}}">
                                            GL{{sprintf("%02d", $i)}}
                                        </option>
                            @endfor
                            
                        </select>   
                        <x-jet-input-error for="staff.salary_grade" class="mt-2" />
                        
                    </div>
                    <div class="w-1/4">
                        <x-jet-label for="email" value="{{ __('Salary Step') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.salary_step">
                            <option value="">Select step</option>
                            @for($i=1; $i <= 15; $i++)
                                        <option value="{{$i}}">
                                            Step{{sprintf("%02d", $i)}}
                                        </option>
                            @endfor
                            
                        </select>   
                        <x-jet-input-error for="staff.salary_step" class="mt-2" />
                        
                    </div>
                </div> 

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="bvn" value="{{ __('BVN') }}" />
                        <x-jet-input id="bvn" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.bvn" required autofocus />
                        <x-jet-input-error for="staff.bvn" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="bank" class="mx-2" value="{{ __('Bank Name') }}" />
                        <x-jet-input id="bank" class="block mt-1 mx-2 w-full" type="text" wire:model.debounce.800ms="staff.bank" required autofocus />
                        <x-jet-input-error for="staff.bank" class="mt-2" />
                    </div>
                </div>  

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="account_name" value="{{ __('Account name') }}" />
                        <x-jet-input id="account_name" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.account_name" required autofocus />
                        <x-jet-input-error for="staff.account_name" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="account_number" class="mx-2" value="{{ __('Account Number') }}" />
                        <x-jet-input id="account_number" class="block mt-1 mx-2 w-full" type="text" wire:model.debounce.800ms="staff.account_number" required autofocus />
                        <x-jet-input-error for="staff.account_number" class="mt-2" />
                    </div>
                </div>  

                <div class="flex justify-between mb-4">
                    <div class="w-full">
                        <x-jet-label for="address" value="{{ __('Home Address') }}" />
                        <x-jet-input id="address" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.address" required autofocus />
                        <x-jet-input-error for="staff.address" class="mt-2" />
                    </div>
                    
                </div>  

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="next_of_kin_name" value="{{ __('Next of Kin Name') }}" />
                        <x-jet-input id="next_of_kin_name" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.next_of_kin_name" required autofocus />
                        <x-jet-input-error for="staff.next_of_kin_name" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="next_of_kin_phone" class="mx-2" value="{{ __('Next of Kin Number') }}" />
                        <x-jet-input id="next_of_kin_phone" class="block mt-1 mx-2 w-full" type="text" wire:model.debounce.800ms="staff.next_of_kin_phone" required autofocus />
                        <x-jet-input-error for="staff.next_of_kin_phone" class="mt-2" />
                    </div>
                </div>  

                <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="next_of_kin_address" value="{{ __('Next of Kin Address') }}" />
                        <x-jet-input id="next_of_kin_address" class="block mt-1 w-full" type="text" wire:model.debounce.800ms="staff.next_of_kin_address" required autofocus />
                        <x-jet-input-error for="staff.next_of_kin_address" class="mt-2" />
                    </div>
                    <div class="w-1/3">
                        <x-jet-label for="next_of_kin_relationship" class="mx-2 mb-2" value="{{ __('Relationship with Next of Kin') }}" />
                        
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="staff.next_of_kin_relationship">
                            <option value="">Select Relationship</option>
                            @foreach($data['relationship'] as $title)
                                        <option value="{{$title['value']}}">
                                            {{$title['title']}}
                                        </option>
                                @endforeach
                            
                        </select>   
                        
                        <x-jet-input-error for="staff.next_of_kin_relationship" class="mt-2" />
                    </div>
                </div>  

                 
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                @if($staffId)
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

         <!-- Month Select Modal -->
     <x-jet-dialog-modal wire:model="modalMonthVisible">
            <x-slot name="title">
                {{ __('Export Staff Payroll') }}
            </x-slot>

            <x-slot name="content">
            <div class="flex justify-between mb-4">
                    <div class="w-2/3">
                        <x-jet-label for="lga_id" value="{{ __('LGA') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model="month">
                            <option value="">Select Month</option>
                            @foreach($months as $k => $month)
                            
                                <option value="{{$k}}">{{$month}}</option>
                             @endforeach       
                            
                        </select>   
                        <x-jet-input-error for="month" class="mt-2" />
                    </div>
                    <div class="w-2/3">
                        <x-jet-label for="email" class="mx-2" value="{{ __('School') }}" />
                        <select class="w-full bg-white rounded px-3 py-2 border-gray-300 text-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mx-2" wire:model="year">
                            <option value="">Select Year</option>
                            @for($y = 2000; $y <= date('Y'); $y++)
                                <option value="{{$y}}">{{$y}}</option>
                            @endfor
                        </select>    
                        <x-jet-input-error for="year" class="mt-2" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalMonthVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="payrollDownload" wire:loading.attr="disabled">
                    {{ __('Download Payroll') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>


         <!-- Upload Staff Data Modal -->
     <x-jet-dialog-modal wire:model="modalUploadVisible">
            <x-slot name="title">
                {{ __('Upload Bulk Staff Records') }}
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
                            wire:model="excelFile" id="{{ $iteration }}">
                        @error('excelFile') <span class="text-red-500">{{ $message }}</span>@enderror
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('modalUploadVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-3" wire:click="upload" wire:loading.attr="disabled">
                    {{ __('Upload Records') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>

</div>
