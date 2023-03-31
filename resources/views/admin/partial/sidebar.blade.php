<div class="media user-media well-small">
    <a class="user-link" href="#">
        <img class="media-object img-thumbnail user-img" alt="User Picture" src="/assets/img/user.gif" />
    </a>
    <br />
    <div class="media-body">
        <b class="media-heading"> {{limitWord(Auth::user()->name,2)}}</b>
        <ul class="list-unstyled user-info">
            <li>
                 <a class="btn btn-success btn-xs btn-circle" style="width: 10px;height: 12px;"></a> Online
            </li>
        </ul>
    </div>
    <br />
</div>
<ul id="menu" class="collapse">
    <li class="panel active">
        <a href="{{url('')}}" >
            <i class="icon-table"></i> Dashboard
        </a>                   
    </li>
    @role('Super Admin')
    <li class="panel ">
        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav">
            <i class="icon-tasks"> </i> Jadwal Kerja
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
        </a>
        <ul class="collapse" id="component-nav">
            <li class=""><a href="{{url('/')}}/backend/jadwal/shift"><i class="icon-angle-right"></i> Jadwal Shift </a></li>
             <li class=""><a href="{{url('/')}}/backend/jadwal/nonshift"><i class="icon-angle-right"></i> Jadwal Non Shift </a></li>
            <!-- <li class=""><a href="{{url('/')}}/backend/rubah/jadwal"><i class="icon-angle-right"></i> Rubah Jadwal </a></li> -->
        </ul>
    </li>
    @endrole
	<li class="panel ">
        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav-cuti">
            <i class="icon-tasks"> </i> Cuti
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
        </a>
        <ul class="collapse" id="component-nav-cuti">
            <li class=""><a href="{{url('/')}}/backend/cuti/pengajuan_cuti"><i class="icon-angle-right"></i>Pengajuan Cuti</a></li>
            <li class=""><a href="{{url('/')}}/backend/cuti/data_cuti"><i class="icon-angle-right"></i>Approve Cuti</a></li>
        </ul>
    </li>
    <li class="panel ">
        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav-ijin">
            <i class="icon-tasks"> </i> Ijin
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
        </a>
        <ul class="collapse" id="component-nav-ijin">
           <li class=""><a href="{{url('/')}}/backend/ijin/pengajuan_ijin"><i class="icon-angle-right"></i>Pengajuan Ijin</a></li>
           <li class=""><a href="{{url('/')}}/backend/ijin/data_ijin"><i class="icon-angle-right"></i>Approve Ijin</a></li>
        </ul>
    </li>
	<li class="panel ">
        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav-lembur">
            <i class="icon-tasks"> </i> Lembur
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
        </a>
        <ul class="collapse" id="component-nav-lembur">
            <li class=""><a href="{{url('/')}}/backend/lembur/pengajuan_lembur"><i class="icon-angle-right"></i>Pengajuan Lembur</a></li>
            <li class=""><a href="{{url('/')}}/backend/lembur/data_lembur"><i class="icon-angle-right"></i>Approve Lembur</a></li>
        </ul>
    </li>
	@role('Super Admin')
    <li class="panel"><a href="{{url('/')}}/backend/report/upload_absensi"><i class="icon-columns"></i> Upload Absensi </a></li>
    @endrole
    <li class="panel ">
        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav-report">
            <i class="icon-tasks"> </i> Report
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
        </a>
        <ul class="collapse" id="component-nav-report">
            <li class=""><a href="{{url('/')}}/backend/report/report_absensi"><i class="icon-angle-right"></i>Absensi</a></li>
            @role('Super Admin')
            <li class=""><a href="{{url('/')}}/backend/report/report_umut"><i class="icon-angle-right"></i>UT & UM</a></li>
            <li class=""><a href="{{url('/')}}/backend/report/report_cuti"><i class="icon-angle-right"></i>Cuti</a></li>
            <li class=""><a href="{{url('/')}}/backend/rekap/rekap_lembur"><i class="icon-angle-right"></i>Lembur</a></li>
            <li class=""><a href="{{url('/')}}/backend/report/report_ijin"><i class="icon-angle-right"></i>Ijin</a></li>
            @endrole
        </ul>
    </li>
    @role('Super Admin')
    <li class="panel ">
        <a href="#" data-parent="#menu" data-toggle="collapse" class="accordion-toggle" data-target="#component-nav-setting">
            <i class="icon-cogs"> </i> Setting
            <span class="pull-right">
              <i class="icon-angle-left"></i>
            </span>
        </a>
        <ul class="collapse" id="component-nav-setting">
            <li class=""><a href="{{url('/')}}/backend/karyawan"><i class="icon-angle-right"></i>Master Karyawan</a></li>
            <li class=""><a href="{{url('/')}}/backend/mst/department"><i class="icon-angle-right"></i>Master Department</a></li>
            <li class=""><a href="{{url('/')}}/backend/biaya"><i class="icon-angle-right"></i>Master Biaya</a></li>
            <li class=""><a href="{{url('/')}}/backend/harilibur"><i class="icon-angle-right"></i>Master Hari Libur</a></li>
            <li class=""><a href="{{url('/')}}/backend/mst/jadwal/shift"><i class="icon-angle-right"></i>Master Jadwal Shift</a></li>
        </ul>
    </li>
    @endrole
    <li><a href="{{ url('/logout') }}"
                      onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();"><i class="icon-signout"></i> <span>Logout</span></a></li>
</ul>