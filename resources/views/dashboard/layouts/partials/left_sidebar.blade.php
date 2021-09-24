<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="background-color: #fff; text-align: center;">
      <!--div class="pull-left image">
        @if(Auth::user()->image != '' && Auth::user()->image != null)
        <img src="{{ asset('public/uploads/user_images/thumb/'. Auth::user()->image) }}" class="img-circle" alt="User Image">
        @else
        <img src="{{ asset('public/images/user_image.png') }}" class="img-circle" alt="User Image">
        @endif
      </div>
      <div class="pull-left info">
        <p>{{ ucfirst(Auth::user()->first_name) }}</p>
        <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> Online</a>
      </div-->
      <!--a href="{{ route('dashboard') }}" id="brandBox">
        <img src="{{ asset('public/images/brand.png') }}" class="brandBox_logo">
      </a-->
    </div>
    <!-- search form -->
    <!--form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form-->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class=""><a href="{{ route('dashboard') }}"><i class="fa fa-circle-o"></i> Dashboard</a></li>
        </ul>
      </li>
      <!--li class="header">USER MANAGEMENT</li-->
      <li class="treeview @if(isset($parentMenu) && $parentMenu == 'userManagement') active @endif">
        <a href="#">
          <i class="fa fa-users" aria-hidden="true"></i> <span>Users Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="@if(isset($childMenu) && $childMenu == 'usersList') active @endif">
            <a href="{{ route('users_list') }}"><i class="fa fa-circle-o"></i> All Users</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'createUser') active @endif">
            <a href="{{ route('crte_user') }}"><i class="fa fa-circle-o"></i> Create User</a>
          </li>
        </ul>
      </li>


      <!--li class="header">QUESTION</li-->
      <li class="treeview @if(isset($parentMenu) && $parentMenu == 'questM') active @endif">
        <a href="#">
          <i class="fa fa-question-circle" aria-hidden="true"></i> <span>Question Management</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="@if(isset($childMenu) && $childMenu == 'allSub') active @endif">
            <a href="{{ route('sub_list') }}"><i class="fa fa-circle-o"></i> All Subjects</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'addSub') active @endif">
            <a href="{{ route('add_sub') }}"><i class="fa fa-circle-o"></i> Add Subject</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'allQues') active @endif">
            <a href="{{ route('ques_list') }}"><i class="fa fa-circle-o"></i> All Questions</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'addQues') active @endif">
            <a href="{{ route('add_ques') }}"><i class="fa fa-circle-o"></i> Add Question</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'settQues') active @endif">
            <a href="{{ route('settQues') }}"><i class="fa fa-circle-o"></i> Exam Settings</a>
          </li>
        </ul>
      </li>


      <!--li class="header">QUESTION LINKS</li-->
      <li class="treeview @if(isset($parentMenu) && $parentMenu == 'quesLink') active @endif">
        <a href="#">
          <i class="fa fa-question-circle" aria-hidden="true"></i> <span>Question Links</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="@if(isset($childMenu) && $childMenu == 'allLinks') active @endif">
            <a href="{{ route('links') }}"><i class="fa fa-circle-o"></i> All Links</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'addLink') active @endif">
            <a href="{{ route('addLinks') }}"><i class="fa fa-circle-o"></i> Add Link</a>
          </li>
        </ul>
      </li>


      <!--li class="header">SETTINGS</li-->
      <li class="treeview @if(isset($parentMenu) && $parentMenu == 'settings') active @endif">
        <a href="#">
          <i class="fa fa-cogs" aria-hidden="true"></i> <span>Settings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="@if(isset($childMenu) && $childMenu == 'genSett') active @endif">
            <a href="{{ route('gen_sett') }}"><i class="fa fa-circle-o"></i> General Settings</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'profile') active @endif">
            <a href="{{ route('usr_profile') }}"><i class="fa fa-circle-o"></i> My Profile</a>
          </li>
          <li class="@if(isset($childMenu) && $childMenu == 'cngPwd') active @endif">
            <a href="{{ route('cng_pwd') }}"><i class="fa fa-circle-o"></i> Change Password</a>
          </li>
        </ul>
      </li>

      <!--li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
      <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li-->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- =============================================== -->