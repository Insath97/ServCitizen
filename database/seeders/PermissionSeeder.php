<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions  = [

            /* request */
            ['name' => 'Request Index',  'group_name' => 'Request Permissions'],
            ['name' => 'Request Create', 'group_name' => 'Request Permissions'],
            ['name' => 'Request Update', 'group_name' => 'Request Permissions'],
            ['name' => 'Request Delete', 'group_name' => 'Request Permissions'],

            /* client */
            ['name' => 'Client Index',  'group_name' => 'Client Permissions'],
            ['name' => 'Client Create', 'group_name' => 'Client Permissions'],
            ['name' => 'Client Update', 'group_name' => 'Client Permissions'],
            ['name' => 'Client Delete', 'group_name' => 'Client Permissions'],

            /* services */
            ['name' => 'Service Index',  'group_name' => 'Service Permissions'],
            ['name' => 'Service Create', 'group_name' => 'Service Permissions'],
            ['name' => 'Service Update', 'group_name' => 'Service Permissions'],
            ['name' => 'Service Delete', 'group_name' => 'Service Permissions'],

            /* service type */
            ['name' => 'Service Type Index',  'group_name' => 'Service Type Permissions'],
            ['name' => 'Service Type Create', 'group_name' => 'Service Type Permissions'],
            ['name' => 'Service Type Update', 'group_name' => 'Service Type Permissions'],
            ['name' => 'Service Type Delete', 'group_name' => 'Service Type Permissions'],

            /* status*/
            ['name' => 'Status Index',  'group_name' => 'Status Permissions'],
            ['name' => 'Status Create', 'group_name' => 'Status Permissions'],
            ['name' => 'Status Update', 'group_name' => 'Status Permissions'],
            ['name' => 'Status Delete', 'group_name' => 'Status Permissions'],

            /* Branch & Division */
            ['name' => 'Branch Index',  'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Branch Create', 'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Branch Update', 'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Branch Delete', 'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Unit Index',  'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Unit Create', 'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Unit Update', 'group_name' => 'Branch & Division Permissions'],
            ['name' => 'Unit Delete', 'group_name' => 'Branch & Division Permissions'],

            /* Region Structure*/
            ['name' => 'Province Index',  'group_name' => 'Region Structure Permissions'],
            ['name' => 'Province Create', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'Province Update', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'Province Delete', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'District Index',  'group_name' => 'Region Structure Permissions'],
            ['name' => 'District Create', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'District Update', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'District Delete', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'DS Index',  'group_name' => 'Region Structure Permissions'],
            ['name' => 'DS Create', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'DS Update', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'DS Delete', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'GN Division Index',  'group_name' => 'Region Structure Permissions'],
            ['name' => 'GN Division Create', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'GN Division Update', 'group_name' => 'Region Structure Permissions'],
            ['name' => 'GN Division Delete', 'group_name' => 'Region Structure Permissions'],

            /* Access Management */
            ['name' => 'Permission Index',  'group_name' => 'Access Management Permissions'],
            ['name' => 'Permission Create', 'group_name' => 'Access Management Permissions'],
            ['name' => 'Permission Update', 'group_name' => 'Access Management Permissions'],
            ['name' => 'Permission Delete', 'group_name' => 'Access Management Permissions'],
            ['name' => 'User Role Index',  'group_name' => 'Access Management Permissions'],
            ['name' => 'User Role Create', 'group_name' => 'Access Management Permissions'],
            ['name' => 'User Role Update', 'group_name' => 'Access Management Permissions'],
            ['name' => 'User Role Delete', 'group_name' => 'Access Management Permissions'],

            // Payment
            ['name' => 'Payment Index', 'group_name' => 'Payment Permissions'],

            /* working progress */
            ['name' => 'Token Status Index', 'group_name' => 'Working Progress Status Permissions'],

            /* System Setting  */
            ['name' => 'System Setting Index', 'group_name' => 'System Setting Permissions'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'group_name' => $permission['group_name'],
                'guard_name' => 'admin',
            ]);
        }
    }
}
