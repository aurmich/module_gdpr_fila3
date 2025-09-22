<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Modules\Gdpr\Filament\Resources\TreatmentResource\Pages;
use Modules\Gdpr\Models\Treatment;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TreatmentResource extends XotBaseResource
{
<<<<<<< HEAD
    protected static null|string $model = Treatment::class;

    protected static null|string $navigationIcon = 'heroicon-o-rectangle-stack';

    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'active' => Forms\Components\Toggle::make('active')->required(),
            'required' => Forms\Components\Toggle::make('required')->required(),
            'name' => Forms\Components\TextInput::make('name')->required()->maxLength(191),
            'description' => Forms\Components\Textarea::make('description')->required()->columnSpanFull(),
            'documentVersion' => Forms\Components\TextInput::make('documentVersion')->maxLength(191)->default(null),
            'documentUrl' => Forms\Components\TextInput::make('documentUrl')->maxLength(191)->default(null),
            'weight' => Forms\Components\TextInput::make('weight')->required()->numeric(),
=======
    protected static ?string $model = Treatment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            'active' => Forms\Components\Toggle::make('active')
                ->required(),
            'required' => Forms\Components\Toggle::make('required')
                ->required(),
            'name' => Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(191),
            'description' => Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull(),
            'documentVersion' => Forms\Components\TextInput::make('documentVersion')
                ->maxLength(191)
                ->default(null),
            'documentUrl' => Forms\Components\TextInput::make('documentUrl')
                ->maxLength(191)
                ->default(null),
            'weight' => Forms\Components\TextInput::make('weight')
                ->required()
                ->numeric(),
>>>>>>> 6d1fb23 (.)
        ];
    }

    public function getTableColumns(): array
    {
        return [
            // Tables\Columns\TextColumn::make('id')
<<<<<<< HEAD
            
            //     ->searchable(),
            Tables\Columns\IconColumn::make('active')->boolean(),
            Tables\Columns\IconColumn::make('required')->boolean(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('documentVersion')->searchable(),
            Tables\Columns\TextColumn::make('documentUrl')->searchable(),
            Tables\Columns\TextColumn::make('weight')->numeric()->sortable(),
=======
            //
            //     ->searchable(),
            Tables\Columns\IconColumn::make('active')
                ->boolean(),
            Tables\Columns\IconColumn::make('required')
                ->boolean(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('documentVersion')
                ->searchable(),
            Tables\Columns\TextColumn::make('documentUrl')
                ->searchable(),
            Tables\Columns\TextColumn::make('weight')
                ->numeric()
                ->sortable(),
>>>>>>> 6d1fb23 (.)
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

<<<<<<< HEAD
    #[\Override]
=======
>>>>>>> 6d1fb23 (.)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
