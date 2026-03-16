<style>
.blink-menu {
    animation: glow 1s infinite alternate;
}

@keyframes glow {
    from {
        color: #fff;
    }
    to {
        color: #ffc107;
        text-shadow: 0 0 10px #ffc107;
    }
}
</style>
<style>
    .burst-new {
    position: relative;
    color: #fff;
    background: #ff3b3b;
    padding: 6px;
    border-radius: 50%;
}

.burst-new::after {
    content: "NEW";
    position: absolute;
    top: -6px;
    right: -12px;
    background: orange;
    color: white;
    font-size: 8px;
    padding: 2px 4px;
    border-radius: 3px;
}

.badge-danger {
    animation: blink 1s infinite;
}

@keyframes blink {
    0% {opacity:1;}
    50% {opacity:0.3;}
    100% {opacity:1;}
}
</style>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ URL::asset('images/national_emblem.png') }}" alt="National Logo" class=""style="height:130%">      
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
     
   

      <!-- Sidebar Menu -->
      <nav class="mt-5">
      @php
        $sidebar_menu = getMenu();
         // dd($sidebar_menu);  
        @endphp
		 @if(count($sidebar_menu) > 0)
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		@foreach($sidebar_menu as $key=>$menu)
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library  --> 
                </a>
          <li class="nav-item has-treeview  {{checkRequestIs_open($menu['route'])}}">
            <a href="{{$menu['link'] === '#' ? 'javascript:;' :route($menu['link'])}}"  class="nav-link  {{checkRequestIs($menu['route'])}} {{ $menu['title']=='Quarter Draw' ? 'blink-menu' : '' }}"  >
              <i class="{{$menu['icon']}}"></i>
              <p>
                {{trans($menu['title'])}}
                 @if($menu['title'] == 'Quarter Draw')
                    <span class="badge badge-danger ml-2 blink-new">NEW</span>
                @endif
				 @if(isset($menu['submenu']) && !empty($menu['submenu']))
                <i class="right fas fa-angle-left"></i> @endif
              </p>
            </a>
			  @if(isset($menu['submenu']) && !empty($menu['submenu']))
            <ul class="nav nav-treeview ">
			  @foreach($menu['submenu'] as $submenu)
              <li class="nav-item  ">
                <a href="{{$submenu['link'] === '#' ? 'javascript:;' :route($submenu['link'])}}" class="nav-link {{checkRequestIs($submenu['route'])}}">
                  <i class="{{$submenu['icon']}}"></i>
                  <p>{{trans($submenu['title'])}}</p>
                </a>
              </li> @endforeach
              </ul> 
			@endif
          </li>@endforeach 
         
           </ul>
        @endif
          </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>