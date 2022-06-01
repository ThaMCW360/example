<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

        protected $fillable = [
        'ad_id',
        'advertiser_id',
        'status',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'duration'
        ];


    public static function timeRaw($time)
    {

        // var_dump($time_raw);
        if(strpos($time,":")>0 || strpos($time,":")===0){
            $time_raw = explode(":", $time);
            $time_raw = $time_raw[0]+$time_raw[1]/60;
        } else {
            $time_raw = $time/60;
        }

        return $time_raw;
    }

    public static function getWeekday($date) {
        return date('w', strtotime($date));
    }

    public static function timeFromRaw($time)
    {
        $time = (float)$time;
        $time_raw[0] = $time-fmod($time, 1);
        $time_raw[1] = fmod($time, 1);
        $time_raw = $time_raw[0].":".round($time_raw[1]*60,0);
        return $time_raw;
    }

    public static function timePartials($time){
        $time = (float)$time;
        $time_raw[0] = $time-fmod($time, 1);
        $time_raw[1] = fmod($time, 1)*60;
        return $time_raw;
    }


    public static function timeSplit($time)
    {
        $timeS = explode(":", $time);
        return $timeS;
    }

    public static function disabledDates($advertiser_id, $advertising_id){
        $appointments_by_date = Appointment::select('date_start')->where([["advertiser_id", $advertiser_id]])->distinct()->get();
        $disabledDates = [];
        $tmp = [];

        for($i=0; $i<count($appointments_by_date); $i++){
            array_push($tmp, Appointment::freeTimes($advertiser_id, $advertising_id, $appointments_by_date[$i]["date_start"]));
        }

        for($i=0; $i<count($appointments_by_date); $i++){
            $disabledDates[$i]["date"] = $appointments_by_date[$i]["date_start"];
            if(count($tmp[$i]["time"])>0){
              $disabledDates[$i]["res"] = false;
            } else {
                $disabledDates[$i]["res"] = true;
            }
        }
        return $disabledDates;
    }

}
