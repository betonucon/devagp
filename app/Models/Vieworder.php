<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vieworder extends Model
{
    use HasFactory;
    protected $table = 'view_order_produk';
    protected $guarded = ['id'];
    public $timestamps = false;
    // function mjabatan(){
    //     return $this->belongsTo('App\Models\Jabatan','jabatan_id','id');
    // }
    // function mgroup(){
    //     return $this->belongsTo('App\Models\Group','group_id','id');
    // }
    // function mpendidikan(){
    //     return $this->belongsTo('App\Models\Pendidikan','pendidikan_id','id');
    // }
}
