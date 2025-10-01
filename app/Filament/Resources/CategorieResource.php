<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategorieResource\Pages;
use App\Filament\Resources\CategorieResource\RelationManagers;
use App\Models\Categorie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategorieResource extends Resource
{
    
   protected static ?string $model = Categorie::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Catégories';
    
    protected static ?string $navigationGroup = 'Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => 
                        $set('slug', Str::slug($state))
                    ),
                
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                
                Forms\Components\TextInput::make('icone')
                    ->maxLength(100)
                    ->placeholder('ex: 🎨'),
                
                Forms\Components\ColorPicker::make('couleur')
                    ->default('#000000'),
                
                Forms\Components\TextInput::make('ordre')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icone')
                    ->size('xl'),
                
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\ColorColumn::make('couleur'),
                
                Tables\Columns\TextColumn::make('oeuvres_count')
                    ->counts('oeuvres')
                    ->label('Œuvres')
                    ->badge(),
                
                Tables\Columns\TextColumn::make('ordre')
                    ->sortable(),
            ])
            ->reorderable('ordre')
            ->defaultSort('ordre')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategorie::route('/create'),
            'edit' => Pages\EditCategorie::route('/{record}/edit'),
        ];
    }
}
