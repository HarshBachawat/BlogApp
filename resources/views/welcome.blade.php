@php $sidebar = 1@endphp
@extends('layouts.app')

@section('content')
<div class="col-md-9">
    @foreach($blogs as $blog)
    <div class="case">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-8 d-flex">
                <a href="{{ route('single-blog',$blog->id) }}" class="img w-100 mb-3 mb-md-0" style="background-image: url({{ Storage::url($blog->cover_img) }});"></a>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4 d-flex">
                <div class="text w-100 pl-md-3">
                    <span class="subheading">{{$blog->category->title}}</span>
                    <h2><a href="{{ route('single-blog',$blog->id) }}">{{ $blog->title }}</a></h2>
                    {{-- <ul class="media-social list-unstyled">
            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
          </ul> --}}
                    <div class="meta">
                        <p class="mb-0"><a href="#">{{ Carbon\Carbon::parse($blog->created_at)->isoFormat('DD/MM/YYYY') }}</a> | <a href="#">{{$blog->author->name}}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="row mt-5">
      <div class="col text-center">
        <div class="block-27">
            {{ $blogs->links('partials.pagination') }}
          {{-- <ul>
            <li><a href="#">&lt;</a></li>
            <li class="active"><span>1</span></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">&gt;</a></li>
          </ul> --}}
        </div>
      </div>
    </div>
</div>
@endsection