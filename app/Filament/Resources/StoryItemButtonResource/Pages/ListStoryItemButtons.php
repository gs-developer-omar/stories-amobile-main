<?php

namespace App\Filament\Resources\StoryItemButtonResource\Pages;

use App\Filament\Resources\StoryItemButtonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListStoryItemButtons extends ListRecords
{
    protected static string $resource = StoryItemButtonResource::class;
    public function getTitle(): string|Htmlable
    {
        return 'Кнопки на элементах сторисов';
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->slideOver(),
        ];
    }
}
