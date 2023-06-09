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
                    serverSide: true,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('barang/getdata')}}",
                      columns: [
                        { data: 'KD_Barang', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'kode_barang' },
                        { data: 'nama_barang' },
                        { data: 'divisi' },
                        { data: 'uang_harga' },
                        { data: 'satuan' },
                        { data: 'count_foto' },
                        
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

        function pilih_jenis(KD_Divisi){
          var tables=$('#data-table-fixed-header').DataTable();
          tables.ajax.url("{{ url('barang/getdata')}}?KD_Divisi="+KD_Divisi).load();
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
        Mst Barang
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barang</li>
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
                  <p id="count_data">Total Data : {{count_barang()}}</p>
                  
              </div>
              
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Divisi</label>
                  <select onchange="pilih_jenis(this.value)" class="form-control  input-sm">
                    <option value="">All Data</option>
                    @foreach(get_divisi() as $kd)
                      <option value="{{$kd->KD_Divisi}}">[{{$kd->KD_Divisi}}] {{$kd->Nama_Divisi}}</option>
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
                <table id="data-table-fixed-header" class="display">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="5%"></th>
                            <th width="13%">KD Barang</th>
                            <th>Nama Barang</th>
                            <th width="15%">Divisi</th>
                            <th width="9%">Harga Jual</th>
                            <th width="9%">Satuan Jual</th>
                            <th width="7%">J.Foto</th>
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
    <div class="modal modal-primary fade" id="modal-foto">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body" style="background-color: #bccdd7 !important;">
            <div class="row">
              <div class="col-md-12">
                <div id="foto"></div>
              </div>
              
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
@endsection

@push('ajax')
    <script>
        function view_barang(img){
          $('#modal-foto .modal-title').html('Thumbnail');
          $('#modal-foto').modal('show');
          $('#foto').html('<img src="'+img+'" width="100%" height="400px">');
        }
    </script>
@endpush
