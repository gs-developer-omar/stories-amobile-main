<?php

namespace App\Enums\api\v1;

enum MediaTypes: string
{
    case Файл = 'media_file';
    case Ссылка = 'link';
}
