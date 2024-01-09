<table>
          <thead>
          <tr>
            <th></th>
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
          <tbody>

          
          
          @foreach($lgas as $item)
          
         
          <tr>
            <td class="image-cell">
              <div class="image">
                
              </div>
            </td>
            <td data-label="LGA">{{$item->name}}</td>
           
            <td data-label="Schools">
              {{isset($lg[$item->id]) ? $lg[$item->id]->groupBy('school_id')->count() : ''}}
            </td>
            <td data-label="Staff">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Qualified')->count() : ''}}
              <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Qualified')->sum('net_salary')) : 0}})</small>
            </td>
            <td data-label="QualifiedRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Qualified')->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('remark', 'Qualified')->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>
            <td data-label="Trainable">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Trainable')->count() : ''}}
              <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Trainable')->sum('net_salary')) : 0}})</small>
            </td>
            <td data-label="TrainableRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Trainable')->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Trainable')->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>
            
            
            <td data-label="Non-Trainable">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Not Qualified')->count() : ''}}
              <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('lga_id', $item->id)->where('remark', 'Not Qualified')->sum('net_salary')) : 0}})</small>
            </td>
            <td data-label="Non-TrainableRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('remark', 'Not Qualified')->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('remark', 'Not Qualified')->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>

            <td data-label="Total">
              {{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->count() : ''}}
              <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->sum('net_salary')) : 0}})</small>
            </td>
            <td data-label="TotalRetired">{{isset($lg[$item->id]) ? $lg[$item->id]->where('lga_id', $item->id)->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small>({{isset($lg[$item->id]) ? number_format($lg[$item->id]->where('lga_id', $item->id)->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </td>
          </tr>
         @endforeach

         <tr>
            <th class="image-cell">
              <div class="image">
                
              </div>
            </th>
            <th data-label="Total">Total</th>
           
            <th data-label="Schools">
              {{isset($staff) ? $staff->distinct()->count('school_id') : ''}}
            </th>
            <th data-label="Staff">
              {{isset($staff) ? $staff->where('remark', 'Qualified')->count() : ''}}
              <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('remark', 'Qualified')->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="QualifiedRetired">{{isset($staff) ? $staff->where('remark', 'Qualified')->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('remark', 'Qualified')->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="Trainable">
              {{isset($staff) ? $staff->where('remark', 'Trainable')->count() : ''}}
              <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('remark', 'Trainable')->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="TrainableRetired">{{isset($staff) ? $staff->where('remark', 'Trainable')->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('remark', 'Trainable')->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>
            
            
            <th data-label="Non-Trainable">
              {{isset($staff) ? $staff->where('remark', 'Not Qualified')->count() : ''}}
              <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('remark', 'Not Qualified')->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="Non-TrainableRetired">{{isset($staff) ? $staff->where('remark', 'Not Qualified')->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('remark', 'Not Qualified')->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>

            <th data-label="Total">
              {{isset($staff) ? $staff->count() : ''}}
              <small class="text-gray-500">({{isset($staff) ? number_format($staff->sum('net_salary')) : 0}})</small>
            </th>
            <th data-label="TotalRetired">{{isset($staff) ? $staff->where('dor', '<=', \Carbon\Carbon::today())->count() : ''}}
            <small class="text-gray-500">({{isset($staff) ? number_format($staff->where('dor', '<=', \Carbon\Carbon::today())->sum('net_salary')) : 0}})</small>
            </th>
          </tr>

          </tbody>
        </table>