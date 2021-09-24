@extends('dashboard.layouts.app')

@section('content_header')
<section class="content-header">
      <h1>
        Exam Records
      </h1>
      <ol class="breadcrumb">
        
      </ol>
    </section>
@endsection

@section('content')
<section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Exam Records</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover table-striped ar-datatableX">
            <thead>
              <tr>
                <th>Date</th>
                <th>Candidate</th>
                <th>Mobile No</th>
                <th>Subject</th>
                <th>Question</th>
                <th>Attempts</th>
                <th>Time</th>
                <th>Marks</th>
              </tr>
            </thead>
            <tbody>
            @if( isset($data) )
              @foreach( $data as $v )
              <tr>
                <td>{{ date('d-m-Y', strtotime($v->created_at)) }}</td>
                <td>
                  @if( isset($v->userInfo) )
                  {{ $v->userInfo->first_name }} {{ $v->userInfo->last_name }}
                  @endif
                </td>
                <td>
                  @if( isset($v->userInfo) )
                  {{ $v->userInfo->contact_no }}
                  @endif  
                </td>
                <td>
                  @if( isset($v->subjectInfo) )
                  {!! html_entity_decode($v->subjectInfo->name, ENT_QUOTES) !!}
                  @endif
                </td>
                <td>{{ $v->total_question }}</td>
                <td>{{ $v->attempts }}</td>
                <td>{{ $v->total_time }} Min.</td>
                <td>{{ $v->marks_obtain }}</td>
              </tr>
              @endforeach
            @endif
            </tbody>
          </table>
          @if( isset($data) )
          {{ $data->links() }}
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
  });
});
</script>
@endpush