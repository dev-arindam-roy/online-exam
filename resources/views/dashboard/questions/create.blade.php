@extends('dashboard.layouts.app')



@section('content_header')
<section class="content-header">
  <h1>
    @if(isset($question))
    Edit Question
    @else
    Add New Question
    @endif
    <!--small>it all starts here</small-->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('ques_list') }}">All Questions</a></li>
    @if(isset($question))
    <li class="active">Edit Question</li>
    @else
    <li class="active">Add New Question</li>
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
      <a href="{{ route('ques_list') }}" class="btn btn-primary"> All Questions</a>
    </div>
    <div class="col-md-6">
    </div>
  </div>
  <div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">@if(isset($question)) Edit Question @else Add New Question @endif</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <form name="frm" id="frmx" action="@if( isset($question) ){{ route('upd_ques', array('id' => $question->id)) }}@else{{ route('sve_ques') }}@endif" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Select Language : <em>*</em></label>
                <select name="language_id" class="form-control">
                  <option value="">-Select Language For Subject-</option>
                  @if( isset($languages) )
                    @foreach( $languages as $lng )
                    <option value="{{ $lng->id }}" 
                      @if( isset($_GET['lng']) && base64_decode( $_GET['lng'] ) == $lng->id) selected="selected" @endif 
                      @if( isset($question) && $question->language_id == $lng->id ) selected="selected" @endif>
                      {!! html_entity_decode($lng->name, ENT_QUOTES) !!}
                    </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Select Subject : <em>*</em></label>
                <select name="subject_id" class="form-control">
                  <option value="">-Select Subject For Question-</option>
                  @if( isset($subjects) )
                    @foreach( $subjects as $sub )
                    <option value="{{ $sub->id }}" 
                      @if( isset($_GET['sub']) && base64_decode( $_GET['sub'] ) == $sub->id) selected="selected" @endif
                      @if( isset($question) && $question->subject_id == $sub->id ) selected="selected" @endif>
                      {!! html_entity_decode($sub->name, ENT_QUOTES) !!}
                    </option>
                    @endforeach
                  @endif
                </select>
              </div>
            </div>
          </div>
          @if( isset($_GET['lng']) && isset($_GET['sub']) )
          <div class="row">
            <div class="col-md-12">
              <div class="notice notice-danger">
                <strong>Language & Subject Set Already.</strong> Again You Can Add More Question On Selected Language and Subject.
                If You Want, You Can Change Both.
              </div>
            </div>
          </div>
          @endif
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                <label>Question : <em>*</em></label>
                <textarea name="name" id="ques" class="form-control" data-error-container="#ques_error">@if( isset($question) ){!! html_entity_decode($question->name, ENT_QUOTES) !!}@endif</textarea>
                <div id="ques_error"></div>
              </div>
              <div class="form-group">
                <label>Do You Want To Upload Any Image For This Question ?</label>
                <input type="checkbox" id="isImage" name="is_image" value="1" @if( isset($question) && $question->is_image == '1') checked="checked" @endif> <span>Yes, Want To Upload.</span>
              </div>
              <div class="form-group" @if( isset($question) && $question->is_image != '1') style="display: none;" @endif @if( !isset($question) ) style="display: none;" @endif id="imgDiv">
                <label>Upload Image File :</label>
                <input type="file" name="image" id="imgFile" accept="image/*">
              </div>
              @if( isset($question) && $question->is_image == '1' && $question->image != '' && $question->image != null )
              <div class="form-group">
                <img src="{{ asset('public/uploads/question_images/thumb/'. $question->image) }}"  class="img-thumbnail">
              </div>
              @endif
              <div class="form-group">
                <div class="notice notice-info">
                  <strong>Minimum 2 Options Required.</strong> Multiple Optional Answers Entry System Showing Below.
                </div>
              </div>
              <div class="form-group">
                <label>Option Number 1 : <em>*</em></label>
                <textarea name="op1" class="form-control">@if( isset($question) ){!! html_entity_decode($question->op1, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="form-group">
                <label>Option Number 2 : <em>*</em></label>
                <textarea name="op2" class="form-control">@if( isset($question) ){!! html_entity_decode($question->op2, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="form-group">
                <label>Option Number 3 : </label>
                <textarea name="op3" class="form-control">@if( isset($question) ){!! html_entity_decode($question->op3, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="form-group">
                <label>Option Number 4 : </label>
                <textarea name="op4" class="form-control">@if( isset($question) ){!! html_entity_decode($question->op4, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="form-group">
                <label>Option Number 5 : </label>
                <textarea name="op5" class="form-control">@if( isset($question) ){!! html_entity_decode($question->op5, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="form-group">
                <label>Option Number 6 : </label>
                <textarea name="op6" class="form-control">@if( isset($question) ){!! html_entity_decode($question->op6, ENT_QUOTES) !!}@endif</textarea>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Set Correct Answer :<em>*</em></label>
                    <select name="answer" class="form-control">
                      <option value="">-Select Correct Answer-</option>
                      <option value="1" @if( isset($question) && $question->answer == '1' ) selected="selected" @endif>Option Number 1</option>
                      <option value="2" @if( isset($question) && $question->answer == '2' ) selected="selected" @endif>Option Number 2</option>
                      <option value="3" @if( isset($question) && $question->answer == '3' ) selected="selected" @endif>Option Number 3</option>
                      <option value="4" @if( isset($question) && $question->answer == '4' ) selected="selected" @endif>Option Number 4</option>
                      <option value="5" @if( isset($question) && $question->answer == '5' ) selected="selected" @endif>Option Number 5</option>
                      <option value="6" @if( isset($question) && $question->answer == '6' ) selected="selected" @endif>Option Number 6</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Question Status :</label>
                    <select name="status" class="form-control">
                      <option value="1" @if( isset($question) && $question->status == '1' ) selected="selected" @endif>Active</option>
                      <option value="2" @if( isset($question) && $question->status == '2' ) selected="selected" @endif>Inactive</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                @if(isset($question))
                <input type="submit" class="btn btn-primary" value="Save Changes">
                @else
                <input type="submit" class="btn btn-primary" value="Add Question">
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
var editor = CKEDITOR.replace( 'ques', {
  height : 160,
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

$( function() {
  $('#isImage').on('click', function() {
    if( $(this).is(':checked') ) {
      $('#imgDiv').slideDown();
    } else {
      $('#imgFile').val('');
      $('#imgDiv').hide();
    }
  });
});
var fm = $('#frmx');
fm.on('submit', function() {
  CKEDITOR.instances.ques.updateElement();
});
fm.validate({
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
    },
    subject_id: {
      required: true
    },
    op1: {
      required: true
    },
    op2: {
      required: true
    },
    answer: {
      required: true
    },
    image: {
      required: "#isImage:checked"
    }
  },
  messages: {

    name: {
      required: 'Please Enter Question.'
    },
    language_id: {
      required: 'Please Select Language.'
    },
    subject_id: {
      required: 'Please Select Subject.'
    },
    op1: {
      required: 'Please Add Option Number 1.'
    },
    op2: {
      required: 'Please Add Option Number 2.'
    },
    answer: {
      required: 'Please Select Correct Option Number.'
    },
    image: {
      required: 'Please Upload Image File.',
      accept: 'Please Select Only Image File.'
    }
  },
  errorPlacement: function(error, element) {
    if (element.attr("data-error-container")) { 
      error.appendTo(element.attr("data-error-container"));
    } else {
      error.insertAfter(element); 
    }
  }
});
</script>
@endpush