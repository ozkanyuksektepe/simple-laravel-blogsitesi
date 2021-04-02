<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages=['Hakkımızda','Kariyer','Vizyonumuz','Misyonumuz'];
        $count=0;
        foreach($pages as $page){
            $count++;
            DB::table('pages')->insert([
                'title'=>$page,
                'slug'=>str::slug($page,'-'),
                'image'=>'https://gordontredgold.com/wp-content/uploads/2018/08/business.jpg',
                'content'=>'Sen ne diyorsun Dayıoğlu, Aklını başına al. Yoksa gelirim yanına bozuşuruz.
                Aklını aldım mı tam alırım. Ayık olacaksın yoksa ayıltırım Morruk.',
                'order'=>$count,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
