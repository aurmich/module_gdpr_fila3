https://github.com/andrewdwallo/filament-companies

# Filament Integration Modulo GDPR

## Panoramica
Il modulo GDPR si integra con Filament per fornire un'interfaccia amministrativa completa per la gestione della privacy e dei consensi.

## Resources

### ConsentResource
```php
namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;

class ConsentResource extends XotBaseResource
{
    protected static string $model = Consent::class;

    public static function getNavigationGroup(): ?string
    {
        return __('gdpr::navigation.privacy');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('type')
                ->options([
                    'marketing' => 'Marketing',
                    'analytics' => 'Analytics',
                ])
                ->required()
                ->translateLabel(),

            Toggle::make('value')
                ->required()
                ->translateLabel(),

            DateTimePicker::make('expires_at')
                ->required()
                ->translateLabel(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->translateLabel()
                    ->sortable(),
                Tables\Columns\IconColumn::make('value')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expires_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'marketing' => 'Marketing',
                        'analytics' => 'Analytics',
                    ]),
                Tables\Filters\TernaryFilter::make('value'),
                Tables\Filters\Filter::make('expires_at')
                    ->form([
                        DatePicker::make('expires_from'),
                        DatePicker::make('expires_until'),
                    ]),
            ]);
    }
}
```

### DataExportResource
```php
namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class DataExportResource extends XotBaseResource
{
    protected static string $model = DataExport::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('format')
                ->options([
                    'json' => 'JSON',
                    'csv' => 'CSV',
                    'pdf' => 'PDF',
                ])
                ->required(),

            CheckboxList::make('data_types')
                ->options([
                    'profile' => 'Dati Profilo',
                    'consents' => 'Consensi',
                    'activity' => 'Attività',
                ])
                ->required(),
        ]);
    }
}
```

## Pages

### Privacy Dashboard
```php
namespace Modules\Gdpr\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class PrivacyDashboard extends XotBasePage
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static string $view = 'gdpr::filament.pages.privacy-dashboard';

    protected function getHeaderWidgets(): array
    {
        return [
            ConsentOverview::class,
            ExportRequests::class,
            DataBreaches::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            ConsentTimeline::class,
            DataAccessLog::class,
        ];
    }
}
```

## Widgets

### ConsentOverview
```php
namespace Modules\Gdpr\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ConsentOverview extends XotBaseWidget
{
    protected static string $view = 'gdpr::filament.widgets.consent-overview';
    
    protected function getViewData(): array
    {
        return [
            'total_consents' => Consent::count(),
            'active_consents' => Consent::where('value', true)->count(),
            'expired_consents' => Consent::where('expires_at', '<', now())->count(),
        ];
    }

    protected function getChartData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Consensi Attivi',
                    'data' => $this->getConsentTrend(),
                ],
            ],
        ];
    }
}
```

### DataAccessLog
```php
namespace Modules\Gdpr\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

class DataAccessLog extends XotBaseWidget
{
    protected int $sort = 2;
    protected static string $view = 'gdpr::filament.widgets.data-access-log';

    protected function getData(): array
    {
        return Activity::query()
            ->where('log_name', 'data_access')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                return [
                    'user' => $activity->causer->name,
                    'action' => $activity->description,
                    'date' => $activity->created_at->diffForHumans(),
                ];
            })
            ->toArray();
    }
}
```

## Actions

### ExportAction
```php
namespace Modules\Gdpr\Filament\Actions;

use Modules\Xot\Filament\Actions\XotBaseAction;

class ExportAction extends XotBaseAction
{
    public static function getDefaultName(): ?string
    {
        return 'export';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('gdpr::actions.export.label'))
            ->modalHeading(__('gdpr::actions.export.modal.heading'))
            ->modalButton(__('gdpr::actions.export.modal.button'))
            ->successNotificationTitle(__('gdpr::actions.export.success'));
    }

    public function handle(Model $record, array $data): void
    {
        ProcessDataExport::dispatch($record, $data['format']);
    }
}
```

## Traduzione

### Italiano
```php
// lang/it/filament-gdpr.php
return [
    'navigation' => [
        'privacy' => 'Privacy',
    ],
    'resources' => [
        'consent' => [
            'label' => 'Consenso',
            'plural_label' => 'Consensi',
            'fields' => [
                'type' => 'Tipo',
                'value' => 'Valore',
                'expires_at' => 'Scadenza',
            ],
        ],
    ],
    'widgets' => [
        'consent_overview' => [
            'title' => 'Panoramica Consensi',
            'description' => 'Stato dei consensi degli utenti',
        ],
    ],
];
```

## Views

### Privacy Dashboard
```php
// resources/views/filament/pages/privacy-dashboard.blade.php
<x-filament::page>
    <x-filament::grid>
        @foreach ($this->getHeaderWidgets() as $widget)
            {{ $widget }}
        @endforeach
    </x-filament::grid>

    <x-filament::card>
        <div class="prose dark:prose-invert">
            {!! Str::markdown($this->getPrivacyOverview()) !!}
        </div>
    </x-filament::card>

    <x-filament::grid>
        @foreach ($this->getFooterWidgets() as $widget)
            {{ $widget }}
        @endforeach
    </x-filament::grid>
</x-filament::page>
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Filament User](../User/docs/filament.md)
- [Filament Activity](../Activity/docs/filament.md)
- [Filament Xot](../Xot/docs/filament.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Configurazione](./configuration.md)
- [API](./api.md)

## Collegamenti tra versioni di filament.md
* [filament.md](docs/tecnico/filament/filament.md)
* [filament.md](laravel/Modules/Chart/docs/filament.md)
* [filament.md](laravel/Modules/Gdpr/docs/filament.md)
* [filament.md](laravel/Modules/Xot/docs/technical/filament.md)
* [filament.md](laravel/Modules/Xot/docs/roadmap/integration/filament.md)
* [filament.md](laravel/Modules/Lang/docs/filament.md)
* [filament.md](laravel/Modules/Job/docs/filament.md)
* [filament.md](laravel/Modules/Activity/docs/filament.md)
* [filament.md](laravel/Modules/Cms/docs/filament.md)

