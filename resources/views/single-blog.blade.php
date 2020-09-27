@php $sidebar=1; @endphp
@extends('layouts.app')
@section('content')
  <div class="col-md-9 ftco-animate">
      <div>
        <h1 style="text-align: center;">{{ $blog->title }}</h1>
        <div class="row mb-2">
          <div class="col-sm-1">
            @if($blog->author->profile_img)
            <img alt="" src="{{ Storage::url($blog->author->profile_img) }}" style="max-width: 49px; max-height: 49px;">
            @else
            <img alt="" src="{{ asset('images/avatar-3.png') }}" style="max-width: 49px; max-height: 49px;">
            @endif
          </div>
          <div class="col-sm-6" style="vertical-align: middle;">
            <a href="#">{{ $blog->author->name }}</a>
            <div><a href="#">{{ Carbon\Carbon::parse($blog->created_at)->isoFormat('MMM DD, YYYY') }}</a> <!-- -->·<!-- --> <!-- -->{{$blog->category->title}}</div>
          </div>
        </div>
      </div>
      <img src="{{ Storage::url($blog->cover_img) }}" style="width: 100%" alt="" class="img-fluid mb-5">
      <br>
      {!! $blog->content !!}
  </div>
  <script type="text/javascript">
    setTimeout(function(){
      MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
    }, 500);
  </script>
@endsection
@push('scripts')
<script type="text/javascript" defer src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML"></script>
@endpush