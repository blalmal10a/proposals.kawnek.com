<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('description')
                    ->html()
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('client_name'),
                TextEntry::make('initiated_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('abandoned_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                RepeatableEntry::make('feature_groups')
                    ->schema([
                        RepeatableEntry::make('features')
                            ->label(function ($record) {
                                return $record->title;
                            })
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('cost'),
                            ])
                            ->columnSpanFull()
                            ->columns(2)
                    ])
                    ->columnSpanFull()
                    ->columns(2)
            ]);
    }
}
