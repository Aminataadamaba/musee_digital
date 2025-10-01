<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OeuvreResource\Pages;
use App\Filament\Resources\OeuvreResource\RelationManagers;
use App\Models\Oeuvre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OeuvreResource extends Resource
{
   protected static ?string $model = Oeuvre::class;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    
    protected static ?string $navigationLabel = 'Œuvres';
    
    protected static ?string $navigationGroup = 'Collection';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations principales')
                    ->schema([
                        Forms\Components\TextInput::make('titre')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                if (!$set('qr_code')) {
                                    $set('qr_code', 'QR_' . Str::upper(Str::random(10)));
                                }
                            }),
                        
                        Forms\Components\Select::make('artiste_id')
                            ->relationship('artiste', 'nom')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nom')->required(),
                                Forms\Components\TextInput::make('prenom'),
                                Forms\Components\Textarea::make('biographie'),
                                Forms\Components\TextInput::make('nationalite'),
                            ]),
                        
                        Forms\Components\Select::make('categorie_id')
                            ->relationship('categorie', 'nom')
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Détails')
                    ->schema([
                        Forms\Components\TextInput::make('annee_creation')
                            ->label('Année de création')
                            ->maxLength(50),
                        
                        Forms\Components\TextInput::make('technique')
                            ->maxLength(255),
                        
                        Forms\Components\TextInput::make('dimensions')
                            ->maxLength(255)
                            ->placeholder('ex: 120 x 80 cm'),
                        
                        Forms\Components\TextInput::make('materiau')
                            ->label('Matériau')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('QR Code & Localisation')
                    ->schema([
                        Forms\Components\TextInput::make('qr_code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->default(fn () => 'QR_' . Str::upper(Str::random(10)))
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateQR')
                                    ->icon('heroicon-o-arrow-path')
                                    ->action(function (Forms\Set $set) {
                                        $set('qr_code', 'QR_' . Str::upper(Str::random(10)));
                                    })
                            ),
                        
                        Forms\Components\TextInput::make('salle')
                            ->maxLength(100),
                        
                        Forms\Components\TextInput::make('etage')
                            ->numeric()
                            ->default(0),
                        
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('position_x')
                                    ->numeric()
                                    ->step(0.01)
                                    ->label('Position X'),
                                
                                Forms\Components\TextInput::make('position_y')
                                    ->numeric()
                                    ->step(0.01)
                                    ->label('Position Y'),
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Médias')
                    ->schema([
                        Forms\Components\FileUpload::make('image_principale')
                            ->image()
                            ->imageEditor()
                            ->directory('oeuvres/images')
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        
                        Forms\Components\FileUpload::make('audio_description')
                            ->acceptedFileTypes(['audio/mpeg', 'audio/wav', 'audio/mp3'])
                            ->directory('oeuvres/audio')
                            ->maxSize(10240),
                        
                        Forms\Components\TextInput::make('audio_duree')
                            ->numeric()
                            ->suffix('secondes')
                            ->label('Durée audio'),
                        
                        Forms\Components\TextInput::make('video_url')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://youtube.com/...'),
                        
                        Forms\Components\TextInput::make('video_duree')
                            ->numeric()
                            ->suffix('secondes')
                            ->label('Durée vidéo'),
                        
                        Forms\Components\TextInput::make('modele_3d_url')
                            ->url()
                            ->maxLength(500)
                            ->label('URL Modèle 3D'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Visibilité & Ordre')
                    ->schema([
                        Forms\Components\Toggle::make('est_visible')
                            ->label('Visible au public')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('est_vedette')
                            ->label('Œuvre à la une')
                            ->default(false),
                        
                        Forms\Components\TextInput::make('ordre_visite')
                            ->numeric()
                            ->default(0)
                            ->label('Ordre dans le parcours'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_principale')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.jpg')),
                
                Tables\Columns\TextColumn::make('titre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('artiste.nom_complet')
                    ->label('Artiste')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('categorie.nom')
                    ->badge()
                    ->color(fn ($record) => $record->categorie?->couleur ?? 'gray'),
                
                Tables\Columns\TextColumn::make('qr_code')
                    ->label('QR Code')
                    ->copyable()
                    ->copyMessage('Code copié!')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('salle')
                    ->searchable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('nombre_vues')
                    ->label('Vues')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),
                
                Tables\Columns\IconColumn::make('est_visible')
                    ->boolean()
                    ->label('Visible')
                    ->toggleable(),
                
                Tables\Columns\IconColumn::make('est_vedette')
                    ->boolean()
                    ->label('Vedette')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categorie')
                    ->relationship('categorie', 'nom'),
                
                Tables\Filters\SelectFilter::make('artiste')
                    ->relationship('artiste', 'nom'),
                
                Tables\Filters\TernaryFilter::make('est_visible')
                    ->label('Visible'),
                
                Tables\Filters\TernaryFilter::make('est_vedette')
                    ->label('À la une'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('viewQR')
                    ->label('Voir QR')
                    ->icon('heroicon-o-qr-code')
                    // ->url(fn (Oeuvre $record): string => route('qr.show', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('ordre_visite', 'asc');
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
            'index' => Pages\ListOeuvres::route('/'),
            'create' => Pages\CreateOeuvre::route('/create'),
            'edit' => Pages\EditOeuvre::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
