@extends('dashboard.layouts.app')

@section('content_header')
<section class="content-header">
      <h1>
        All Running Candidates
        <!--small>it all starts here</small-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Running Candidates</li>
      </ol>
    </section>
@endsection

@section('content')
<section class="content">

  @if(Session::has('msg'))
  <div class="ar-hide @if(Session::has('msg_class')){{ Session::get('msg_class') }}@endif">{{ Session::get('msg') }}</div>
  @endif

  

  <!-- Default box -->
  <div class="box" style="margin-top: 10px;">
    <div class="box-header with-border">
      <h3 class="box-title">All Running Candidates</h3>

      <div class="box-tools pull-right">
        <a href="{{ route('runningCandidates', array('id' => $link_id)) }}" class="btn btn-primary">Refresh/Reload</a>
      </div>
    </div>
    <div class="box-body">
    <table class="table table-bordered table-hover table-striped ar-datatable">
        <thead>
          <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Email-id</th>
            <th>Contact No</th>
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
            <td>{{ $user->email_id }}</td>
            <td>{{ $user->contact_no }}</td>
            <td>
                <a href="{{ route('runningCandidatesDel', array('link_id' => $link_id, 'user_id' => $user->id)) }}" title="Delete Candidate" onclick="return confirm('Sure To Delete This Candidate ?');"><i class="fa fa-trash-o base-red"></i></a>
            </td>
          </tr>
          @php $sl++; @endphp
          @endforeach
        @endif
        </tbody>
      </table>
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
    "columnDefs": [ {
      "targets": [ 5 ],
      "orderable": false
    } ]
  });
});
</script>
@endpush