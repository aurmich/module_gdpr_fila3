<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Clusters\Profile\Resources;

use Modules\Gdpr\Filament\Clusters\Profile as ProfileCluster;
use Modules\Gdpr\Filament\Clusters\Profile\Resources\ConsentResource\Pages;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
<<<<<<< HEAD
    protected static null|string $model = Consent::class;

    protected static null|string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static null|string $cluster = ProfileCluster::class;

    #[\Override]
    public static function getFormSchema(): array
    {
        return [];
    }

    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    #[\Override]
=======
    protected static ?string $model = Consent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = ProfileCluster::class;

    public static function getFormSchema(): array
    {
        return [
        ];
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

>>>>>>> 6d1fb23 (.)
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConsents::route('/'),
            'create' => Pages\CreateConsent::route('/create'),
            'edit' => Pages\EditConsent::route('/{record}/edit'),
        ];
    }
}
