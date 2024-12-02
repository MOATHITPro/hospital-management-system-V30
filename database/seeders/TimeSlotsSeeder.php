<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotsSeeder extends Seeder
{
    /**
     * Run the database seeds with parameters.
     */
    public function runWithParameters($startHour, $endHour, $duration)
    {
        // تحويل ساعات البدء والنهاية إلى أوقات
        $startTime = $startHour . ':00:00';
        $endTime = $endHour . ':00:00';

        // تحويل الأوقات إلى طوابع زمنية
        $currentTime = strtotime($startTime);
        $endTime = strtotime($endTime);

        $timeSlots = [];

        while ($currentTime < $endTime) {
            $nextTime = $currentTime + ($duration * 60); // إضافة المدة بالدقائق

            // التأكد من أن الوقت التالي لا يتجاوز وقت النهاية
            if ($nextTime > $endTime) {
                $nextTime = $endTime;
            }

            // إضافة الفترة الزمنية إلى المصفوفة
            $timeSlots[] = [
                'start_time' => date('H:i:s', $currentTime),
                'end_time' => date('H:i:s', $nextTime),
                'duration' => ($nextTime - $currentTime) / 60,
            ];

            // تحديث الوقت الحالي للوقت التالي
            $currentTime = $nextTime;
        }

        // إدخال الفترات الزمنية في قاعدة البيانات
        DB::table('time_slots')->insert($timeSlots);
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $startHour = 8; // 8 صباحًا
        $endHour = 17; // 3 مساءً

        $duration1 = 10; // مدة 10 دقائق
        $duration2 = 15; // مدة 15 دقيقة


        $this->runWithParameters($startHour, $endHour, $duration1);
        $this->runWithParameters($startHour, $endHour, $duration2);
    }
}
