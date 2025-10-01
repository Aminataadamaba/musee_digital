<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtisteResource\Pages;
use App\Filament\Resources\ArtisteResource\RelationManagers;
use App\Models\Artiste;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ArtisteResource extends Resource
{
    protected static ?string $model = Artiste::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('prenom')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('biographie')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('date_naissance'),
                Forms\Components\DatePicker::make('date_deces'),
                Forms\Components\TextInput::make('nationalite')
                    ->maxLength(100)
                    ->default(null),
                Forms\Components\TextInput::make('photo_url')
                    ->maxLength(500)
                    ->default(null),
                Forms\Components\TextInput::make('site_web')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prenom')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_naissance')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_deces')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nationalite')
                    ->searchable(),
                Tables\Columns\TextColumn::make('photo_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('site_web')
                    ->searchable(),
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
            'index' => Pages\ListArtistes::route('/'),
            'create' => Pages\CreateArtiste::route('/create'),
            'edit' => Pages\EditArtiste::route('/{record}/edit'),
        ];
    }
}
