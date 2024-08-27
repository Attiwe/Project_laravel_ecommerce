<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Illuminate\Support\Str;
use Filament\Forms\Set;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    // protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
 
        return $form
        ->schema([
            Group::make()
                ->schema([
                    Section::make('Product Information')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur:true)
                                ->reactive()

                                ->afterStateUpdated(fn (string $operation, $state, Set $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null  ),

                                // ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                //     if ($operation === 'create') {
                                //         return;
                                //     }
                                //     $set('slug', Str::slug($state));  
                                // }),
                            
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->disabled()
                                ->dehydrated()
                                ->unique(Product::class ,'slug', ignoreRecord: true ),
                              
                              
                            MarkdownEditor::make('descriptian') 
                                ->columnSpanFull()
                                ->fileAttachmentsDirectory('products')
                        ])
                        ->columns(2),
                      
                    Section::make('Image')->schema([
                        FileUpload::make('images')
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                    ]),
                ])->columnSpan(2),
               
            Group::make()->schema([
                Section::make('Price')->schema([
                    TextInput::make('price')
                        ->numeric()
                        ->prefix('Egypt')
                ]),
                Section::make('Association')->schema([
                    Select::make('category_id')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('category', 'name'),
            
                    Select::make('brand_id')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('brand', 'name'),

                      Section::make('Status')->schema([
                            Toggle::make('in_stock') // مخزون
                    ->required()
                    ->default(true),
                            
                    Toggle::make(' 	is_active ')//غير نشط 
                    ->required()
                    ->default(true),
                       
                    Toggle::make('is_featured ')// هل هذه ميزة
                    ->required(),

                    Toggle::make('on_sale')//  معروض للبيع
                    ->required(),

                    ])   
                ])->columnSpan(1)
            ]) 
  
  
  
            ])->columns(3);
    
        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('category.name')->searchable(),
                TextColumn::make('brand.name')->searchable(),
                TextColumn::make('price')
                ->searchable()
                ->money('Egypt'),
                IconColumn::make('in_stock') ->boolean(),
                IconColumn::make('is_active') ->boolean(),
                IconColumn::make('is_featured') ->boolean(),
                IconColumn::make('on_sale') ->boolean(),
                TextColumn::make('created_at')
                ->dateTime()
                 ->sortable()
                ->toggleable(),


                TextColumn::make('updated_at')
                ->dateTime()
                 ->sortable()
                ->toggleable()
                // TextColumn::make('images')->searchable(),
              
                ])
            ->filters([
               SelectFilter::make('category')
               ->relationship('category','name'),

               SelectFilter::make('brand')
               ->relationship('brand','name')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\EditAction::make(),

                ])            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
