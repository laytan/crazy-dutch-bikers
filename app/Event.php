<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
                    $ret .= ' van ' . $carb_end->format('H:i');
                }
            } else {
                $ret .= ' tot ' . $carb_end->format('H:i');
            }
        }
        return $ret;
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
}
