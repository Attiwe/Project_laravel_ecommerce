<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use Filament\Pages\Page;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form 
    {
        return $form
            ->schema([
            Forms\components\TextInput::make('name') ->required(),
          
            Forms\components\TextInput::make('email')  
            ->label('Email Address')
            ->email()
            ->maxlength(255)
            ->unique(ignoreRecord:true)
            ->required(),

            Forms\components\DateTimePicker::make('email_verified_at') 
               ->label('Email Verified At')
               ->default(now()),
            
          
            Forms\Components\TextInput::make('password')
            ->password()
            ->dehydrated(fn($state) => filled($state))
            ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),//يجعل العمود قابلًا للبحث
                Tables\Columns\TextColumn::make('email') ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                ->dateTime()
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->searchable(),
             ])
            ->filters([
                //
            ])
            ->actions([
              

                Tables\Actions\ActionGroup::make([

                 Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
               
            ]),
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

    public static function getGloballySearchableAttributes(): array
    {
        return ['name' , 'email'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
