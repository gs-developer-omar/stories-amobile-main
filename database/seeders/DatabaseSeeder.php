<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\StoryItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $clickInfo = Story::create([
            'title' => 'Куда приводит клик?',
            'position' => 13,
            'is_published' => true,
            ]);

        $addApraUb = Story::create([
            'title' => 'Как привязать APRA УБ к кошельку',
            'position' => 12,
            'is_published' => true,
            ]);

        $eSim = Story::create([
            'title' => 'Подключите eSIM а-мобайл',
            'position' => 11,
            'is_published' => true,
            ]);

        $tinkoffPayments = Story::create([
            'title' => 'Переводы на Тинькофф',
            'position' => 10,
            'is_published' => true,
            ]);

        $abonentRating = Story::create([
            'title' => 'РЕЙТИНГ АБОНЕНТА',
            'position' => 9,
            'is_published' => true,
            ]);

        $apraOnline = Story::create([
            'title' => 'APRA online',
            'position' => 8,
            'is_published' => true,
        ]);

        $cashback = Story::create([
            'title' => 'КЭШБЭК',
            'position' => 7,
            'is_published' => true,
        ]);

        $tadjikistan = Story::create([
            'title' => 'Переводы в Таджикистан',
            'position' => 6,
            'is_published' => true,
        ]);

        $uzbekistan = Story::create([
            'title' => 'Переводы в Узбекситан',
            'position' => 5,
            'is_published' => true,
        ]);

        $yooMoney = Story::create([
            'title' => 'Ю Money',
            'position' => 4,
            'is_published' => true,
        ]);

        $captain = Story::create([
            'title' => 'Капитан',
            'position' => 3,
            'is_published' => true,
        ]);

        $vaib = Story::create([
            'title' => 'ВАИБ',
            'position' => 2,
            'is_published' => true,
        ]);

        $howToCreateCashWallet = Story::create([
            'title' => 'Как создать кошелек кассира',
            'position' => 1,
            'is_published' => true,
        ]);

        $amobileCash = Story::create([
            'title' => 'Амобайл касса',
            'position' => 0,
            'is_published' => true,
        ]);

        // Куда приводит клик?

        StoryItem::create([
            'position' => 0,
            'name' => 'Телефон',
            'is_published' => true,
            'story_id' => $clickInfo->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Кошелек',
            'is_published' => true,
            'story_id' => $clickInfo->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'APRA УБ',
            'is_published' => true,
            'story_id' => $clickInfo->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'Капитан семьи',
            'is_published' => true,
            'story_id' => $clickInfo->id,
        ]);

        // Как привязать APRA УБ к кошельку

        StoryItem::create([
            'position' => 0,
            'name' => 'Апра УБ',
            'is_published' => true,
            'story_id' => $addApraUb->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Апра УБ',
            'is_published' => true,
            'story_id' => $addApraUb->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Апра УБ',
            'is_published' => true,
            'story_id' => $addApraUb->id,
        ]);


        // Подключите eSim а-мобайл

        StoryItem::create([
            'position' => 0,
            'name' => 'eSim',
            'is_published' => true,
            'story_id' => $eSim->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'eSim',
            'is_published' => true,
            'story_id' => $eSim->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'eSim',
            'is_published' => true,
            'story_id' => $eSim->id,
        ]);

        // Переводы на Тинькофф

        StoryItem::create([
            'position' => 0,
            'name' => 'Тинькофф переводы',
            'is_published' => true,
            'story_id' => $tinkoffPayments->id,
        ]);

        // Рейтинг Абонента

        StoryItem::create([
            'position' => 0,
            'name' => 'abonentRating',
            'is_published' => true,
            'story_id' => $abonentRating->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'abonentRating',
            'is_published' => true,
            'story_id' => $abonentRating->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'abonentRating',
            'is_published' => true,
            'story_id' => $abonentRating->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'abonentRating',
            'is_published' => true,
            'story_id' => $abonentRating->id,
        ]);

        StoryItem::create([
            'position' => 4,
            'name' => 'abonentRating',
            'is_published' => true,
            'story_id' => $abonentRating->id,
        ]);

        // Apra online ****************
        StoryItem::create([
            'position' => 0,
            'name' => 'Apra online',
            'is_published' => true,
            'story_id' => $apraOnline->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Apra online',
            'is_published' => true,
            'story_id' => $apraOnline->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Apra online',
            'is_published' => true,
            'story_id' => $apraOnline->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'Apra online',
            'is_published' => true,
            'story_id' => $apraOnline->id,
        ]);

        // Cashback ****************
        StoryItem::create([
            'position' => 0,
            'name' => 'Кэшбэк',
            'is_published' => true,
            'story_id' => $cashback->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Кэшбэк',
            'is_published' => true,
            'story_id' => $cashback->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Кэшбэк',
            'is_published' => true,
            'story_id' => $cashback->id,
        ]);

        // Tadjikistan ****************
        StoryItem::create([
            'position' => 0,
            'name' => 'Таджикистан',
            'is_published' => true,
            'story_id' => $tadjikistan->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Таджикистан',
            'is_published' => true,
            'story_id' => $tadjikistan->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Таджикистан',
            'is_published' => true,
            'story_id' => $tadjikistan->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'Таджикистан',
            'is_published' => true,
            'story_id' => $tadjikistan->id,
        ]);

        StoryItem::create([
            'position' => 4,
            'name' => 'Таджикистан',
            'is_published' => true,
            'story_id' => $tadjikistan->id,
        ]);

        // Uzbekistan *******************
        StoryItem::create([
            'position' => 0,
            'name' => 'Узбекситан',
            'is_published' => true,
            'story_id' => $uzbekistan->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Узбекситан',
            'is_published' => true,
            'story_id' => $uzbekistan->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Узбекситан',
            'is_published' => true,
            'story_id' => $uzbekistan->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'Узбекситан',
            'is_published' => true,
            'story_id' => $uzbekistan->id,
        ]);

        StoryItem::create([
            'position' => 4,
            'name' => 'Узбекситан',
            'is_published' => true,
            'story_id' => $uzbekistan->id,
        ]);

        StoryItem::create([
            'position' => 5,
            'name' => 'Узбекситан',
            'is_published' => true,
            'story_id' => $uzbekistan->id,
        ]);

        // YooMoney ******************************

        StoryItem::create([
            'position' => 0,
            'name' => 'YooMoney',
            'is_published' => true,
            'story_id' => $yooMoney->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'YooMoney',
            'is_published' => true,
            'story_id' => $yooMoney->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'YooMoney',
            'is_published' => true,
            'story_id' => $yooMoney->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'YooMoney',
            'is_published' => true,
            'story_id' => $yooMoney->id,
        ]);

        StoryItem::create([
            'position' => 4,
            'name' => 'YooMoney',
            'is_published' => true,
            'story_id' => $yooMoney->id,
        ]);

        // Captain ******************************

        StoryItem::create([
            'position' => 0,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);

        StoryItem::create([
            'position' => 4,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);

        StoryItem::create([
            'position' => 5,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);

        StoryItem::create([
            'position' => 6,
            'name' => 'Капитан',
            'is_published' => true,
            'story_id' => $captain->id,
        ]);


        // Vaib ******************************

        StoryItem::create([
            'position' => 0,
            'name' => 'Вайб',
            'is_published' => true,
            'story_id' => $vaib->id,
        ]);

        // Как создать кошелек абонента
        StoryItem::create([
            'position' => 0,
            'name' => 'Как создать кошелек кассира',
            'is_published' => true,
            'story_id' => $howToCreateCashWallet->id,
        ]);

        // Амобайл касса ******************************

        StoryItem::create([
            'position' => 0,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 1,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 2,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 3,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 4,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 5,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 6,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        StoryItem::create([
            'position' => 7,
            'name' => 'Амобайл Касса',
            'is_published' => true,
            'story_id' => $amobileCash->id,
        ]);

        User::create([
            'name' => 'Омар',
            'email' => 'gs_zero_main@mail.ru',
            'password' => '1411320Onq',
        ]);
    }
}
