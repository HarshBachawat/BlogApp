@extends('layouts.app')

@section('content')
<div class="col-md-9">
    <h2 style="text-align: center;">My Blogs</h2>
    <br>
    @foreach(Auth::user()->blogs as $blog)
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
                    <div class="inline-block" style="margin-top: 60px">
                        <a href="{{ route('delete-blog',$blog->id) }}" onclick="return confirm('Are you sure you want to Delete this Blog')" class="btn btn-lg btn-danger float-right">Delete</a>
                        <a href="{{ route('edit-blog',$blog->id) }}" class="btn btn-lg btn-info float-right mr-3">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection