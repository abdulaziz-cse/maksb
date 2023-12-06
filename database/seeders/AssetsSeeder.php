<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id'=>'1','name'=>'النطاقات والدومينات'],['id'=>'2','name'=>'ملفات الموقع'],['id'=>'3','name'=>'عنوان البريد الإلكتروني'],
        ['id'=>'4','name'=>'حسابات وسائل التواصل الإجتماعي'],['id'=>'5','name'=>'قائمة المشتركين في البريد الإلكتروني'],['id'=>'6','name'=>'الجرد (المخزون)'],
    ['id'=>'7','name'=>'أصول العلامة التجارية (الشعارات ، إلخ)'],['id'=>'8','name'=>'أرقام الهواتف'],['id'=>'9','name'=>'عقود الموردين'],
            ['id'=>'10','name'=>'العلامات التجارية / براءات الاختراع'],['id'=>'11','name'=>'تقنية مخصصة'],['id'=>'12','name'=>'آخري']];
        DB::table('assets')->insert($data);
    }
}
