<?php

namespace App\Http\Livewire\Client;

use App\Models\Mentor;
use App\Models\Schedule;
use Livewire\Component;

class MentorDetail extends Component
{
    public $mentor_id;
    public $mentor;
    public $schedule_topic;
    public $schedule_date;
    public $schedule_duration;
    public function mount($mentor_id)
    {
        $this->mentor_id = $mentor_id;
        $this->mentor = Mentor::find($mentor_id);
        if (!$this->mentor) {
            return abort(404);
        }
    }
    public function render()
    {
        return view('livewire.client.mentor-detail', [
            'mentors' => Mentor::all()
        ])->layout('layouts.user');
    }

    public function makeSchedule()
    {
        $mentor = Mentor::find($this->mentor_id);
        if (!$mentor) {
            return abort(404);
        }

        $this->validate([
            'schedule_topic' => 'required',
            'schedule_date' => 'required',
            'schedule_duration' => 'required',
        ]);
        Schedule::create([
            'schedule_topic' => $this->schedule_topic,
            'schedule_date' => date('Y-m-d H:i:s', strtotime($this->schedule_date)),
            'schedule_duration' => $this->schedule_duration,
            'mentor_id' => $mentor->id,
            'user_id' => auth()->user()->id,
        ]);

        return $this->emit('showAlert', ['msg' => 'Schedule Berhasil Dibuat', 'redirect' => true, 'path' => '/schedule']);
    }
}
