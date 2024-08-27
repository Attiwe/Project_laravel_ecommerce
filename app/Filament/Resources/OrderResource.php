<?php

 namespace App\Filament\Resources;
 use App\Filament\Resources\OrderResource\Pages;
 
 use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use App\Models\Order;
use App\Models\Product;
use Collator;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Number;
 
 class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag' ;
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Informatian')->schema([
                       Select::make('user_id') 
                       ->relationship('user' ,'name')
                       ->searchable()
                       ->required()
                       ->preload(),
                     
                       Select::make('payment_method')//طريقة الدفع
                        ->options([
                            'cod'    => 'cash on delivery',//الدفع عند التسليم
                            'stripe' => 'stripe',
                            'Paypal' => 'paypal',
                        ])
                        ->required(),
                        @Select::make('payment_status')
                        ->options
                        ([
                            'paid'   => 'Paid', //مدفوع
                            'pending'=> 'Pending',// قيد الانتظار
                            'failed' => 'Failed' ,//فشل
                        ])
                        ->default('pending')
                        ->required(),

                        ToggleButtons::make('status')
                        ->required()
                        ->inline()
                        ->default('new')
                        ->options([
                          'new'        => 'New',
                          'processing' => 'Processing',
                          'shipped'    => 'Shipped',
                          'delivered'  => 'Delivered',
                          'canclled'   => 'Cancelled' ,  
                         ])
                         ->colors([
                          'new'        => 'info',
                          'processing' => 'warning',
                          'shipped'    => 'success',
                          'delivered'  => 'primary',
                          'canclled'   => 'danger' ,
                         ])
                         ->icons([
                            'new'        => 'heroicon-m-plus',
                          'processing' => 'heroicon-m-arrow-path',
                          'shipped'    => 'heroicon-m-truck',
                          'delivered'  => 'heroicon-m-check-badge',
                          'canclled'   => 'heroicon-m-x-circle' ,
                         ]),
                         
                         Select::make('currency')
                         ->required()
                         ->default('Egypt')
                         ->options([
                            'Egypt'  =>'EGP',
                            'usd'    =>'USD',
                            'japan ' =>' JPY',
                            'saudl ' =>' Riyal',
                         ]),
                          
                         Select::make('Shiping_method')//طريقة الشحن
                         ->required()
                         ->options([
                            'fedex'  => 'FedEx',
                            'ups'    => 'UPs',
                            'usps'   => 'USPS'
                         ]),
                        Textarea::make('notes')
                       ->columnSpanFull(),

                   
                ])->columns(2),

                Section::make('Order Items')->schema([
                    Repeater::make('items') //التكرار
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->distinct()
                         ->columnSpan(4)
                        ->reactive()
                        ->afterStateUpdated(fn($state,  Set $set) =>
                        $set('unit_amount', Product::find($state)?->price ?? 0) )
                    
                        ->afterStateUpdated(fn($state,  Set $set) =>
                        $set('total_amount', Product::find($state)?->price ?? 0) ),
                        
                        TextInput::make('quantity')     
                        ->numeric()
                        ->minValue(1)
                        ->default(1)
                        ->required()
                        ->columnSpan(3)
                        ->reactive()
                        ->afterStateUpdated(fn($state, Set $set, Get $get) => 
                        $set('total_amount', $state * $get('unit_amount'))  ),                        

                        TextInput::make('unit_amount')
                        ->numeric()
                        ->required()
                        ->disabled()//لتعطيل حقل معين في النموذج   Filament  تُستخدم 
                        ->dehydrated()
                        ->columnSpan(3),
                        
                        TextInput::make('total_amount')
                        ->numeric()
                        ->dehydrated()
                        ->required()
                         ->columnSpan(2)
                        
                    ])->columns(12),
                        ]) ,
  
                        Section::make()->schema([ 
                        Placeholder::make('groud_total_placeholder')
                        ->label(' Mony Totals ')
                        ->content(function(Get $get, Set $set) {
                            $total = 0;

                            // جلب محتويات الـ Repeater
                            if (!$repeaters = $get('items')) {
                                return $total;  
                            }

                            // حساب المجموع الإجمالي
                            foreach($repeaters as $key => $repeater) {
                                
 
                                $total += $get("items.{$key}.total_amount");
                            }
                            $set('grand_total' , $total ); //Not Not
                            // return $total .'EGP'; // إعادة المجموع النهائي
                            return Number::currency($total, 'EGP' );    
                        }),
                        Hidden::make('grand_total') //Not Not
                        ->default(0)

                        ])
                         ])->columnSpanFull(),


    ]); 
    }

    public static function table(Table $table): Table
    {
        return $table
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
                
                ])
                ->filters([
                    
                  
                  
            ])
            ->actions([

                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\EditAction::make(), 
                    ])

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


 
    public static function getNavigationBadge() :?string{  //code spasheal cunter Number 
        return static::getModel()::count();
    } 
     
    public static function getNavigationBadgeColor() : string|array|null{
        return static::getModel()::count() >10 ? 'danger' : 'success';
    }



    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class
        ];
    }
 
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}


