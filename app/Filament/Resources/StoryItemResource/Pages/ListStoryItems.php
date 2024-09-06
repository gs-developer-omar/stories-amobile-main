<?php

namespace App\Filament\Resources\StoryItemResource\Pages;

use App\Filament\Resources\StoryItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListStoryItems extends ListRecords
{
    protected static string $resource = StoryItemResource::class;
    public function getTitle(): string|Htmlable
    {
        return 'Элементы Сторисов';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver(),
        ];
    }
}
