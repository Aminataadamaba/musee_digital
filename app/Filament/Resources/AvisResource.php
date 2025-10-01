<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AvisResource\Pages;
use App\Filament\Resources\AvisResource\RelationManagers;
use App\Models\Avis;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvisResource extends Resource
{
    protected static ?string $model = Avis::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('oeuvre_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('session_id')
                    ->maxLength(100)
                    ->default(null),
                Forms\Components\TextInput::make('note')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('commentaire')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('est_modere')
                    ->required(),
                Forms\Components\Toggle::make('est_visible')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('oeuvre_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('est_modere')
                    ->boolean(),
                Tables\Columns\IconColumn::make('est_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListAvis::route('/'),
            'create' => Pages\CreateAvis::route('/create'),
            'edit' => Pages\EditAvis::route('/{record}/edit'),
        ];
    }
}
