<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[['link_name'=>'后盾网',
                'link_title'=>'国内口碑不错',
                'link_url'=>'http://www.houdun.com',
                'link_order'=>1
            ],
            ['link_name'=>'后盾论坛',
                'link_title'=>'后盾网的论坛',
                'link_url'=>'http://bbs.houdun.com',
                'link_order'=>2]
            ];
        DB::table('links')->insert($data);
    }
}
