<?php

namespace App\Filament\Resources\ClassResource\Pages;

use App\Filament\Resources\ClassResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClasses extends ListRecords
{
    protected static string $resource = ClassResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
