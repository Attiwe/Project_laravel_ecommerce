<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Filament\Infolists\Components\Section;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(6)
            ->defaultSort('created_at', 'desc')
           
            
           
            ->columns([

              

                TextColumn::make('user.name') 
                ->label('Custmer')
                ->searchable()
                ->sortable(),//work icon 

                TextColumn::make('grand_total') 
                ->numeric()
                 ->sortable()
                ->money('EGP'),
                
                TextColumn::make('payment_method') 
                 ->searchable()
                ->sortable(),

                TextColumn::make('payment_status') 
                ->searchable()
               ->sortable(),
                   
               TextColumn::make('currency')
               ->sortable()
               ->searchable(),
               
               
               
               SelectColumn::make('status')
               // ->disabled()
               ->options([
                   'new'        => 'New',
                   'processing' => 'Processing',
                   'shipped'    => 'Shipped',
                   'delivered'  => 'Delivered',
                   'canclled'   => 'Cancelled' ,  
               ])
               ->sortable()
               ->searchable(),
               
            

               TextColumn::make('updated_at')
               ->dateTime()
               ->sortable()
               ->toggleable(),
               
               TextColumn::make('created_at')
               ->dateTime()
               ->sortable()
               ->toggleable()
            
            
               
           

                ]);
     
             
    }
}
