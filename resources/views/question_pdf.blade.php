<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Exam Records</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' 
  name='viewport'>
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans&subset=devanagari" rel="stylesheet">
    <style type="text/css">
    /** 
    Set the margins of the page to 0, so the footer and the header
    can be of the full height and width !
    **/
    @page {
        margin: 0cm 0cm;
    }
    /* *{ font-family: DejaVu Sans !important;} */
    /** Define now the real margins of every page in the PDF **/
    /* @font-face {
      font-family: 'DejaVu Sans';
      font-style: normal;
      font-weight: 400;
      src: url(http://localhost/exam/public/fonts/DejaVuSans.ttf) format('truetype');
    } */
    /* * {
        font-family: DejaVu Sans;
    } */
    * { font-family: Noto Sans, sans-serif; }
    body {
        margin-top: 110px;
        margin-left: 1cm;
        margin-right: 1cm;
        margin-bottom: 10px;
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 100px;        
    }
    /** Define the footer rules **/
    footer {
        position: fixed; 
        bottom: 0cm; 
        left: 0cm; 
        right: 0cm;
        height: 5px;
    }
    .pdf-container {
        padding: 5px;
    }
    .pdf-table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    .pdf-table td {
        border: 1px solid #ddd;
        padding: 5px;
        font-size: 10px;
    }
    .pdf-table th {
        border: 1px solid #ddd;
        padding: 5px;
        font-size: 11px;
        text-align: left;
        background-color: #e6e6e6;
    }
    .pdf-table2 {
        border-collapse: collapse;
        width: 100%;
    }
    .pdf-table2 td {
        border: 1px solid #ddd;
        padding: 5px;
        font-size: 14px;
    }
    .pdf-table2 th {
        border: 1px solid #ddd;
        padding: 5px;
        font-size: 14px;
        text-align: left;
        background-color: #e6e6e6;
    }
    </style>
</head>
<body>
<header style="background-color: #003366; color: #fff; text-align: center;">
    <div style="width: 48%; float: left; padding-left: 10px; text-align: left;">
        <h2><strong>Shree Career Academy</strong></h2>
    </div>
    <div style="width: 48%; float: right; text-align: right; padding: 10px; font-size: 12px;">
    @if(isset($userInfo) && !empty($userInfo))
        <label><strong>Name :</strong> {{ $userInfo->first_name . ' ' . $userInfo->last_name }}</label><br/>
        <label><strong>Email :</strong> {{ $userInfo->email_id }}</label><br/>
        <label><strong>Date :</strong> {{ date('d F, Y', strtotime($userInfo->created_at)) }}</label>
    @endif
    </div>
    <div style="clear:both;"></div>
</header>
<footer style="background-color: #003366;"></footer>
<main>     
    <div class="pdf-container">
        <table class="pdf-table2">
            <tr>
                <th style="width: 25%;">Subject : </th>
                <td>
                    @if(isset($subjectInfo) && !empty($subjectInfo)){{ $subjectInfo->name }}@endif
                    @if(isset($subject)){{ $subject }}@endif
                </td>
            </tr>
            <tr>
                <th>Attempts : </th>
                <td>{{ $attempts }} / {{ $total_question }}</td>
            </tr>
            <tr>
                <th>Marks Obtain : </th>
                <td>{{ $marks_obtain }} / {{ $total_marks }}</td>
            </tr>
            <tr>
                <th>Grade Obtain : </th>
                <td @if($grade_obtain == 'F') style="color: red;" @endif><b>{{ $grade_obtain }}</b></td>
            </tr>
        </table>
        @if(isset($questionQuery) && count($questionQuery))
            <div style="text-align: center; padding: 10px;">All Exam Questions</div>
            @foreach($questionQuery as $v)
            <div class="qtablebox" style="margin-top: 8px;">
                <table class="pdf-table">
                    <thead>
                        <tr>
                            <td>{!! strip_tags(html_entity_decode($v->name, ENT_QUOTES)) !!}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>
                            @if($v->op1 != '')<input type="radio" @if($v->candidate_answer == '1') checked="checked" @endif> {!! html_entity_decode($v->op1, ENT_QUOTES) !!} <br/>@endif
                            @if($v->op2 != '')<input type="radio" @if($v->candidate_answer == '2') checked="checked" @endif> {!! html_entity_decode($v->op2, ENT_QUOTES) !!} <br/>@endif
                            @if($v->op3 != '')<input type="radio" @if($v->candidate_answer == '3') checked="checked" @endif> {!! html_entity_decode($v->op3, ENT_QUOTES) !!} <br/>@endif
                            @if($v->op4 != '')<input type="radio" @if($v->candidate_answer == '4') checked="checked" @endif> {!! html_entity_decode($v->op4, ENT_QUOTES) !!} <br/>@endif
                            @if($v->op5 != '')<input type="radio" @if($v->candidate_answer == '5') checked="checked" @endif> {!! html_entity_decode($v->op5, ENT_QUOTES) !!} <br/>@endif
                            @if($v->op6 != '')<input type="radio" @if($v->candidate_answer == '6') checked="checked" @endif> {!! html_entity_decode($v->op6, ENT_QUOTES) !!} <br/>@endif
                        </td></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                @if($v->candidate_answer_status == '0') Answer : <span style="color: #e0180e;"><strong>Incorrect</strong></span> @endif
                                @if($v->candidate_answer_status == '1') Answer : <span style="color: #046f20;"><strong>Correct</strong></span> @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                @if($v->answer == 1) <span style="color: #046f20;"><strong>Correct Answer :</strong></span> {{ $v->op1 }} @endif
                                @if($v->answer == 2) <span style="color: #046f20;"><strong>Correct Answer :</strong></span> {{ $v->op2 }} @endif
                                @if($v->answer == 3) <span style="color: #046f20;"><strong>Correct Answer :</strong></span> {{ $v->op3 }} @endif
                                @if($v->answer == 4) <span style="color: #046f20;"><strong>Correct Answer :</strong></span> {{ $v->op4 }} @endif
                                @if($v->answer == 5) <span style="color: #046f20;"><strong>Correct Answer :</strong></span> {{ $v->op5 }} @endif
                                @if($v->answer == 6) <span style="color: #046f20;"><strong>Correct Answer :</strong></span> {{ $v->op6 }} @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @endforeach
        @endif
    </div>
</main>
</body>
</html>
