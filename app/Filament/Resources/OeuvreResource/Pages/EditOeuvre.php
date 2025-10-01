<?php

namespace App\Filament\Resources\OeuvreResource\Pages;

use App\Filament\Resources\OeuvreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOeuvre extends EditRecord
{
    protected static string $resource = OeuvreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
