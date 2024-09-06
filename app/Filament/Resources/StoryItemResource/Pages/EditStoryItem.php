<?php

namespace App\Filament\Resources\StoryItemResource\Pages;

use App\Filament\Resources\StoryItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditStoryItem extends EditRecord
{
    protected static string $resource = StoryItemResource::class;
    public function getTitle(): string|Htmlable
    {
        return 'Редактирование Элемента Сториса';
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
