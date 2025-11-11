<?php

namespace App\Filament\SelectFeature\Resources\Projects\Schemas;

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
                RepeatableEntry::make('feature_groups')
                    ->columnSpanFull()
                    ->label('Features')
                    ->schema([
                        RepeatableEntry::make('features')
                            ->label(function ($record) {
                                return $record->title;
                            })
                            ->columns(3)
                            ->schema([
                                TextEntry::make('name'),
                                TextEntry::make('cost')
                                    ->money()
                                    ->numeric(),
                                Section::make('details')
                                    ->columnSpanFull()
                                    ->hiddenLabel()
                                    ->hidden(function ($get) {
                                        return !$get('description');
                                    })
                                    ->schema([
                                        TextEntry::make('description')

                                            ->formatStateUsing(fn(string $state): string => nl2br($state))
                                            ->html()
                                            ->hiddenLabel()
                                    ])
                                    ->collapsed()
                            ])
                    ]),
                TextEntry::make('total_cost')
                    ->afterStateHydrated(function ($get, $set) {
                        //
                    })
                    ->dehydrated(false)
            ]);
    }
}
