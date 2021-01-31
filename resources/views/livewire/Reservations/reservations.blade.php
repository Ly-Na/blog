

<div class="py-12">
    <div >
<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
<div class="flex flex-wrap">
    <div class="w-full md:w-1/2 xl:w-1/6 p-6">
    <div class="shadow-md">
    <div class="tab w-full overflow-hidden border-t" style='padding: 1.25rem;'>
   
            <div class='flex' >
            <h5 class="font-bold uppercase text-gray-600" >Salles</h5>
            <svg wire:click="$emit('refresh')" style='cursor: pointer;margin-top:-10px' class="h-12 w-12 text-green-500"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -5v5h5" />  <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 5v-5h-5" /></svg>
            </div>
            </div>
    @foreach($Salles as $Salle)
  
            <div class="tab w-full overflow-hidden border-t">
               <input class="absolute opacity-0" id="tab-single-s{{ $Salle->id }}" type="radio" name="tabs2">
               <label  wire:click="$emit('selected',{{ $Salle->id }})" 
               class="block p-5 leading-normal cursor-pointer" for="tab-single-s{{ $Salle->id }}">{{ $Salle->numero }}</label>
               <div class="tab-content overflow-hidden border-l-2 bg-gray-100 border-indigo-500 leading-normal">
                  <p class="p-5">{{ $Salle->description }}</p>
               </div>
            </div>
                    @endforeach
           
           
         </div>
    </div>
    <div class="w-full md:w-1/2 xl:w-1/2 p-6">
        <!--Metric Card-->
        <div class="bg-gradient-to-b from-white-200 to-white-100 border-b-4 border-whitw-500 rounded-lg shadow-xl p-5">
        <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-600">{{$month}} <i class="fa fa-wallet fa-2x fa-inverse"></i> </h5>
               
                    <select wire:model="selectedMonth" wire:change="change" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"  >


               @foreach($months as $m=>$value)
               <option value="{{$m<9?'0'.($m+1):$m+1}}" >{{$value}}</option>

                @endforeach

</select> </div>
            <div class="flex flex-wrap items-center" style="margin-top:20px;">
            @if(!empty($listDays))
    @foreach($listDays as $key=>$value)
                <div class="flex-shrink pr-10" style="margin-top: 10px;" >
                    <div class="rounded-full p-5 bg-{{$dateSetSelected==$key+1||$dateSelected==$key+1?'pink-600':'blue-100'}}" wire:click="$emit('selectDate',{{ $key+1 }})"
                     style='cursor: pointer;'>{{$key<9?'0'.($key+1):$key+1}}</div>
                </div>
                @endforeach
                    @endif  
            </div>
        </div>
        <!--/Metric Card-->
    </div>
    <div class="w-full md:w-1/2 xl:w-1/3 p-6">
    <div class="shadow-md">
    <div class="tab w-full overflow-hidden border-t" style='padding: 1.25rem;'>
    @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                  <div class="flex">
                    <div>
                      <p class="text-sm">{{ session('message') }}</p>
                    </div>
                  </div>
                </div>
            @endif
            <div class='flex' >
            <h5 class="font-bold uppercase text-gray-600" >Reservations </h5>
            <svg wire:click="create()"  style='cursor: pointer;margin-top:-10px' class="h-12 w-12 text-green-500"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <circle cx="12" cy="12" r="10" />  <line x1="12" y1="8" x2="12" y2="16" />  <line x1="8" y1="12" x2="16" y2="12" /></svg>
            </div>
            </div>
    @if($isOpen)
                @include('livewire.Reservations.create',$Salles)
            @endif
    @if(!empty($Reservations))
    @foreach($Reservations as $Reservation)

            <div class="tab w-full overflow-hidden border-t">
               <input class="absolute opacity-0" id="tab-single-{{ $Reservation->id }}" type="radio" name="tabs">
               <label 
               wire:click="$emit('selectReservation',{{ explode('-', $Reservation->date)[2]}})"
               class="block p-5 leading-normal cursor-pointer" for="tab-single-{{ $Reservation->id }}"> {{ $Reservation->nom_unite }} : {{ $Reservation->date }} de {{ $Reservation->debut }}h a {{ $Reservation->fin }}h 
               </label>
               <div class="tab-content overflow-hidden border-l-2 bg-gray-100 border-indigo-500 leading-normal">
               <div class='flex' style='padding: 1.25rem;'>               
               <svg wire:click="edit({{ $Reservation->id }})" style='cursor: pointer;' class="h-8 w-8 text-blue-500"  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <path d="M9 7 h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />  <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />  <line x1="16" y1="5" x2="19" y2="8" /></svg>
               <svg wire:click="delete({{ $Reservation->id }})" style='cursor: pointer;margin-left:85%' class="h-8 w-8 text-red-500" style='margin-left:85%'  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <line x1="4" y1="7" x2="20" y2="7" />  <line x1="10" y1="11" x2="10" y2="17" />  <line x1="14" y1="11" x2="14" y2="17" />  <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />  <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>

               </div>
 
                  <p class="p-5">{{ $Reservation->description }}</p>
               </div>
            </div>
                    @endforeach
                    @endif  

         </div>
    </div>
</div>
</div>
</div>
</div>