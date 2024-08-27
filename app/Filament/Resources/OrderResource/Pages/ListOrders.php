<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array{
        return[
            OrderStats::class
        ];
    }
    // protected function getFooterWidgets(): array{
    //     return[ 
    //         OrderStats::class,
    //     ];
    // }

public function getTabs(): array{
    return[
          null=>Tab::make('All'),
          'new' => Tab::make()->query(fn($query) => $query->where('status','new')), 
          'Order Processing' => Tab::make()->query(fn($query) => $query->where('status','Processing')),      
          'Order Shipped' => Tab::make()->query(fn($query) => $query->where('status','Shipped')),      
          'Order Delivered' => Tab::make()->query(fn($query) => $query->where('status','Delivered')),      
          'Order Cancelled' => Tab::make()->query(fn($query) => $query->where('status','Cancelled')),      
        ];
    }
}
 