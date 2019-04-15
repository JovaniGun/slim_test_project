<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class SessionModel extends Model{
    protected $table = 'sessions';
    protected $fillable = ['session_id','user_id','ip_addr', 'isLogin'];
}