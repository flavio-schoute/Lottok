<?php

namespace App\Charts;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StatisticUsersPieChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    { 
        
        $topuser = User::query()
            ->selectRaw('first_name, last_name, credits')
            ->orderByRaw('credits DESC')
            ->limit(5)
            ->get();
        
        $fullname = [];
        $credits = [];
        foreach($topuser as $kv) {
            array_push($fullname, $kv->first_name . " " . $kv->last_name);
            array_push($credits, $kv->credits);
        }

        return $this->chart->pieChart()
            ->setTitle('Top 5 gebruikers met meeste geld')
            ->addData($credits)
            ->setLabels($fullname);
    }
}
