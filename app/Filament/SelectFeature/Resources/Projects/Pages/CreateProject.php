<?php

namespace App\Filament\SelectFeature\Resources\Projects\Pages;

use App\Filament\SelectFeature\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public static bool $formActionsAreSticky = true;
}
