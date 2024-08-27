<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Number;
// use Fiilament\Models\Order;
class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Orders', Order::query()->where('status','new')->count()),
            Stat::make('Order Processing' ,Order::query()->where('status','Processing')->count() ),
            Stat::make('Order Shipped' ,Order::query()->where('status','Shipped')->count() ),
            Stat::make('Order Cancelled' ,Order::query()->where('status','Cancelled')->count() ),
            Stat::make('Order Delivered' ,Order::query()->where('status','Delivered')->count() ),
            Stat::make('Average price' ,Number::currency(Order::query()->avg('grand_total'),'EGP') )
        ];
    } 
} 
 