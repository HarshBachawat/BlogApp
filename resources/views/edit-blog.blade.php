@extends('layouts.app')
@section('content')
  <div class="col-md-10 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3>
            Edit Blog
            <a href="{{ route('home') }}" class="btn btn-default btn-info float-right"><i class="fas fa-long-arrow-alt-left"></i></a>
          </h3>
        </div>
        <div class="card-body">
          <form id="edit_blog" name="edit_blog" method="post" action="{{ route('update-blog') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="id" id="id" value="{{ $blog->id }}">
            @csrf
            <br>
            <div class="form-group">
              <h6>Title</h6>
              <input type="text" name="title" id="title" value="{{$blog->title}}" class="form-control">
              <div id="title_error" style="display: none;" class="alert alert-danger">
                 <strong>Please Enter the Title</strong>
               </div>
            </div>
            <br>
            <div class="form-group">
              <h6>Cover Image</h6>
              <div class="row">
                <div class="col-lg-5">
                  <input type="file" name="cover_img" id="cover_img" value="" class="form-control" accept="image/jpg, image/jpeg, image/png" onchange="readURL(this)">
                </div>
                <div class="col-lg-7">
                  <img id="show_cover" src="{{ Storage::url($blog->cover_img) }}" alt="Cover Image" style="max-height: 400px; max-width: 100%">
                </div>
              </div>
            </div>
            <br>
            <div class="form-group form-inline">
              <h6 class="mr-4">Select Category</h6>
              <select class="selectpicker" id="category" name="category" value="">
                @php $categories = App\Category::all(); @endphp
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
              </select>
              <div id="category_error" style="display: none;" class="alert alert-danger">
                 <strong>Please Select a Category</strong>
               </div>
            </div>
            <br>
            <div class="form-group">
              <h6>Enter Content</h6>
              {{-- {!! Form::textarea('question_text', old('question_text'), ['class' => 'form-control question_text ckeditor', 'placeholder' => '', 'required']) !!} --}}
              <textarea class="form-control ckeditor" id="content" name="content" placeholder="">{!! $blog->content !!}</textarea>
              <div id="content_error" style="display: none;" class="alert alert-danger">
                <strong>Please Enter Some Text</strong>
              </div>
            </div>
            <br>
            <input type="submit" name="submit" id="submit" value="Update" class="btn btn-default btn-success float-right">
          </form>
        </div>
      </div>
  </div>
  <script type="text/javascript">

    $('.my-select').selectpicker();
    $('#category').val({{ $blog->category_id }});
    $('.selectpicker').selectpicker('refresh')

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#show_cover')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#edit_blog').submit(function() {

      $('#title_error').hide();
      $('#category_error').hide();
      $('#content_error').hide();

      if (! $('#title').val()) {
        $('#title_error').show();
        return false;
      }
      else if (! $('#category').val()) {
        $('#category_error').show();
        return false;
      }
      else if (! CKEDITOR.instances['content'].getData()) {
        $('#content_error').show();
        return false;
      }
      else {
        $('#content').val(CKEDITOR.instances['content'].getData());
        return true;
      }
});
  </script>
@endsection
@push('scripts')
<script src="{{ url('templateEditor/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" async src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/latest.js?config=TeX-MML-AM_CHTML"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style type="text/css">
  .bootstrap-select>.dropdown-toggle {
    width: 290px;
  }
</style>
@endpush