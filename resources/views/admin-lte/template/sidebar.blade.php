
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
            <a href="{{$menu['link'] === '#' ? 'javascript:;' :route($menu['link'])}}"  class="nav-link  {{checkRequestIs($menu['route'])}}">
              <i class="{{$menu['icon']}}"></i>
              <p>
                {{trans($menu['title'])}}
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