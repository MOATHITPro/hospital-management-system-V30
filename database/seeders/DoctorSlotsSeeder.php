<?php
//
//namespace Database\Seeders;
//
//use Illuminate\Database\Seeder;
//use App\Models\Doctor;
//use App\Models\DoctorSlot;
//
//class DoctorSlotsSeeder extends Seeder
//{
//    /**
//     * Run the database seeds.
//     *
//     * @return void
//     */
//    public function run()
//    {
//        // قائمة بأسماء الأيام
//        $workingDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']; // الأحد إلى الخميس
//
//        // أوقات العمل
//        $startTime = '08:00:00';
//        $endTime = '17:00:00';
//
//        // الحصول على جميع الأطباء
//        $doctors = Doctor::all();
//
//        foreach ($doctors as $doctor) {
//            foreach ($workingDays as $day) {
//                // إدخال السجلات في جدول doctor_slots لكل دكتور
//                DoctorSlot::create([
//                    'doctor_id' => $doctor->id,
//                    'day' => $day, // استخدام اسم اليوم بدلاً من الرقم
//                    'start_time' => $startTime,
//                    'end_time' => $endTime,
//                ]);
//            }
//        }
//    }
//}
