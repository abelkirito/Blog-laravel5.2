<?php
/**
 * Created by PhpStorm.
 * User: kirito
 * Date: 2018/6/2
 * Time: 14:17
 */
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
class User extends Model{
    protected $table='user';
    protected $primaryKey='user_id';
    public $timestamps=false;
}