<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RevenueSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id'=>'1','name'=>'بيع منتج','description'=>'أنت تبيع منتجات تخصك، أو منتجات آخري عن طريق التسويق لنفسك أو التسويق بالعمولة وتحصل علي الربح الخاص بك من تلك الميزة.'],
            ['id'=>'2','name'=>'الإعلانات','description'=>'أنت تبيع أقساما فارغة أو متاحة من موقع الويب الخاص بك لاستضافة الإعلانات. يشمل الإعلانات والمحتوي المدعوم ومقاطع الفيديو.'],
            ['id'=>'3','name'=>'البيع مقابل العمولة','description'=>'تكسب عمولة لتسويق منتجات شخص آخر أو شركة أخري علي موقعك. يتضمن شراكات مع المؤثرين والمدونين وقوائم البريد الإلكتروني.'],
            ['id'=>'4','name'=>'بيع منتج','description'=>'تكسب المال عن طريق البيع المباشر للخدمات التي تقدمها، لمرة واحدة أو بشكل متكرر، يشمل كلا من خدمات العمالة والبرمجيات (SaaS)'],
            ['id'=>'5','name'=>'بيع منتج','description'=>'تكسب المال من طرق آخري غير موصوفة أعلاه.']
        ];
        DB::table('revenue_sources')->insert($data);
    }
}
