<div>
<div class="flex items-center justify-end px-4 py-2 text-right sm:px-6">    
       
<x-filament::button wire:click="clearFilters">
      <span class="fi-btn-label">
            Clear Filters
        </span>
        </x-filament::button>
    </div>
<div class="flex justify-between p-6 inline-block relative grid gap-6 md:grid-cols-2 xl:grid-cols-4">

@if (auth()->user()->role_id == 1)
<div class="min-w-0 flex-1">
              <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="status" >Category</label>
              <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-select">        
              <x-filament::input.select wire:model.live="category_id">
              <option value="">Select category</option>
                @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

              </x-filament::input.select>
        </div>
</div>
@endif
@if (!in_array(auth()->user()->role_id, [2, 4, 5, 6]))
@if ($category_id != "" && $category_id == 4)
    <div class="min-w-0 flex-1">
              <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="email" class="mx-2" >MDA</label>
              <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-select">      
              <x-filament::input.select wire:model.live="agency_id">
                <option value="">Select MDA</option>
                @foreach($agencies->where('category_id', $category_id) as $agency)
                  <option value="{{$agency->id}}">{{$agency->name}}</option>
                @endforeach
              </x-filament::input.select>
              </div>
        </div>
@endif
@endif

@if (!in_array(auth()->user()->role_id, [3, 4]))
@if ($category_id != "" && $category_id < 4)
<div class="min-w-0 flex-1">
              <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="lga" class="mx-2" >LGA</label>
              <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 dark:bg-white/5 ring-gray-950/10 focus-within:ring-primary-600 dark:ring-white/20 dark:focus-within:ring-primary-500 fi-fo-select">
              <x-filament::input.select wire:model.live="lga">
                <option value="">Select LGA</option>
                @foreach($lgas as $lga)
                  <option value="{{$lga->id}}">{{$lga->name}}</option>
                @endforeach
              </x-filament::input.select>    
          </div>
          </div>
@endif          
@endif
              
      </div>    
<section class="col-[--col-span-default] fi-wi-widget fi-wi-stats-overview">

    <div class="fi-wi-stats-overview-stats-ctn grid gap-6 md:grid-cols-2 xl:grid-cols-4" style="margin-bottom: 10px;">
    <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Total Number of Staff
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{count($staff->get())}}
              </h1>
              
            </div>
            <span class="icon widget-icon text-green-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="green">
  <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
              Total Salary Amount
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(($staff->sum('net_salary')))}}
              </h1>
            </div>

            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>

            
          </div>
        </div>
      </div>

      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Number of Pensioners
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{count($pensions->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->get())}}
              </h1>
            </div>
            
            
            <span class="icon widget-icon text-green-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="gold">
  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
</svg>
            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
              Pensioners Salary Amount
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(($pensions->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')))}}
              </h1>
            </div>
            <span class="icon widget-icon text-green-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Students and late cases begin -->
  @if ($category_id == "" || $category_id == 4)
    
    <div class="fi-wi-stats-overview-stats-ctn grid gap-6 md:grid-cols-2 xl:grid-cols-4" style="margin-bottom: 10px;">
      

      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Number of Students
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{count($students->get())}}
              </h1>
            </div>
            

            
            <span class="icon widget-icon text-blue-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="lightgreen" class="w-12 h-12">
  <path d="M11.7 2.805a.75.75 0 0 1 .6 0A60.65 60.65 0 0 1 22.83 8.72a.75.75 0 0 1-.231 1.337 49.948 49.948 0 0 0-9.902 3.912l-.003.002c-.114.06-.227.119-.34.18a.75.75 0 0 1-.707 0A50.88 50.88 0 0 0 7.5 12.173v-.224c0-.131.067-.248.172-.311a54.615 54.615 0 0 1 4.653-2.52.75.75 0 0 0-.65-1.352 56.123 56.123 0 0 0-4.78 2.589 1.858 1.858 0 0 0-.859 1.228 49.803 49.803 0 0 0-4.634-1.527.75.75 0 0 1-.231-1.337A60.653 60.653 0 0 1 11.7 2.805Z" />
  <path d="M13.06 15.473a48.45 48.45 0 0 1 7.666-3.282c.134 1.414.22 2.843.255 4.284a.75.75 0 0 1-.46.711 47.87 47.87 0 0 0-8.105 4.342.75.75 0 0 1-.832 0 47.87 47.87 0 0 0-8.104-4.342.75.75 0 0 1-.461-.71c.035-1.442.121-2.87.255-4.286.921.304 1.83.634 2.726.99v1.27a1.5 1.5 0 0 0-.14 2.508c-.09.38-.222.753-.397 1.11.452.213.901.434 1.346.66a6.727 6.727 0 0 0 .551-1.607 1.5 1.5 0 0 0 .14-2.67v-.645a48.549 48.549 0 0 1 3.44 1.667 2.25 2.25 0 0 0 2.12 0Z" />
  <path d="M4.462 19.462c.42-.419.753-.89 1-1.395.453.214.902.435 1.347.662a6.742 6.742 0 0 1-1.286 1.794.75.75 0 0 1-1.06-1.06Z" />
</svg>

            
            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
              Total Student Allowances
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(($students->sum('net_salary')))}}
              </h1>
            </div>
            <span class="icon widget-icon text-blue-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>

      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Number of Late Cases
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{count($late->get())}}
              </h1>
            </div>
            
            
            <span class="icon widget-icon text-red-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="gray">
  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
</svg>
            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
              Late Cases Salary Amount
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(($late->sum('net_salary')))}}
              </h1>
            </div>
            <span class="icon widget-icon text-red-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>

    </div>

    @endif
    <!-- qualified end -->

     <!-- Deductions begin -->

     <div class="fi-wi-stats-overview-stats-ctn grid gap-6 md:grid-cols-2 xl:grid-cols-4" style="margin-bottom: 10px;">
      
  @if($category_id == "" || $category_id == 4)
     <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Number of Senior Citizens  
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              {{count($senior->get())}}
              </h1>
            </div>
            
            
            <span class="icon widget-icon text-blue-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="purple">
  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
</svg>
            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
              Total Payment to Senior Citizens
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format($senior->sum('net_salary'))}}
              </h1>
            </div>
            <span class="icon widget-icon text-blue-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>
          </div>
        </div>
      </div>
@endif
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Grand Total of Staff
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              {{count($all->get())}}
              </h1>
              
            </div>
            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="orange">
  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
</svg>
            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Grand Total of Salaries
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(($all->sum('net_salary')))}}
              </h1>
            </div>

            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>

            
          </div>
        </div>
      </div>

      @if ($category_id != "" && $category_id < 4)
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Total Number of Variations
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{0}}
              </h1>
              
            </div>
            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="skyblue" class="w-6 h-6">
  <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0V12Zm2.25-3a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0V9.75A.75.75 0 0 1 13.5 9Zm3.75-1.5a.75.75 0 0 0-1.5 0v9a.75.75 0 0 0 1.5 0v-9Z" clip-rule="evenodd" />
</svg>

            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Total Variations' Amount
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(0)}}
              </h1>
            </div>

            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>

            
          </div>
        </div>
      </div>
      @endif

    </div>

    <!-- Deductions end -->

     <!-- Variations begin -->
     @if($category_id == "" || $category_id == 4)
     <div class="fi-wi-stats-overview-stats-ctn grid gap-6 md:grid-cols-2 xl:grid-cols-4" style="margin-bottom: 10px;">
     <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                Total Number of Variations
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
                {{0}}
              </h1>
              
            </div>
            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-10 w-10 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="skyblue" class="w-6 h-6">
  <path fill-rule="evenodd" d="M3 6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v12a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V6Zm4.5 7.5a.75.75 0 0 1 .75.75v2.25a.75.75 0 0 1-1.5 0v-2.25a.75.75 0 0 1 .75-.75Zm3.75-1.5a.75.75 0 0 0-1.5 0v4.5a.75.75 0 0 0 1.5 0V12Zm2.25-3a.75.75 0 0 1 .75.75v6.75a.75.75 0 0 1-1.5 0V9.75A.75.75 0 0 1 13.5 9Zm3.75-1.5a.75.75 0 0 0-1.5 0v9a.75.75 0 0 0 1.5 0v-9Z" clip-rule="evenodd" />
</svg>

            <i class="mdi mdi-cart-outline mdi-48px"></i></span>
          </div>
        </div>
      </div>
      <div class="fi-wi-stats-overview-stat relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="card-content">
          <div class="flex items-center">
            <div class="widget-label">
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
            Total Variations' Amount
              </h3>
              <h1 class="text-2xl font-semibold tracking-tight text-gray-950 dark:text-white">
              <span>&#8358;</span>{{number_format(0)}}
              </h1>
            </div>

            <span class="icon widget-icon text-gray-500">
            <svg class="fi-wi-stats-overview-stat-description-icon h-8 w-8 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
</svg>  
            <i class="mdi mdi-finance mdi-48px"></i></span>

            
          </div>
        </div>
      </div>

      
    </div>
  @endif
    <!-- Pensioneers end -->

      <!-- Pensioneers begin -->

    <!-- Non-Trainable end -->


  @if($category_id != "" && $category_id < 4)
    <div class="flex items-center justify-end px-4 py-2 text-right sm:px-6">    
       
        <x-filament::button class="mx-1" wire:click="downloadSummary">
            {{ __('Download Summary') }}
        </x-filament::button>
    </div>

    <div class="card has-table">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon"><i class="mdi mdi-account-multiple"></i></span>
          Summary
        </p>
        <a href="#" class="card-header-icon">
          <span class="icon"><i class="mdi mdi-reload"></i></span>
        </a>
      </header>
      <div class="fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">
        <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
          <thead class="bg-gray-50 text-sm dark:bg-white/5">
          <tr>
            
            <th>LGA</th>
            <th>Schools</th>
            <th>Qualified Staff (Salary)</th>
            <th>Qualified Retired Staff (Salary)</th>
            <th>Trainable Staff (Salary)</th>
            <th>Trainable Retired Staff (Salary)</th>
            <th>Non-Trainable (Salary)</th>
            <th>Non-Trainable Retired (Salary)</th>
            <th>Total Salary</th>
            <th>Total Retired Salary</th>
          </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">

          
          
          @foreach($lga_page as $item)
          
          <tr>
            
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="LGA">{{$item->name}}</td>
           
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="Schools">
              {{isset($lg[$item->id]) ? $lg[$item->id]->groupBy('school_id')->count() : ''}}
            </td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="Staff">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Qualified')->count() : ''}}
              <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Qualified')->sum('net_salary')) : 0}})</small>
            </td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="QualifiedRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Qualified')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('minimum_wage', 'Qualified')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="Trainable">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Trainable')->count() : ''}}
              <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Trainable')->sum('net_salary')) : 0}})</small>
            </td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="TrainableRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>
            
            
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="Non-Trainable">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Not Trainable')->count() : ''}}
              <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Not Trainable')->sum('net_salary')) : 0}})</small>
            </td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="Non-TrainableRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('minimum_wage', 'Not Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('minimum_wage', 'Not Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>

            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="Total">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->count() : ''}}
              <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->sum('net_salary')) : 0}})</small>
            </td>
            <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 w-1" data-label="TotalRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>
          </tr>
         @endforeach
          </tbody>
          <tr>
            
            <th data-label="Total">Total</th>
           
            <th data-label="Schools">
              {{isset($school) ? $school->distinct()->count('school_id') : ''}}
            </th>
            <th data-label="Staff">
              {{isset($q) ? $q->where('minimum_wage', 'Qualified')->count() : ''}}
              <small class="text-gray-500">({{isset($q) ? number_format($q->where('minimum_wage', 'Qualified')->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="QualifiedRetired">{{isset($q) ? $q->where('minimum_wage', 'Qualified')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($q) ? number_format($q->where('minimum_wage', 'Qualified')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="Trainable">
              {{isset($t) ? $t->where('minimum_wage', 'Trainable')->count() : ''}}
              <small class="text-gray-500">({{isset($t) ? number_format($t->where('minimum_wage', 'Trainable')->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="TrainableRetired">{{isset($t) ? $t->where('minimum_wage', 'Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($t) ? number_format($t->where('minimum_wage', 'Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>
            
            
            <th data-label="Non-Trainable">
              {{isset($nq) ? $nq->where('minimum_wage', 'Not Trainable')->count() : ''}}
              <small class="text-gray-500">({{isset($nq) ? number_format($nq->where('minimum_wage', 'Not Trainable')->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="Non-TrainableRetired">{{isset($nq) ? $nq->where('minimum_wage', 'Not Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($nq) ? number_format($nq->where('minimum_wage', 'Not Trainable')->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>

            <th data-label="Total">
              {{isset($retired) ? $retired->count() : ''}}
              <small class="text-gray-500">({{isset($retired) ? number_format($retired->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="TotalRetired">{{isset($retired) ? $retired->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($retired) ? number_format($retired->where('expected_date_of_retirement', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>
          </tr>
        </table>
        <div class="inline-flex mt-2 xs:mt-0">
              {{ $lga_page->links() }}
        </div>
        
      </div>
    </div>

    @endif
  </section>
</div>
