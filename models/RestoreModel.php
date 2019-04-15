<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class RestoreModel extends Model{
    protected $table = 'restories';
    protected $fillable = ['id','code','email'];
}