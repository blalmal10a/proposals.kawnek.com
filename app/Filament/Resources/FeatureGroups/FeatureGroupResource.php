<?php

namespace App\Filament\Resources\FeatureGroups;

use App\Filament\Resources\FeatureGroups\Pages\CreateFeatureGroup;
use App\Filament\Resources\FeatureGroups\Pages\EditFeatureGroup;
use App\Filament\Resources\FeatureGroups\Pages\ListFeatureGroups;
use App\Filament\Resources\FeatureGroups\Pages\ViewFeatureGroup;
use App\Filament\Resources\FeatureGroups\Schemas\FeatureGroupForm;
use App\Filament\Resources\FeatureGroups\Schemas\FeatureGroupInfolist;
use App\Filament\Resources\FeatureGroups\Tables\FeatureGroupsTable;
use App\Models\FeatureGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FeatureGroupResource extends Resource
{
    protected static ?string $model = FeatureGroup::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return FeatureGroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FeatureGroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeatureGroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFeatureGroups::route('/'),
            'create' => CreateFeatureGroup::route('/create'),
            'view' => ViewFeatureGroup::route('/{record}'),
            'edit' => EditFeatureGroup::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
