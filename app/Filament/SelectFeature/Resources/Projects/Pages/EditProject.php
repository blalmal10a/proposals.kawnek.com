<?php

namespace App\Filament\SelectFeature\Resources\Projects\Pages;

use App\Filament\SelectFeature\Resources\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    public function mutateFormDataBeforeSave(array $data): array
    {
        $data['name_slug'] = Str::slug($data['name']);
        return $data;
    }
    public static bool $formActionsAreSticky = true;
}
