<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTecnicaProduccion extends Model
{
    use HasFactory;
    protected $connection = 'mysql_intranet';

    protected $table = 'ficha_tecnica_produccion';
    protected $primaryKey = 'id_ft_produccion';

    public $timestamps = false;

    protected $fillable = [
        'cod_ft_produccion',
        'modelo',
        'nom_img_ft_produccion',
        'img_ft_produccion',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    
    public function user()
    {
        return $this->belongsTo(UserIntranet::class, 'user_reg', 'id_usuario');
    }
}
