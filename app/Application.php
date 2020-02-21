<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Application extends Model
{
    protected $guarded = ['person_picture', 'bike_picture'];

    public function setPersonPictureAttribute(UploadedFile $file)
    {
        $this->attributes['person_picture'] = $file->store('applications', ['disk' => 'public']);
    }

    public function setBikePictureAttribute(UploadedFile $file)
    {
        $this->attributes['bike_picture'] = $file->store('applications', ['disk' => 'public']);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }
}
