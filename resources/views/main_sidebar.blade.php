<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        </br>
        <!-- Sidebar user panel (optional) -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{url('/')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{config('strings.menu.dashboard')}}</span>
                </a>
            </li>

            @if(auth()->user()->getType() =='admin' ||
            auth()->user()->getType()=='coach')
            <li class="{{ Request::is('players/*') || Request::is('players') ? 'active' : '' }}">
                <a href="{{url('/players')}}">
                    <i class="fa fa-users"></i>
                    <span>{{config('strings.menu.players')}}</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->getType()=='admin')
            <li class="{{ Request::is('academies/*') || Request::is('academies') ? 'active' : '' }}">
                <a href="{{url('/academies')}}">
                    <i class="fa fa-university"></i>
                    <span>{{config('strings.menu.academies')}}</span>
                </a>
            </li>
            @endif

            <!-- <li @if(Request::is('/events')) class="active" @endif><a href="{{url('/events')}}"><i class="fa fa-calendar"></i><span>{{config('strings.menu.events')}}</span></a></li> -->


            <li class="{{ Request::is('schedules/*') ||  Request::is('schedules') ? 'active' : ''}}">
                <a href="{{url('/schedules')}}">
                    <i class="fa fa-trophy"></i>
                    <span>{{config('strings.menu.matches')}}</span>
                </a>
            </li>
            <?php $active1 = ""; $menu_open1 = ""; $display1 = 'display:none';?>

            @if(app('request')->input('type')=='admin' || app('request')->input('type')=='coach')
            <?php $active1 = 'active';
                $menu_open1 = 'menu-open';
                $display1 = 'display:block';
           ?>
            @endif
            @if(auth()->user()->getType()=='admin')
            <li class="treeview {{$active1}}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>{{config('strings.menu.users')}}</span> <i
                        class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{$menu_open1}}" {{$display1}}>
                    <li class=" {{ app('request')->input('type')=='admin'  ? 'active' : '' }}">
                        <a href="{{url('/users?type=admin')}}">
                            <i class="fa fa-circle-o"></i>{{config('strings.submenu.admin')}}
                        </a>
                    </li>

                    <li class=" {{ app('request')->input('type')=='coach' ? 'active' : '' }}">
                        <a href="{{url('/users?type=coach')}}">
                            <i class="fa fa-circle-o"></i>{{config('strings.submenu.coach')}}
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <?php $active = ""; $menu_open = ""; $display = 'display:none';?>
            @if(Request::is('attendance/players') || Request::is('attendance/coaches'))
            <?php $active = 'active';
                $menu_open = 'menu-open';
                $display = 'display:block';
           ?>
            @endif
            <li class="treeview {{$active}}">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>{{config('strings.menu.attendance')}}</span> <i
                        class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{$menu_open}}" {{$display}}>
                    <li
                        class=" {{ Request::is('attendance/players/*') || Request::is('attendance/players') ? 'active' : '' }}">
                        <a href="{{url('/attendance/players')}}">
                            <i class="fa fa-circle-o"></i>{{config('strings.submenu.players_attendance')}}
                        </a>
                    </li>


                    @if(auth()->user()->getType()=='admin' ||
                    auth()->user()->getType()=='coach')

                    <li
                        class=" {{ Request::is('attendance/coaches/*') || Request::is('attendance/coaches') ? 'active' : '' }}">
                        <a href="{{url('/attendance/coaches')}}">
                            <i class="fa fa-circle-o"></i>{{config('strings.submenu.coaches_attendance')}}
                        </a>
                    </li>

                    @endif
                </ul>
            </li>
            @if(auth()->user()->getType()=='player')
            <li class=" {{ Request::is('players/{id}/assessments') ? 'active' : '' }}">
                <a href="{{url('players/'.auth()->user()->player->id.'/assessments?type=technical')}}">
                    <i class="fa fa-file"></i>
                    <span>{{config('strings.menu.assessments')}}</span>
                </a>
            </li>
            @endif


            @if(auth()->user()->getType()=='admin')

            <li class=" {{ Request::is('drills/*') || Request::is('drills') ? 'active' : '' }}">
                <a href="{{url('/drills')}}">
                    <i class="fa fa-child"></i>
                    <span>{{config('strings.menu.drills')}}</span>
                </a>
            </li>

            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
