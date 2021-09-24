@extends('dashboard.layouts.app')

@section('content_header')
<section class="content-header">
      <h1>
        All Users
        <!--small>it all starts here</small-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('crte_user') }}">Create User</a></li>
        <li class="active">User List</li>
      </ol>
    </section>
@endsection

@section('content')
<section class="content">

  @if(Session::has('msg'))
  <div class="ar-hide @if(Session::has('msg_class')){{ Session::get('msg_class') }}@endif">{{ Session::get('msg') }}</div>
  @endif

  <div class="row">
    <div class="col-md-6">
      <a href="{{ route('crte_user') }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Create User</a>
    </div>
    <div class="col-md-6">
    </div>
  </div>

  <!-- Default box -->
  <div class="box" style="margin-top: 10px;">
    <div class="box-header with-border">
      <h3 class="box-title">Users List</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <?php //echo "<pre>"; print_r($userList); ?>
    
    <div class="box-body">
      <table class="table table-bordered table-hover table-striped ar-datatableX">
        <thead>
          <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Role</th>
            <th>Email-id</th>
            <th>Contact No</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @if(isset($userList))
          @php $sl = 1; @endphp
          @foreach($userList as $user)
          <tr>
            <td>{{ $sl }}</td>
            <td>{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</td>
            <td>@if(isset($user->user_role)){{ ucfirst($user->user_role->role_name) }}@endif</td>
            <td>{{ $user->email_id }}</td>
            <td>{{ $user->contact_no }}</td>
            <td>
              @if($user->status == '1') <span class="base-green">Active</span> @endif
              @if($user->status == '2') <span class="base-red">Inctive</span> @endif
            </td>
            <td>
              <a href="{{ route('edit_user', array('utid' => $user->timestamp_id)) }}" data-toggle="tooltip" data-placement="bottom" title="Edit User"><i class="fa fa-pencil-square-o base-green"></i></a>

              <a href="{{ route('del_usr', array('utid' => $user->timestamp_id)) }}" data-toggle="tooltip" data-placement="bottom" title="Delete User" onclick="return confirm('Sure To Delete This User ?');"><i class="fa fa-trash-o base-red"></i></a>

              <a href="{{ route('rst_pwd', array('utid' => $user->timestamp_id)) }}" data-toggle="tooltip" data-placement="bottom" title="Reset Password"><i class="fa fa-key"></i></a>
            </td>
          </tr>
          @php $sl++; @endphp
          @endforeach
        @endif
        </tbody>
      </table>
      @if( isset($userList) )
      {{ $userList->links() }}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

    </section>
@endsection

@push('page_js')
<script type="text/javascript">
$(function() {
  $('.ar-datatable').DataTable({
    "order": [[ 1, "asc" ]],
    "columnDefs": [ {
      "targets": [ 0, 6 ],
      "orderable": false
    } ]
  });
});
</script>
@endpush