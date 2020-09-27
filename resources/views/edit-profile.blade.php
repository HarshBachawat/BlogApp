@extends('layouts.app')
@section('content')
  <div class="col-md-8 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h3>
            Profile Information
            <a href="{{ route('home') }}" class="btn btn-default btn-info float-right"><i class="fas fa-long-arrow-alt-left"></i></a>
          </h3>
        </div>
        <div class="card-body">
          <form id="edit_profile" name="edit_profile" method="post" action="{{ route('update-profile') }}" enctype="multipart/form-data" accept-charset="UTF-8">
            <input name="_method" type="hidden" value="PUT">
            @csrf
            <br>
            <div class="row">
              <div class="col-md-6">
                <img id="profile" src="{{ Auth::user()->profile_img ? Storage::url(Auth::user()->profile_img) : asset('images/avatar-3.jpg') }}" style="width: 100%; max-height: 100%; border: 1px solid black;" >
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <h6>Name:</h6>
                  <input type="text" name="name" id="name" value="{{Auth::user()->name}}" class="form-control">
                  <div id="name_error" style="display: none;" class="alert alert-danger">
                     <strong>Please Enter your Name</strong>
                   </div>
                </div>
                <br>
                <div class="form-group">
                  <h6>Email:</h6>
                  <input type="text" name="email" id="email" value="{{Auth::user()->email}}" class="form-control">
                  <div id="email_error" style="display: none;" class="alert alert-danger">
                     <strong>Please Enter your Email</strong>
                   </div>
                </div>
                <input type="file" name="profile_img" id="profile_img" value="" style="display: none;" class="form-control" accept="image/jpg, image/jpeg, image/png" onchange="readURL(this)">
                <br>
                <div class="form-group">
                  <h6>Description</h6>
                  <textarea class="form-control" id="description" name="description" rows="3" placeholder="">{{ Auth::user()->description }}</textarea>
                </div>
              </div>
            </div>
            <br>
          </form>
          <div class="inline-block">
            <input type="submit" name="submit" id="submit" form="edit_profile" value="Update Profile" class="btn btn-lg btn-success float-right">
            <a href="" data-toggle="modal" data-target="#passwordModal" class="btn btn-info btn-lg float-right mr-3" type="button"><i class="fas fa-key mr-3"></i>Change Password</a>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
     <div class="modal-dialog" role="document">
        <div class="modal-content">
           <div class="modal-header">
              <h5 class="modal-title" id="changePassword">
                 Change Password
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>
           <div class="modal-body">
            <form method="post" id="update-password" name="update-password" action="{{ route('update-password') }}">
              @csrf
              <div class="form-group">
                <label for="currentPassword" class="mr-2">Enter Current Password</label>
                <input type="password" class="form-control" name="currentPassword" id="currentPassword" placeholder="Current Password">
                <small id="currentPasswordHelp" class="text-danger" style="display: none;">Please Enter Your Current Password.</small>
              </div>
              <div class="form-group">
                <label for="newPassword" class="mr-2">Enter New Password</label>
                <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password">
                <small id="newPasswordHelp" class="text-danger" style="display: none;">Please Enter Your New Password.</small>
              </div>
              <div class="form-group">
                <label for="confirmPassword" class="mr-2">Re-enter New Password</label>
                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                <small id="confirmPasswordHelp" class="text-danger" style="display: none;">This Should Match Your New Password</small>
              </div>
            </form>
           </div>
           <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" form="update-password" value="Submit" name="submit" id="submit">
           </div>
        </div>
     </div>
  </div>

  <script type="text/javascript">

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#profile')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#profile').click(function(){ $('#profile_img').trigger('click'); });

    $('#edit_profile').submit(function() {

      $('#name_error').hide();
      $('#email_error').hide();

      if (! $('#name').val()) {
        $('#name_error').show();
        return false;
      }
      else if (! $('#email').val()) {
        $('#email_error').show();
        return false;
      }
      else {
        return true;
      }
    });

    $('#update-password').submit(function() {
        $('#currentPasswordHelp').hide();
        $('#newPasswordHelp').hide();
        $('#confirmPasswordHelp').hide();

        oldPass = $('#currentPassword').val();
        newPass = $('#newPassword').val();
        cnfPass = $('#confirmPassword').val();

        if (oldPass == '') {
          $('#currentPasswordHelp').show();
          return false;
        }
        else if (newPass == '') {
          $('#newPasswordHelp').show();
          return false;
        }
        else if (cnfPass != newPass) {
          $('#confirmPasswordHelp').show();
          return false;
        }
        return true;
    });
  </script>
@endsection