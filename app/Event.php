<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'location', 'location_link', 'facebook_link'];

    public function getFormattedTimeAttribute()
    {
        $carb = new Carbon($this->timestamp);
        $ret = formatFullDate($carb);
        if (!$this->full_day) {
            $ret .= ' van ' . $carb->format('H:i');
        }

        if ($this->timestamp_end !== null) {
            $carb_end = new Carbon($this->timestamp_end);

            $start_day = $carb->format('Y-m-d');
            $end_day = $carb_end->format('Y-m-d');

            if ($start_day !== $end_day) {
                $ret .= ' tot ' . formatFullDate($carb_end);

                if (!$this->full_day) {
                    $ret .= ' ' . $carb_end->format('H:i');
                }
            } else {
                $ret .= ' tot ' . $carb_end->format('H:i');
            }
        }
        return $ret;
    }

    public function getStartTimeAttribute()
    {
        $carb = new Carbon($this->timestamp);
        $ret = formatFullDate($carb);
        if (!$this->full_day) {
            $ret .= ' ' . $carb->format('H:i');
        }
        return $ret;
    }

    public function getEndTimeAttribute()
    {
        if ($this->timestamp_end !== null) {
            $ret = '';
            $carb_end = new Carbon($this->timestamp_end);
            $carb = new Carbon($this->timestamp);

            $start_day = $carb->format('Y-m-d');
            $end_day = $carb_end->format('Y-m-d');

            if ($start_day !== $end_day) {
                $ret .= ' ' . formatFullDate($carb_end);

                if (!$this->full_day) {
                    $ret .= ' ' . $carb_end->format('H:i');
                }
            } else {
                $ret .= ' ' . $carb_end->format('H:i');
            }
            return $ret;
        } else {
            return false;
        }
    }

    public function getDayAttribute()
    {
        $carb = new Carbon($this->timestamp);
        $day = $carb->day;
        if ($day < 10) {
            $day = '0' . $day;
        }
        return $day;
    }

    public function getMonthAttribute()
    {
        $carb = new Carbon($this->timestamp);
        $month = $carb->locale('nl')->shortMonthName;
        return strtoupper($month);
    }

    public function getYearAttribute()
    {
        $carb = new Carbon($this->timestamp);
        return $carb->year;
    }

    public function uploadPicture($pictureFile)
    {
        $this->picture = $pictureFile->store('event-pictures', ['disk' => 'public']);
    }

    public static function getFutureOrdered()
    {
        $all_events = Event::where('timestamp', '>', now())->orderBy('timestamp', 'ASC')->get();
        return Event::order($all_events);
    }

    public static function getPastOrdered()
    {
        $all_events = Event::where('timestamp', '<', now())->orderBy('timestamp', 'DESC')->get();
        return Event::order($all_events);
    }

    public static function order($all_events)
    {
        $ordered = [];
        foreach ($all_events as $event) {
            $date = new Carbon($event->timestamp);
            $ordered[$date->format('d/m/Y')][] = $event;
        }
        return $ordered;
    }

    public static function nearest(int $amt)
    {
        return Event::where('timestamp', '>', now())->orderBy('timestamp', 'ASC')->take($amt)->get();
    }
}
