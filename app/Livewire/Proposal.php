<?php

namespace App\Livewire;

use App\Models\Project;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Livewire\Component;

class Proposal extends Component
{
    public Project $project;

    // #[Title($this->project->name)]
    public function render()
    {
        FilamentColor::register([
            'rose' => Color::Rose,
        ]);
        $this->project->load('feature_groups.features');
        return view('livewire.proposal')->layout('components.layouts.app', [
            'title' => $this->project->name,
        ]);
    }
}
