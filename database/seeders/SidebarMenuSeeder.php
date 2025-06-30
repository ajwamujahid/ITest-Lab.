<?php

namespace Database\Seeders;
// database/seeders/SidebarMenuSeeder.php

use Illuminate\Database\Seeder;
use App\Models\SidebarMenu;

class SidebarMenuSeeder extends Seeder
{
    public function run()
    {
        SidebarMenu::create([
            'title' => 'Upload Reports',
            'route_name' => 'reports.upload',
            'icon_class' => 'bx bx-upload',
            'permission_name' => 'upload reports',
        ]);

        SidebarMenu::create([
            'title' => 'Chat with Patients',
            'route_name' => 'chat.manager',
            'icon_class' => 'bx bx-chat',
            'permission_name' => 'access chat',
        ]);
    }
}
