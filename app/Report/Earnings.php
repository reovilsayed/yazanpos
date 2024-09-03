<?php

namespace App\Report;

use App\Models\Order;

class Earnings
{

    public $from;
    public $to;
    protected $orders;

    /**
     * __construct
     *
     * @param  string $from
     * @param  string $to
     * @return void
     */
    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public static function range(string $from, string $to)
    {
        return new self($from, $to);
    }

    public function graph(string $interval = 'Day')
    {
        $query = Order::whereBetween('created_at', [$this->from, $this->to]);

        switch ($interval) {
            case 'Day':
                $query->selectRaw('DATE_FORMAT(created_at,"%d %M") as date, SUM(profit)/100 as total_profit,SUM(total)/100 as sales')
                    ->orderBy('date', 'asc')
                    ->groupBy('date');
                break;

            case 'Month':
                $query->selectRaw('DATE_FORMAT(created_at, "%M") as month, SUM(profit)/100 as total_profit,SUM(total)/100 as sales')
                    ->groupBy('month')
                    ->orderByRaw('MIN(created_at) ASC');
                break;

            case 'Year':
                $query->selectRaw('YEAR(created_at) as year, SUM(profit)/100 as total_profit,SUM(total)/100 as sales')
                    ->orderBy('year', 'asc')
                    ->groupBy('year');
                break;

            default:
                throw new \InvalidArgumentException('Invalid interval provided. Supported intervals are: Day, Month, Year.');
        }

        return $query->get()->toArray();
    }



    public function totalEarning()
    {
        // dd($this->to);
        return Order::whereBetween('created_at', [$this->from, $this->to])->sum('profit')/100;
    }
    public function totalSale()
    {
        return Order::whereBetween('created_at', [$this->from, $this->to])->sum('total')/100;
    }
}
