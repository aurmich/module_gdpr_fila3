<<<<<<< HEAD
# Implementazione Modulo GDPR

## Struttura

### Models
```php
namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBaseModel;

class Consent extends XotBaseModel
{
    protected $fillable = [
        'user_id',
        'type',
        'value',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'boolean',
        'expires_at' => 'datetime',
    ];
}
```

### Controllers
```php
namespace Modules\Gdpr\Http\Controllers;

use Modules\Xot\Http\Controllers\XotBaseController;

class ConsentController extends XotBaseController
{
    public function store(ConsentRequest $request): JsonResponse
    {
        $consent = Consent::create($request->validated());
        
        event(new ConsentGiven($consent));
        
        return response()->json($consent);
    }
}
```

### Requests
```php
namespace Modules\Gdpr\Http\Requests;

use Modules\Xot\Http\Requests\XotBaseRequest;

class ConsentRequest extends XotBaseRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'in:marketing,analytics'],
            'value' => ['required', 'boolean'],
        ];
    }
}
```

## Filament Integration

### Resources
```php
namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
    protected static string $model = Consent::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->options([
                    'marketing' => 'Marketing',
                    'analytics' => 'Analytics',
                ])
                ->required(),
            Forms\Components\Toggle::make('value')
                ->required(),
            Forms\Components\DateTimePicker::make('expires_at')
                ->required(),
        ]);
=======
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
>>>>>>> 60290b2 (.)
    }
}
```

### Widgets
```php
namespace Modules\Gdpr\Filament\Widgets;

<<<<<<< HEAD
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class ConsentOverview extends XotBaseWidget
{
    protected static string $view = 'gdpr::widgets.consent-overview';
    
    protected function getViewData(): array
    {
        return [
            'total_consents' => Consent::count(),
            'active_consents' => Consent::where('value', true)->count(),
            'expired_consents' => Consent::where('expires_at', '<', now())->count(),
=======
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
>>>>>>> 60290b2 (.)
        ];
    }
}
```

<<<<<<< HEAD
## Traits

### HasGdprConsent
```php
namespace Modules\Gdpr\Traits;

trait HasGdprConsent
{
    public function consents(): HasMany
    {
        return $this->hasMany(Consent::class);
    }

    public function hasValidConsent(string $type): bool
    {
        return $this->consents()
            ->where('type', $type)
            ->where('value', true)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
```

### LogsGdprActivity
```php
namespace Modules\Gdpr\Traits;

trait LogsGdprActivity
{
    public function logConsentActivity(Consent $consent): void
    {
        activity()
            ->performedOn($consent)
            ->withProperties([
                'type' => $consent->type,
                'value' => $consent->value,
                'expires_at' => $consent->expires_at,
            ])
            ->log('consent_updated');
    }
}
```

## Eventi

### ConsentGiven
```php
namespace Modules\Gdpr\Events;

class ConsentGiven extends Event
{
    public function __construct(
        public readonly Consent $consent
    ) {}
}
```

### DataExported
```php
namespace Modules\Gdpr\Events;

class DataExported extends Event
{
    public function __construct(
        public readonly User $user,
        public readonly string $format
    ) {}
}
```

## Jobs

### ProcessDataExport
```php
namespace Modules\Gdpr\Jobs;

class ProcessDataExport implements ShouldQueue
{
    public function __construct(
        private readonly User $user,
        private readonly string $format
    ) {}

    public function handle(): void
    {
        $exporter = match ($this->format) {
            'json' => new JsonExporter(),
            'csv' => new CsvExporter(),
            'pdf' => new PdfExporter(),
        };

        $data = $exporter->export($this->user);
        
        event(new DataExported($this->user, $this->format));
=======
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
>>>>>>> 60290b2 (.)
    }
}
```

<<<<<<< HEAD
## Middleware

### EnsureValidConsent
```php
namespace Modules\Gdpr\Http\Middleware;

class EnsureValidConsent
{
    public function handle(Request $request, Closure $next, string $type): Response
    {
        if (! $request->user()?->hasValidConsent($type)) {
            return redirect()->route('gdpr.consent.form', ['type' => $type]);
        }

        return $next($request);
    }
}
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Implementazione User](../User/docs/implementation.md)
- [Implementazione Activity](../Activity/docs/implementation.md)
- [Implementazione Xot](../Xot/docs/implementation.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Configurazione](./configuration.md)
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md) 
``` 

## Collegamenti tra versioni di implementation.md
* [implementation.md](laravel/Modules/Gdpr/docs/implementation.md)
* [implementation.md](laravel/Modules/Xot/docs/implementation.md)
* [implementation.md](laravel/Modules/Job/docs/implementation.md)

=======
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
>>>>>>> 60290b2 (.)
