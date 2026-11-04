 <div class="d-flex flex-wrap justify-content-center">
     @if (Auth::user()->hasPermission('colour.manage'))
         <a href="{{ route('colours') }}" data-toggle="popover" data-trigger="focus" data-placement="top" title="Colours"
             class="mini-menu  {{ Str::startsWith(request()->path(), 'admin/shop/attributes/colours') ? 'mini-menu-active' : '' }}">
             <div class="p-2" tabindex="0">
                 <i class="fas fa-palette"></i>
             </div>
         </a>
     @endif

      @if (Auth::user()->hasPermission('weight.manage'))
         <a href="{{ route('weights') }}" data-toggle="popover" data-trigger="focus" data-placement="top" title="Weights"
             class="mini-menu  {{ Str::startsWith(request()->path(), 'admin/shop/attributes/weights') ? 'mini-menu-active' : '' }}">
             <div class="p-2" tabindex="0">
                 <i class="fas fa-weight-hanging"></i>
             </div>
         </a>
     @endif

     @if (Auth::user()->hasPermission('weight.manage'))
         <a href="{{ route('weights') }}" data-toggle="popover" data-trigger="focus" data-placement="top" title="Other Attributes"
             class="mini-menu  {{ Str::startsWith(request()->path(), 'admin/shop/attributes/others') ? 'mini-menu-active' : '' }}">
             <div class="p-2" tabindex="0">
                 <i class="fas fa-ruler-combined"></i>
             </div>
         </a>
     @endif

 </div>
