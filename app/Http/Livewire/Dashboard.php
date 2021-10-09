<?php

namespace App\Http\Livewire;

use App\Models\Mentor;
use App\Models\Schedule;
use App\Models\Transaction;
use Livewire\Component;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class Dashboard extends Component
{
    public $period = 'month'; // "day", "week", "month", "year"
    public function mount($period = 'day')
    {
        $this->period = $period;
    }
    public function render()
    {

        return view('livewire.dashboard', [
            'jumlah_anggota' => Mentor::count(),
            'jumlah_transaksi' => Transaction::count(),
            'jumlah_jadwal' => Schedule::count(),
            'chart' => $this->renderChart($this->period),
        ]);
    }

    public function renderChart($type = 'day')
    {
        $chart_options = [
            'chart_title' => 'Transaksi',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Transaction',
            'group_by_field' => 'created_at',
            'group_by_period' => $type,
            'chart_type' => 'bar',
        ];
        if (auth()->user()->role->role_type == 'mentor') {
            $chart_options['chart_title'] = 'Jadwal';
            $chart_options['model'] = 'App\Models\Schedule';
            return new LaravelChart($chart_options);
        }
        if (auth()->user()->role->role_type == 'member') {
            return new LaravelChart($chart_options);
        }
        return new LaravelChart($chart_options);
    }
}
