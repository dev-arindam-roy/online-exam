@extends('dashboard.layouts.app')



@section('content_header')
<section class="content-header">
  <h1>
    Exam Settings
    <!--small>it all starts here</small-->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('sub_list') }}">All Subjects</a></li>
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
  <div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Exam Settings</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form name="frm" id="frmx" action="{{ route('settQuesSve') }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>No. Of Questions in Exam <em>*</em></label>
                <input type="number" name="no_of_question" class="form-control" min="25" value="@if( isset($settings) ){{ $settings->no_of_question }}@endif">
              </div>
              <div class="form-group">
                <label>Each Question Marks in Exam <em>*</em></label>
                <input type="number" name="each_marks" class="form-control" min="1" value="@if( isset($settings) ){{ $settings->each_marks }}@endif">
              </div>
              <div class="form-group">
                <label>Exam Time <em>*</em></label>
                <input type="number" name="total_time" class="form-control" min="30" value="@if( isset($settings) ){{ $settings->total_time }}@endif"> in Minutes
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Save Settings">
              </div>
            </div>
          </div>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </div>
  </div>

</section>
@endsection

@push('page_js')
<script type="text/javascript">
$('#frmx').validate({
  errorElement: 'span',
  errorClass : 'roy-vali-error',
  ignore: [],
  rules: {

    no_of_question: {
      required: true
    },
    each_marks: {
      required: true
    },
    total_time: {
      required: true
    }
  }
});
</script>
@endpush