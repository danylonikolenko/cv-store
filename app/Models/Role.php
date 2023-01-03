<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $description
 * @property int $id
 * @property string $name
 * @property array $permission_ids
 * @property bool $deleted
 */
class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'permission_ids',
        'deleted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permission_ids' => 'array'
    ];


}
