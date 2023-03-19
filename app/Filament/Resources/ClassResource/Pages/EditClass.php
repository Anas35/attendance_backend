<?php

namespace App\Filament\Resources\ClassResource\Pages;

use App\Filament\Resources\ClassResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClass extends EditRecord
{
    protected static string $resource = ClassResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
