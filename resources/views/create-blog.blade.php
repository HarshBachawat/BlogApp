@extends('layouts.app')
@section('content')
  <div class="col-md-8 ftco-animate">
      <div>
      	<div class="form-group">
      	  <h6>Enter Content</h6>
      	  {{-- {!! Form::textarea('question_text', old('question_text'), ['class' => 'form-control question_text ckeditor', 'placeholder' => '', 'required']) !!} --}}
      	  <textarea class="form-control ckeditor" placeholder=""></textarea>
      	  <div id="question_text_error" hidden class="alert alert-danger">
      	    <strong>Please Enter Question Text</strong>
      	  </div>
      	</div>
      </div>
  </div>
@endsection
@push('scripts')
<script src="{{ url('templateEditor/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML"></script>
@endpush