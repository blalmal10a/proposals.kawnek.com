<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.projects.index');
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name_slug'] = Str::slug($data['name']);
        return $data;
    }
    public static bool $formActionsAreSticky = true;
}
