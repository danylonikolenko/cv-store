<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Company
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $region
 * @property string $city
 * @property string $address
 * @property bool $deleted
 */
class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'deleted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

    ];


}
