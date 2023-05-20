<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Mdivisi;
use App\Models\Accesstoken;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Testapi;
use App\Models\Viewbarang;
use App\Models\Barang;
use App\Models\MSBarang;
use App\Models\MSDetailBarang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class CroneController extends BaseController
{
    public function barang(request $request)
    {
        $data=Viewbarang::get();
        foreach($data as $o){
            if((int) $o->Spec>0){
                $isi=(int) $o->Spec;
            }else{
                $isi=1;
            }
            $save=MSBarang::UpdateOrcreate([
                'kode_barang'=>$o->KD_Barang,
            ],[
                'nama_barang'=>$o->Nama_Barang,
                'kd_divisi'=>$o->kd_divisi,
                'ide_key'=>$o->hargamunculsatuanke,
                'nama_barang'=>$o->Nama_Barang,
                'keterangan'=>$o->keterangan,
                'spec'=>$o->Spec,
                'isi'=>$isi,
                'photo'=>null,
            ]);
            for($x=1;$x<5;$x++){
                $harga=no_decimal($o['harga_ke'.$x]);
                if($x==1){
                    $satuan=$o['Satuan4'];
                }
                if($x==2){
                    $satuan=$o['Satuan3'];
                }
                if($x==3){
                    $satuan=$o['Satuan2'];
                }
                if($x==4){
                    $satuan=$o['Satuan1'];
                }
                
                $save=MSDetailBarang::UpdateOrcreate([
                    'kode_barang'=>$o->KD_Barang,
                    'urut'=>$x,
                ],[
                    'satuan'=>$satuan,
                    'harga'=>$harga,
                ]);
            }
        }
    }


}