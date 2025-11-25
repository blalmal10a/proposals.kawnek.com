<?php

namespace App\Filament\SelectFeature\Pages;

use App\Models\Project;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class HomePage extends Page
{
    protected string $view = 'filament.select-feature.pages.home-page';
    protected static ?string $title = "Home";
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-home';

    protected function getViewData(): array
    {
        $request = request();
        $projectList = [];
        if ($request->phone) {
            $projectList = Project::where('phone', $request->phone)->get();
        }
        return [
            'requestParameters' => $request->all(),
            'projectList' => $projectList
        ];
    }
}
