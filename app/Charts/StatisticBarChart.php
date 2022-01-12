<?php

namespace App\Charts;

use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StatisticBarChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
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

    
       // dd($topuser->toArray(), '...', $firstname);

        return $this->chart->barChart()
            ->setTitle('Beste gebruikers')
            ->addData('Geld', $credits)
            ->setXAxis($fullname);
            
    }
}
