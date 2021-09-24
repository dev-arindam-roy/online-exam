@extends('dashboard.layouts.app')

@section('content_header')
<section class="content-header">
      <h1>
        @if( ! isset($addToLink) )
          All Questions
        @else
          Select Checkbox & Add Question To The Question Link
          @if( isset($total_question) ) | Added : <span class="badge" style="font-size: 32px;">{{ $total_question }}</span> Questions @endif
        @endif
        <!--small>it all starts here</small-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">All Questions</li>
      </ol>
    </section>
@endsection

@section('content')
<section class="content">

  @if(Session::has('msg'))
  <div class="ar-hide @if(Session::has('msg_class')){{ Session::get('msg_class') }}@endif">{{ Session::get('msg') }}</div>
  @endif

  @if( ! isset($addToLink) )
  <div class="row">
    <div class="col-md-6">
      <a href="{{ route('add_ques') }}" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add New Question</a>
    </div>
    <div class="col-md-6">
    </div>
  </div>
  @endif

  @if( isset( $addToLink ) && $addToLink == 'OK' )
  <!-- Default box -->
  <form name="frmx" action="{{ route('UpdateAddEdtQues', array('link_id' => $link_id)) }}" method="post">
  {{ csrf_field() }}
  <div class="box" style="margin-top: 10px;">
    <div class="box-header with-border">
      <h3 class="box-title">All Questions</h3>

      <div class="box-tools pull-right">
        <button type="submit" class="btn btn-danger" name="action_btn" value="remove" id="delAll" onclick="return confirm('Sure To Delete Selected Questions?');">REMOVE SELECTED QUESTIONS</button>
        <button type="submit" class="btn btn-success" name="action_btn" value="add" id="addAll">ADD SELECTED QUESTIONS</button>
      </div>
    </div>
    <div class="box-body">
      @if(isset($allQues))
      {{ $allQues->links() }}
      @endif
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th><!--input type="checkbox" id="ckAll"--></th>
            <th>Question</th>
            <th>Language</th>
            <th style="width: 150px;">Subject</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        @if(isset($allQues))
          @php $sl = 1; @endphp
          @forelse($allQues as $qu)
          <tr @if( isAddToLink( $link_id , $qu->id ) ) style="background-color: #ffe6e6;" @endif>
            <td><input type="checkbox" name="quesIds[]" value="{{ $qu->id }}" class="ckbs" @if( isAddToLink( $link_id , $qu->id ) ) checked="checked" @endif></td>
            <td>{!! html_entity_decode($qu->name, ENT_QUOTES) !!}</td>
            <td>
              @if( isset($qu->languageInfo) )
              {!! html_entity_decode($qu->languageInfo->name, ENT_QUOTES) !!}
              @endif
            </td>
            <td>
              @if( isset($qu->languageInfo) )
              {!! html_entity_decode($qu->subjectInfo->name, ENT_QUOTES) !!}
              @endif
            </td>
            <td>
              <a href="{{ route('edt_ques', array('id' => $qu->id)) }}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil-square-o base-green"></i></a>
            </td>
          </tr>
          @php $sl++; @endphp
          @empty
          @endforelse
        @endif
        </tbody>
      </table>
      @if(isset($allQues))
      {{ $allQues->links() }}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      
    </div>
    <!-- /.box-footer-->
  </div>
  </form>
  <!-- /.box -->
  @else
  <!-- Default box -->
  <div class="box" style="margin-top: 10px;">
    <div class="box-header with-border">
      <h3 class="box-title">All Questions</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                title="Collapse">
          <i class="fa fa-minus"></i></button>
        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr>
            <th>SL</th>
            <th>Question</th>
            <th>Language</th>
            <th>Subject</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        @if(isset($allQues))
          @php $sl = 1; @endphp
          @forelse($allQues as $qu)
          <tr>
            <td>{{ $sl }}</td>
            <td>{!! html_entity_decode($qu->name, ENT_QUOTES) !!}</td>
            <td>
              @if( isset($qu->languageInfo) )
              {!! html_entity_decode($qu->languageInfo->name, ENT_QUOTES) !!}
              @endif
            </td>
            <td>
              @if( isset($qu->languageInfo) )
              {!! html_entity_decode($qu->subjectInfo->name, ENT_QUOTES) !!}
              @endif
            </td>
            <td>
              <a href="{{ route('edt_ques', array('id' => $qu->id)) }}" data-toggle="tooltip" data-placement="bottom" title="Edit"><i class="fa fa-pencil-square-o base-green"></i></a>
              <a href="{{ route('del_ques', array('id' => $qu->id)) }}" data-toggle="tooltip" data-placement="bottom" title="Delete" onclick="return confirm('Sure To Delete This Question ?');"><i class="fa fa-trash-o base-red"></i></a>
            </td>
          </tr>
          @php $sl++; @endphp
          @empty
          @endforelse
        @endif
        </tbody>
      </table>
      @if(isset($allQues))
      {{ $allQues->links() }}
      @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
      
    </div>
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->
  @endif

    </section>
@endsection

@push('page_js')
<script type="text/javascript">
$(function() {
  $('.ar-datatable').DataTable({
    "columnDefs": [ {
      "targets": [ 4 ],
      "orderable": false
    } ]
  });
});
</script>
<script type="text/javascript">
$( function() {
  $(".ckbs").on('click', function(){
    colMark();
  });
} );
function colMark() {
  $( '.ckbs' ).each(function() {
    if($(this).is(':checked')) {
      $(this).parents('tr').css('background-color', '#ffe6e6');
    } else {
      $(this).parents('tr').removeAttr('style');
    }
  });
}
</script>
@endpush