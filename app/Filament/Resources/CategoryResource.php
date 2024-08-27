<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
  use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
  use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use File;
  use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
  use Filament\Forms\Components\Section;
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema
            ([
                 
                Section::make
                ([
                    Grid::make()->schema
                    ([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->afterStateUpdated(fn (string $operation, $state, callable $set) => 
                                $operation === 'create' ? $set('slug', Str::slug($state)) : null
                            ),

                             TextInput::make('slug')
                             ->maxLength(255)
                             ->required()
                             ->dehydrated()//تشير إلى أن القيمة الخاصة بالحقل يجب أن تُخزن فقط عند تقديم النموذج وليس أثناء التفاعل مع واجهة المستخدم
                             ->unique(Category::class,'slug' ,ignoreRecord: true),
                    ]),
                      
                     FileUpload::make('image')
                     ->image()
                     ->directory('categories'),
                   
                     Toggle::make('is_active')
                     ->required()
                     ->default(true)
                ]),
               

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
         
                Tables\Columns\ImageColumn::make('image'),
         
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
