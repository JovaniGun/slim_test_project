<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class UserModel extends Model{
    protected $table = 'users';
    protected $fillable = ['id','username','email','password','token','role'];
}