<div id="top">
<nav class="navbar navbar-inverse navbar-fixed-top " style="padding-top: 10px;">
    <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs" data-toggle="collapse" href="#menu" id="menu-toggle">
        <i class="icon-align-justify"></i>
    </a>
    <header class="navbar-header">
        <a href="{{url('/')}}" class="navbar-brand">
            <h2 class="media-heading"> PT. CAR</h2>    
        </a>
    </header>
    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="icon-user "></i>&nbsp; <i class="icon-chevron-down "></i>
            </a>

            <ul class="dropdown-menu dropdown-user">
                <li><button class="btn-md btn" style="background: none; padding-left: 18px;" data-toggle="modal" data-target=".bd-example-modal-sm-active"><i class="icon-user"></i> Ubah Password </button>
                </li>
                
                <li class="divider"></li>
                <li><a href="{{ url('/logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();"><i class="icon-signout"></i> <span>Logout</span></a></li>
                </li>
            </ul>

        </li>
        <!--END ADMIN SETTINGS -->
    </ul>
</nav>
</div>
<!-- MODAL -->
<div class="modal fade bd-example-modal-sm-active" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Ubah Password</h3>
        </div>
        <form action="{{url('/')}}/backend/userprofile/{{Auth::user()->id}}" method="POST">
          {{csrf_field()}}
            <div class="modal-body">
                <div class="form-group">
                    <label for="text1" class="control-label col-md-4">Password Baru <span style="color: red;font-size: 19px"><b>*</b></span></label>
                    <div class="col-lg-8">
                        <input type="password" name="password" placeholder="Input Password Baru" class="form-control" required="true"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-flat btn-sm btn-primary" >Simpan</button>
                <a href="#" class="btn btn-danger btn-flat btn-sm" data-dismiss="modal">Close</a>
            </div>
        </form>
      </div>
    </div>
</div>
<!-- END MODAL -->