# Implementazione Gdpr

## Struttura del Codice

### Convenzioni
- Seguire PSR-12 per lo stile del codice
- Mantenere una lunghezza massima di 120 caratteri per riga
- Utilizzare indentazione di 4 spazi
- Inserire una riga vuota tra i metodi
- Utilizzare parentesi graffe su nuova riga per classi e metodi

### Nomenclatura
- **Classi**: PascalCase (es. `GdprConsentResource`)
- **Metodi**: camelCase (es. `validateConsent`)
- **Variabili**: camelCase (es. `consentStatus`)
- **Costanti**: UPPER_SNAKE_CASE (es. `MAX_CONSENTS`)
- **Interfacce**: PascalCase con suffisso Interface (es. `ConsentServiceInterface`)
- **Trait**: PascalCase con suffisso Trait (es. `ConsentTrait`)

### Type Hinting
- Utilizzare sempre type hints per parametri e return types
- Utilizzare tipi nullable quando appropriato (es. `?string`)
- Utilizzare union types quando necessario (es. `string|int`)
- Utilizzare mixed solo quando strettamente necessario

## Architettura

### Pattern Utilizzati
- Repository Pattern per l'accesso ai dati
- Service Layer per la logica di business
- Factory Pattern per la creazione di oggetti complessi
- Observer Pattern per eventi e notifiche
- Strategy Pattern per algoritmi variabili

### Directory Structure
```
Gdpr/
├── Console/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Models/
├── Providers/
├── Services/
└── Traits/
```

## Implementazione Filament

### Resource Base
```php
namespace Modules\Gdpr\Filament\Resources;

use Filament\Resources\Resource;

class GdprResource extends Resource
{
    protected static ?string $model = null;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Gdpr';
    
    public static function getNavigationLabel(): string
    {
        return static::$navigationLabel ?? Str::headline(static::getModelLabel());
    }
}
```

### Pages
```php
namespace Modules\Gdpr\Filament\Pages;

use Filament\Pages\Page;

class ConsentPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'Gdpr';
    protected static string $view = 'gdpr::filament.pages.consent';
    
    public function mount()
    {
        $this->form->fill([
            'consents' => $this->getConsents(),
        ]);
    }
    
    protected function getFormSchema(): array
    {
        return [
            Forms\Components\CheckboxList::make('consents')
                ->label('Consensi')
                ->options([
                    'marketing' => 'Marketing',
                    'analytics' => 'Analytics',
                    'privacy' => 'Privacy',
                ])
                ->required(),
        ];
    }
}
```

### Widgets
```php
namespace Modules\Gdpr\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class GdprStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Consensi', Consent::count())
                ->description('Consensi registrati')
                ->descriptionIcon('heroicon-m-check-circle'),
            Stat::make('Richieste', Request::count())
                ->description('Richieste GDPR')
                ->descriptionIcon('heroicon-m-document-text'),
        ];
    }
}
```

## Servizi

### Gestione Consensi
```php
namespace Modules\Gdpr\Services;

interface ConsentServiceInterface
{
    public function giveConsent(string $type, array $data): void;
    public function withdrawConsent(string $type): void;
    public function getConsents(string $type): array;
    public function hasConsent(string $type): bool;
}
```

### Gestione Richieste
```php
namespace Modules\Gdpr\Services;

interface RequestServiceInterface
{
    public function submitRequest(string $type, array $data): void;
    public function processRequest(string $id): void;
    public function getRequestStatus(string $id): array;
    public function getRequestsByType(string $type): array;
}
```

## Database

### Convenzioni
- Nomi tabelle in snake_case plurale (es. `gdpr_consents`)
- Nomi colonne in snake_case (es. `consent_type`)
- Chiavi esterne: `{table}_id` (es. `user_id`)
- Timestamps: `created_at`, `updated_at`, `deleted_at`
- Soft deletes per tutte le tabelle principali

### Migrazioni
```php
Schema::create('consents', function (Blueprint $table) {
    $table->id();
    $table->string('type');
    $table->morphs('consentable');
    $table->json('data')->nullable();
    $table->boolean('active')->default(true);
    $table->timestamps();
    $table->softDeletes();
});

Schema::create('gdpr_requests', function (Blueprint $table) {
    $table->id();
    $table->string('type');
    $table->morphs('requestable');
    $table->json('data')->nullable();
    $table->string('status');
    $table->timestamps();
    $table->softDeletes();
});
```

### Indici
```php
Schema::table('consents', function (Blueprint $table) {
    $table->index(['type', 'active']);
    $table->index(['consentable_type', 'consentable_id']);
});

Schema::table('gdpr_requests', function (Blueprint $table) {
    $table->index(['type', 'status']);
    $table->index(['requestable_type', 'requestable_id']);
});
```

## Frontend

### Views
```php
// resources/views/gdpr/consent.blade.php
<x-filament::page>
    <x-filament::form wire:submit="save">
        <x-filament::card>
            <x-filament::form-section>
                <x-slot name="title">
                    Gestione Consensi
                </x-slot>

                <x-slot name="description">
                    Gestisci i tuoi consensi per il trattamento dei dati personali
                </x-slot>

                {{ $this->form }}
            </x-filament::form-section>
        </x-filament::card>
    </x-filament::form>
</x-filament::page>
```

### Folio
```php
// routes/folio.php
Route::get('/consent', \Modules\Gdpr\Filament\Pages\ConsentPage::class);
```

## Testing

### Convenzioni
- Test unitari per ogni classe
- Test di integrazione per flussi complessi
- Test di feature per Filament e Folio
- Utilizzare data providers quando appropriato
- Seguire il pattern "given-when-then"

### Unit Tests
```php
class ConsentServiceTest extends TestCase
{
    public function test_give_consent()
    {
        $type = 'marketing';
        $data = ['channel' => 'email'];
        
        $this->consentService->giveConsent($type, $data);
        
        $consent = Consent::where('type', $type)->first();
        $this->assertNotNull($consent);
        $this->assertTrue($consent->active);
    }
}
```

### Feature Tests
```php
class ConsentPageTest extends TestCase
{
    public function test_can_render_consent_page()
    {
        $this->get('/consent')
            ->assertStatus(200)
            ->assertSee('Gestione Consensi');
    }
    
    public function test_can_save_consents()
    {
        $this->post('/consent', [
            'consents' => ['marketing', 'analytics']
        ])
        ->assertStatus(200)
        ->assertSessionHas('success');
    }
}
``` 
