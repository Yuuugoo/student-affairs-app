<?php

namespace App\Filament\Resources\RequestsResource\Pages;

use App\Filament\Resources\RequestsAccredResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRequests extends CreateRecord
{
    protected static string $resource = RequestsAccredResource::class;
}
