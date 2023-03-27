@extends('layouts.app')

@push('style')
  <style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: normal;
    }
  </style>
@endpush
@push('datatable')
<script type="text/javascript">
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#data-table-fixed-header').length !== 0) {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20,50,100],
                    searching:true,
                    lengthChange:false,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('customermobile/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'kode_customer' },
                        { data: 'nama_customer' },
                        { data: 'email' },
                        { data: 'Nama_Propinsi' },
                        { data: 'Nama_Kabupaten' },
                        { data: 'phone' },
                        { data: 'akun' },
                        
                      ],
                      
                });
                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })

                
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        function pilih_jenis(Kd_Propinsi){
          var tables=$('#data-table-fixed-header').DataTable();
          tables.ajax.url("{{ url('customermobile/getdata')}}?Kd_Propinsi="+Kd_Propinsi).load();
          tables.on( 'draw', function () {
              var count=tables.data().count();
                $('#count_data').html('Total data :'+count)  
          } );
              
        }

        $(document).ready(function() {
          TableManageFixedHeader.init();
               
        });

        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales Order Request
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales Order Request</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label>Total Data</label><br>
                  <p id="count_data">Total Data : {{count_Customer()}}</p>
                  
              </div>
              
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Provinsi</label>
                  <select onchange="pilih_jenis(this.value)" class="form-control  input-sm">
                    <option value="">All Data</option>
                    @foreach(get_provinsi() as $kd)
                      <option value="{{$kd->Kd_Propinsi}}">{{$kd->Nama_Propinsi}}</option>
                    @endforeach
                  </select>
               
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label>Cari data</label>
                  <input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
                  
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
           
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="data-table-fixed-header" style="width:120%"class="display">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="5%"></th>
                            <th width="11%">KD-Customer</th>
                            <th>Nama Customer</th>
                            <th width="15%">Email</th>
                            <th width="8%">Provinsi</th>
                            <th width="12%">Kota</th>
                            <th width="9%">Handphone</th>
                            <th width="9%">Status</th>
                        </tr>
                    </thead>
                      
                </table>
              </div>
            </div>
            
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          d
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
@endsection

@push('ajax')
    <script>
      function tutup_user(users_id){
           
           swal({
             title: "Tutup Akun ?",
             text: "proses tutup akun customer",
             type: "info",
             icon: "info",
             showCancelButton: true,
             align:"center",
             confirmButtonClass: "btn-danger",
             confirmButtonText: "Yes, delete it!",
             closeOnConfirm: false
           }).then((willDelete) => {
             if (willDelete) {
                 $.ajax({
                   type: 'GET',
                   url: "{{url('customermobile/tutup_user')}}",
                   data: "users_id="+users_id,
                   success: function(msg){
                     swal("Success! berhasil dicreate!", {
                       icon: "success",
                     });
                     var table=$('#data-table-fixed-header').DataTable();
                     table.ajax.url("{{ url('customermobile/getdata')}}").load();
                   }
                 });
               
               
             } else {
               
             }
           });
           
         }

        function open_user(users_id){
           
           swal({
             title: "Buka / Aktifkan Akun ?",
             text: "proses aktifkan akun customer",
             type: "info",
             icon: "info",
             showCancelButton: true,
             align:"center",
             confirmButtonClass: "btn-danger",
             confirmButtonText: "Yes, delete it!",
             closeOnConfirm: false
           }).then((willDelete) => {
             if (willDelete) {
                 $.ajax({
                   type: 'GET',
                   url: "{{url('customermobile/open_user')}}",
                   data: "users_id="+users_id,
                   success: function(msg){
                     swal("Success! berhasil dicreate!", {
                       icon: "success",
                     });
                     var table=$('#data-table-fixed-header').DataTable();
                     table.ajax.url("{{ url('customermobile/getdata')}}").load();
                   }
                 });
               
               
             } else {
               
             }
           });
           
         }
    </script>
@endpush
