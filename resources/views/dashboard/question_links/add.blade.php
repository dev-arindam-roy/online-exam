@extends('dashboard.layouts.app')

@push('page_css')
<link rel="stylesheet" href="{{ asset('public/assets/jquery_ui/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<style type="text/css">

</style>
@endpush


@section('content_header')
<section class="content-header">
  <h1>
    @if( isset($link) ) Edit Link @else Create Link @endif
    <!--small>it all starts here</small-->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('links') }}">All Links</a></li>
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
          <h3 class="box-title">@if( isset($link) ) Edit Link @else Create Link @endif</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form name="frm" id="frmx" action="@if( isset($link) ){{ route('updLink', array('id' => $link->id)) }}@else{{ route('svelinks') }}@endif" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                {{ url('/') }}/exam-links/ <br/>
                <code>Don't Use Blank Space, Only use small char & hyphen Example : my-new-question-link</code>
                <input type="text" name="link" class="form-control" placeholder="Enter Link Name" @if( isset($link) ) value="{{ $link->link }}" readonly="readonly" @endif>
                <br/><span id="link_disp"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <span>Date :</span>
                <input type="text" name="start_date" class="form-control datepicker" placeholder="Select Start Date" autocomplete="off" @if( isset($link) ) value="{{ date('d-m-Y', strtotime($link->start_date)) }}" @endif>
              </div>
            </div>
            @php
            $nowDateTime = Carbon\Carbon::now();
            //$nowTime = $nowDateTime->toTimeString();
            $start_time = $nowDateTime->format('g:i A');
            $addTime = $nowDateTime->addHours(2);
            $end_time = $addTime->format('g:i A');
            @endphp
            <div class="col-md-3">
              <div class="form-group">
                <span>Start Time :</span>
                <input type="text" name="start_time" class="form-control timepicker" placeholder="Select Start Time" autocomplete="off" @if( isset($link) ) value="{{ date('g:i A', strtotime($link->start_time)) }}" @else value="@if( isset($start_time) ){{ $start_time }}@endif" @endif>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <span>End Time :</span>
                <input type="text" name="end_time" class="form-control timepicker" placeholder="Select end Date" autocomplete="off" @if( isset($link) ) value="{{ date('g:i A', strtotime($link->end_time)) }}" @else value="@if( isset($end_time) ){{ $end_time }}@endif" @endif>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <span>Login Username :</span>
              <input type="text" name="username" class="form-control" placeholder="Username" value="@if( isset($link) ){{ $link->username }}@endif">
            </div>
            <div class="col-md-3">
              <span>Login Password :</span>
              <input type="text" name="password" class="form-control" placeholder="Password" value="@if( isset($link) ){{ $link->password }}@endif">
            </div>
          </div>
          <div class="row" style="margin-top: 10px;">
            <div class="col-md-6">
              <input type="submit" class="btn btn-primary" @if( isset($link) ) value="Save Changes" @else value="Create Link" @endif>
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
<script src="{{ asset('public/assets/jquery_ui/jquery-ui.js') }}"></script>
<script src="{{ asset('public/assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript">
$( function() {
  $( ".datepicker" ).datepicker({
      minDate:0,
      dateFormat: 'dd-mm-yy',
      changeMonth: true,
      changeYear: true
  });
  //http://jdewit.github.io/bootstrap-timepicker/
  $('.timepicker').timepicker({
    showInputs: false,
    //defaultTime: false
  });
  $('input[name="link"]').on('blur', function() {
    var lk = "{{ url('/') }}";
    if( $.trim( $(this).val() ) != '' ) {
      $('input[name="link"]').val( string_to_slug($(this).val()) );
      $('#link_disp').html( lk + '/exam-links/' + string_to_slug($(this).val()) );
    } else {
      $('input[name="link"]').val('');
      $('#link_disp').html('');
    }
  });
} );
$('#frmx').validate({
  errorElement: 'span',
  errorClass : 'roy-vali-error',
  ignore: [],
  normalizer: function( value ) {
    return $.trim( value );
  },
  rules: {

    link: {
      required: true,
      nowhitespace: true,
      pattern: /^[A-Za-z\d-.]+$/
    },
    start_date: {
      required: true
    },
    start_time: {
      required: true
    },
    end_time: {
      required: true
    },
    username: {
      required: true
    },
    password: {
      required: true
    }
  },
  messages: {
    link: {
      required: 'Please enter link unique name',
      nowhitespace: 'Please remove blank space',
      pattern: 'Please use only hyphen'
    }
  }
});
function string_to_slug(str) {
  str = str.replace(/^\s+|\s+$/g, ""); // trim
  str = str.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to = "aaaaaaeeeeiiiioooouuuunc------";

  for (var i = 0, l = from.length; i < l; i++) {
    str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
  }

  str = str
    .replace(/[^a-z0-9 -]/g, "") // remove invalid chars
    .replace(/\s+/g, "-") // collapse whitespace and replace by -
    .replace(/-+/g, "-") // collapse dashes
    .replace(/^-+/, "") // trim - from start of text
    .replace(/-+$/, ""); // trim - from end of text

  return str;
}
</script>
@endpush