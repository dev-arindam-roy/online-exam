@extends('dashboard.layouts.app')

@section('content_header')
<section class="content-header">
      <h1>
        All Candidates @if( isset($linkInfo) ) | Link : {{ $linkInfo->link }} | {{ date( 'd F Y', strtotime($linkInfo->start_date) ) }} @endif
        <!--small>it all starts here</small-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Candidates</li>
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
      
    </div>
    <div class="col-md-6">
    </div>
  </div>

  <!-- Default box -->
  <div class="box" style="margin-top: 10px;">
    <div class="box-header with-border">
      <h3 class="box-title">All Candidates</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-hover table-striped ar-datatable">
        <thead>
          <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Total Q.</th>
            <th>Marks</th>
            <th>Attempts</th>
          </tr>
        </thead>
        <tbody>
        @if(isset($candidateExamInfo))
          @php 
            $sl = 1; 
          @endphp

          @forelse($candidateExamInfo as $c)
            @if(isset($c->userInfo) && !empty($c->userInfo))
              <tr>
                <td>{{ $sl }}</td>
                <td>
                  {{ $c->userInfo->first_name }}
                </td>
                <td>
                  {{ $c->userInfo->email_id }}
                </td>
                <td>
                  {{ $c->userInfo->contact_no }}
                </td>
                <td>
                  {{ $c->total_question }}
                </td>
                <td>
                  {{ $c->marks_obtain }}
                </td>
                <td>
                  {{ $c->attempts }}
                  <!--a href="" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil-square-o base-green"></i></a>
                  
                  <a href="" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Sure To Delete This Link ?');"><i class="fa fa-trash-o base-red"></i></a-->
                </td>
              </tr>
              @php $sl++; @endphp
            @endif
          @empty
          @endforelse
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
      "targets": [ 5 , 6 ],
      "orderable": false
    } ]
  });
});
</script>
@endpush