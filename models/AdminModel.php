<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class AdminModel extends Model{
    protected $table = 'admins';
    protected $fillable = ['id','login','password'];
}