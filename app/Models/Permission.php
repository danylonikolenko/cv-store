<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string $description
 * @property int $id
 * @property string $route
 * @property string $class_name
 * @property string $function_name
 * @property bool $deleted
 */
class Permission extends Model
{

    protected $table = 'permissions';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'description',
        'route',
        'class_name',
        'function_name',
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
