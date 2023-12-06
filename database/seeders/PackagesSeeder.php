<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['id'=>'1','name'=>'الباقة التجريبية', 'description' => 'توفر قائمتنا القياسية أعمالك لأكثر من 300 ألف مشتري علي مستوي العالم يمثلون أكثر من 70 مليار جولار من محفظة المشتري.
        3 أشهر مدة البيع - مدي الوصول القياسي - الضمان المخصوم / أو المدفوعات الاستئمانية
        يشمل: قائمة السوق - تكامل البيانات - دعم في نفس اليوم
        الإضافات الاختيارية: 199 دولار لاتفاقية عدم الإفشاء والسرية - 199 دولار للقوالب القانونية']];
        DB::table('packages')->insert($data);
    }
}
