<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidebarMenu extends Model
{
    protected $fillable = ['title', 'route_name', 'icon_class', 'permission_name'];
}
