<?php

namespace App\Filament\Resources\ArtisteResource\Pages;

use App\Filament\Resources\ArtisteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtiste extends EditRecord
{
    protected static string $resource = ArtisteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
