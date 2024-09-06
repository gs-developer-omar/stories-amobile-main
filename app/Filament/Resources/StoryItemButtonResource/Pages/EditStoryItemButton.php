<?php

namespace App\Filament\Resources\StoryItemButtonResource\Pages;

use App\Filament\Resources\StoryItemButtonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditStoryItemButton extends EditRecord
{
    protected static string $resource = StoryItemButtonResource::class;
    public function getTitle(): string|Htmlable
    {
        return 'Редактирование Кнопки';
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
