@extends('dashboard.layouts.app')

@section('content_header')
<section class="content-header">
      <h1>
        All Links
        <!--small>it all starts here</small-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Links</li>
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
      <a href="{{ route('addLinks') }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Link</a>
    </div>
    <div class="col-md-6">
    </div>
  </div>

  <!-- Default box -->
  <div class="box" style="margin-top: 10px;">
    <div class="box-header with-border">
      <h3 class="box-title">All Links</h3>

      <div class="box-tools pull-right">
        
      </div>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-hover table-striped ar-datatable">
        <thead>
          <tr>
            <th>SL</th>
            <th>Link</th>
            <th>Date</th>
            <th>Valid Time</th>
            <th>Login</th>
            <th>Add Question</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @if(isset($allLinks))
          @php 
            $sl = 1; 
          @endphp

          @forelse($allLinks as $lk)
            @php
              $today = strtotime( date('Y-m-d') );
              $examDate = strtotime( $lk->start_date );
              $stime = strtotime( $lk->start_time );
              $etime = strtotime( $lk->end_time );
              $ctime = strtotime( date('g:i A') );
              $now = strtotime( date('Y-m-d H:i:s') );
              $examDateTimeStart = strtotime( $lk->start_date .' '.$lk->start_time );
              $examDateTimeEnd = strtotime( $lk->start_date .' '.$lk->end_time );
            @endphp
          <tr>
            <td>{{ $sl }}</td>
            <td>
              @if($now >= $examDateTimeStart && $now <= $examDateTimeEnd)
                <a href="{{ route('runningCandidates', array('id' => $lk->id)) }}">
                  {{ route('exLinksReg', array('slug' => $lk->link)) }}
                </a>
              @else
                {{ route('exLinksReg', array('slug' => $lk->link)) }}
              @endif
            </td>
            <td>{{ date('d-m-Y', strtotime( $lk->start_date )) }}</td>
            <td>
              From : {{ date('g:i A', strtotime( $lk->start_time )) }}<br/>
              To : {{ date('g:i A', strtotime( $lk->end_time )) }}
            </td>
            <td>
              Username : {{ $lk->username }}<br/>
              Password : {{ $lk->password }}
            </td>
            <td>
              @if( $now < $examDateTimeStart )
                <a href="{{ route('addEdtQues', array('link_id' => $lk->id)) }}"><i class="fa fa-plus-square" aria-hidden="true"></i> Add ( {{ linkQuestionCount( $lk->id ) }} )</a>
              @elseif($now >= $examDateTimeStart && $now <= $examDateTimeEnd)
                <span class="base-green">RUNNING..</span>
              @else
              <span class="base-red">EXPIRED</span>
              @endif
              @if( isset($lk->GetCandidateIds) )
              <br/>
              <a href="{{ route('viewLinkCandidates', array('link' => $lk->id)) }}">Candidates - {{ count($lk->GetCandidateIds) }}</a>
              @endif
            </td>
            <td>
              @if( $now < $examDateTimeStart )
              <a href="{{ route('edtLink', array('id' => $lk->id)) }}" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil-square-o base-green"></i></a>
              @endif
              <a href="{{ route('delLink', array('id' => $lk->id)) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Sure To Delete This Link ?');"><i class="fa fa-trash-o base-red"></i></a>
            </td>
          </tr>
          @php $sl++; @endphp
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