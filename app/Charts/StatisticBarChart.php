<?php

namespace App\Charts;

use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        // Todays year date
        $currentYear = date('Y');
        
        // Gets users out of database with the same month and counts them up
        $users[] = DB::table('users')
        ->select(DB::raw('MONTHNAME(DATE(created_at)) as date'), DB::raw('count(*) as views'))
        ->whereYear('created_at','=',$currentYear)
        ->groupBy('date')
        ->orderBy('created_at','ASC')
        ->get();

        $count = [];
        $month = [];
        // In the foreach he puts everything in 2 seperate arrays
        foreach($users[0] as $kv) {
            array_push($count, $kv->views);
            array_push($month, $kv->date);
        }

        // Returns the chart with given values
        return $this->chart->barChart()
            ->setTitle('Geregistreerde gebruiker van het jaar '.$currentYear)
            ->addData('Geld', $count)
            ->setXAxis($month);
            
    }
}
