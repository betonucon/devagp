<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Barang;
use App\Models\Viewbarang;
use App\Models\TViewbarang;
use App\Models\MSDetailBarang;
use App\Models\Accesstoken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class ProdukController extends BaseController
{
    public function index(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        
        $query=TViewbarang::query();
        if($request->Nama_Barang!=""){
            $get=$query->where('nama_barang','LIKE','%'.$request->Nama_Barang.'%');
        }
        $get=$query->where('nama_barang','NOT LIKE','*%')->orderBy('nama_barang','Asc')->paginate(30);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
            $gdet=MSDetailBarang::where('satuan','!=','-')->where('kode_barang',$o->kode_barang)->get();
            
            $total=($o['harga']/$o->isi);
           $sub=[];
                $cl=[];
                $cl['KD_Barang'] =$o->kode_barang;
                $cl['Nama_Barang'] = $o->nama_barang;
                $cl['Nama_Divisi'] = $o->divisi;
                $cl['key'] = $o->ide_key;
                $cl['Satuan_jual'] = $o['satuan'];
                $cl['Isi'] = (int) $o->isi;
                $cl['Harga_Satuan_Jual'] = (int) $total;
                $cl['Satuan'] = $o['satuan'];
                $cl['harga'] = (int) no_decimal($o['harga']);
                $cl['keterangan'] = $o->keterangan;
                foreach($gdet as $no=>$ide){
                    $cl['Satuan'.$ide->urut] = $ide->satuan;
                }
                
                
                if($o->thumbnail!=null){
                    $cl['thumbnail'] = url_plug().'/_file_foto/'.$o->thumbnail;
                }else{
                    $cl['thumbnail'] = url_plug().'/_file_foto/example.png';
                }
                $foto=[];
                    if($o->jumlah_foto>0){
                        foreach(get_fotobarang($o->KD_Barang) as $no=>$ft){
                            $subfoto['foto']=url_plug().'/_file_foto/'.$ft->foto;
                            $foto[]=$subfoto;
                        }
                    }else{
                        $subfoto['foto']=url_plug().'/_file_foto/example.png';
                        $foto[]=$subfoto;
                    }
                    
                $cl['detail_foto'] = $foto;
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

}