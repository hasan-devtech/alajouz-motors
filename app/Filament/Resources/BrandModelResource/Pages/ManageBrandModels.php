<?php

namespace App\Filament\Resources\BrandModelResource\Pages;

use App\Filament\Resources\BrandModelResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBrandModels extends ManageRecords
{
    protected static string $resource = BrandModelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
