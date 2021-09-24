@extends('dashboard.layouts.app')



@section('content_header')
<section class="content-header">
  <h1>
    @if(isset($subject))
    Edit Subject
    @else
    Add New Subject
    @endif
    <!--small>it all starts here</small-->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('sub_list') }}">All Subjects</a></li>
    @if(isset($subject))
    <li class="active">Edit Subject</li>
    @else
    <li class="active">Add New Subject</li>
    @endif
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
      <a href="{{ route('sub_list') }}" class="btn btn-primary"> All Subjects</a>
    </div>
    <div class="col-md-6">
    </div>
  </div>
  <div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">@if(isset($subject)) Edit Subject @else Add New Subject @endif</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form name="frm" id="frmx" action="@if( isset($subject) ){{ route('upd_sub', array('id' => $subject->id)) }}@else{{ route('sve_sub') }}@endif" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Select Language : <em>*</em></label>
                <select name="language_id" class="form-control">
                  <option value="">-Select Language For Subject-</option>
                  @if( isset($languages) )
                    @foreach( $languages as $lng )
                    <option value="{{ $lng->id }}" @if( isset($subject) && $subject->language_id == $lng->id ) selected="selected" @endif>{!! html_entity_decode($lng->name, ENT_QUOTES) !!}</option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                <label>Subject Name or Title : <em>*</em></label>
                <input type="text" name="name" class="form-control" placeholder="Enter Subject Name or Title" value="@if(isset($subject)){!! html_entity_decode($subject->name, ENT_QUOTES) !!}@endif">
              </div>
              <div class="form-group">
                <label>Subject Details : </label>
                <textarea name="description" id="description" class="form-control">@if(isset($subject)){!! html_entity_decode($subject->description, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="form-group">
                <label>Status :</label>
                <input type="radio" name="status" value="1" @if(isset($subject)) @if($subject->status == '1') checked="checked" @endif @else checked="checked" @endif> Active
                <input type="radio" name="status" value="2" @if(isset($subject) && $subject->status == '2') checked="checked" @endif> Inactive
              </div>
              <div class="form-group">
                @if(isset($subject))
                <input type="submit" class="btn btn-primary" value="Save Changes">
                @else
                <input type="submit" class="btn btn-primary" value="Add Subject">
                @endif
              </div>
            </div>
            <div class="col-md-4">
              
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
<script src="{{ asset('public/assets/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'description', {
  height : 250,
  resize_enabled : false,
  extraPlugins : 'wordcount',
  wordcount : {
    showCharCount : true,
  },
  toolbarGroups : [
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    { name: 'styles', groups: [ 'styles' ] },
    { name: 'colors', groups: [ 'colors' ] },
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] }
  ],

  removeButtons : 'Save,NewPage,Templates,Print,Cut,Copy,Paste,PasteText,PasteFromWord,SelectAll,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,Language,Anchor,Flash,Iframe,About,Find,Replace,Scayt,Blockquote,CreateDiv,Outdent,Indent,BidiLtr,BidiRtl,Smiley,SpecialChar,PageBreak,CopyFormatting,RemoveFormat,ShowBlocks,Strike',
  
} );

$('#frmx').validate({
  errorElement: 'span',
  errorClass : 'roy-vali-error',
  ignore: [],
  rules: {

    name: {
      required: true,
      minlength: 3
    },
    language_id: {
      required: true
    }
  },
  messages: {

    name: {
      required: 'Please Enter Subject Name or Title.'
    },
    language_id: {
      required: 'Please Select Language.'
    }
  }
});
</script>
@endpush