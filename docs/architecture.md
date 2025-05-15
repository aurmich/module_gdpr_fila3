<<<<<<< HEAD
# Architettura Modulo GDPR

## Struttura del Modulo

```
Modules/Gdpr/
├── Config/
│   └── config.php
├── Console/
│   └── Commands/
├── Database/
│   ├── Factories/
│   ├── Migrations/
│   └── Seeders/
├── Filament/
│   ├── Resources/
│   ├── Pages/
│   └── Widgets/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
├── Policies/
├── Providers/
├── Resources/
│   ├── lang/
│   └── views/
├── Services/
├── Tests/
└── docs/
```

## Layer Architetturali

### 1. Presentation Layer

#### Filament Resources
```php
namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class ConsentResource extends XotBaseResource
{
    protected static string $model = Consent::class;
    
    public static function getNavigationGroup(): ?string
    {
        return __('gdpr::navigation.privacy');
    }
}
```

#### Controllers
```php
namespace Modules\Gdpr\Http\Controllers;

use Modules\Xot\Http\Controllers\XotBaseController;

class ConsentController extends XotBaseController
{
    public function __construct(
        private readonly ConsentService $service
    ) {}

    public function store(ConsentRequest $request): JsonResponse
    {
        $consent = $this->service->createConsent($request->validated());
        return response()->json($consent, 201);
    }
}
```

### 2. Domain Layer

#### Models
```php
namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBaseModel;

class Consent extends XotBaseModel
=======
# Architettura del Modulo GDPR

## Panoramica
L'architettura del modulo GDPR è progettata per garantire la massima conformità al GDPR, sicurezza e scalabilità. Il modulo segue i principi di:
- Privacy by Design
- Security by Default
- Scalabilità orizzontale
- Manutenibilità

## Componenti Principali

### 1. Core
#### Models
```php
class Consent extends Model
>>>>>>> 60290b2 (.)
{
    protected $fillable = [
        'user_id',
        'type',
<<<<<<< HEAD
        'value',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'boolean',
        'expires_at' => 'datetime',
=======
        'status',
        'version',
        'ip_address'
    ];

    protected $casts = [
        'status' => 'boolean',
        'metadata' => 'array'
>>>>>>> 60290b2 (.)
    ];
}
```

#### Services
```php
<<<<<<< HEAD
namespace Modules\Gdpr\Services;

class ConsentService
{
    public function __construct(
        private readonly ConsentRepository $repository,
        private readonly ConsentValidator $validator
    ) {}

    public function createConsent(array $data): Consent
    {
        $this->validator->validate($data);
        return $this->repository->create($data);
=======
class ConsentService
{
    public function storeConsent(User $user, array $data): Consent
    {
        return DB::transaction(function () use ($user, $data) {
            $consent = new Consent([
                'user_id' => $user->id,
                'type' => $data['type'],
                'status' => $data['status'],
                'version' => $data['version'],
                'ip_address' => request()->ip()
            ]);

            $consent->save();

            event(new ConsentStored($consent));

            return $consent;
        });
>>>>>>> 60290b2 (.)
    }
}
```

<<<<<<< HEAD
### 3. Data Layer

#### Repositories
```php
namespace Modules\Gdpr\Repositories;

use Modules\Xot\Repositories\XotBaseRepository;

class ConsentRepository extends XotBaseRepository
{
    public function getValidConsents(User $user): Collection
    {
        return $this->model
            ->where('user_id', $user->id)
            ->where('expires_at', '>', now())
            ->get();
=======
### 2. Database
#### Migrazioni
```php
Schema::create('consents', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('type');
    $table->boolean('status');
    $table->string('version');
    $table->string('ip_address');
    $table->json('metadata')->nullable();
    $table->timestamps();
    
    $table->index(['user_id', 'type']);
});
```

#### Indici
- `user_id, type` per query frequenti
- `created_at` per report e analisi
- `status` per filtri comuni

### 3. API
#### Controller
```php
class ConsentController extends Controller
{
    public function store(StoreConsentRequest $request)
    {
        $consent = $this->consentService->storeConsent(
            $request->user(),
            $request->validated()
        );

        return new ConsentResource($consent);
>>>>>>> 60290b2 (.)
    }
}
```

<<<<<<< HEAD
#### Factories
```php
namespace Modules\Gdpr\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConsentFactory extends Factory
{
    protected $model = Consent::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['marketing', 'analytics']),
            'value' => $this->faker->boolean,
            'expires_at' => now()->addDays(30),
=======
#### Middleware
```php
class ValidateConsent
{
    public function handle($request, Closure $next)
    {
        if (!$request->user()->hasValidConsent()) {
            return response()->json([
                'message' => 'Consenso non valido'
            ], 403);
        }

        return $next($request);
    }
}
```

### 4. UI
#### Componenti
```php
class ConsentBanner extends Component
{
    public function render()
    {
        return view('gdpr::components.consent-banner', [
            'consents' => $this->getRequiredConsents()
        ]);
    }
}
```

## Flusso dei Dati

### 1. Raccolta Consensi
1. Utente visita il sito
2. Banner mostra richiesta consenso
3. Utente accetta/rifiuta
4. Sistema registra consenso
5. Sistema applica preferenze

### 2. Log Attività
1. Evento utente rilevato
2. Sistema verifica consenso
3. Sistema registra attività
4. Sistema notifica se necessario

### 3. Backup Dati
1. Sistema pianifica backup
2. Sistema cifra dati
3. Sistema trasferisce backup
4. Sistema verifica integrità

## Pattern Utilizzati

### 1. Repository
```php
class ConsentRepository
{
    public function getLatestConsent(User $user, string $type): ?Consent
    {
        return Consent::where('user_id', $user->id)
            ->where('type', $type)
            ->latest()
            ->first();
    }
}
```

### 2. Observer
```php
class ConsentObserver
{
    public function created(Consent $consent)
    {
        event(new ConsentCreated($consent));
    }
}
```

### 3. Factory
```php
class ConsentFactory extends Factory
{
    public function definition()
    {
        return [
            'type' => $this->faker->randomElement(['cookie', 'privacy', 'marketing']),
            'status' => $this->faker->boolean,
            'version' => '1.0.0',
            'ip_address' => $this->faker->ipv4
>>>>>>> 60290b2 (.)
        ];
    }
}
```

<<<<<<< HEAD
## Componenti Principali

### 1. Service Provider
```php
namespace Modules\Gdpr\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class GdprServiceProvider extends XotBaseServiceProvider
{
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
    
    public function boot(): void
    {
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom($this->module_dir.'/../Database/Migrations');
    }
}
```

### 2. Event System
```php
namespace Modules\Gdpr\Events;

class ConsentGranted
{
    public function __construct(
        public readonly Consent $consent,
        public readonly User $user
    ) {}
}

class ConsentListener
{
    public function handle(ConsentGranted $event): void
    {
        activity()
            ->performedOn($event->consent)
            ->causedBy($event->user)
            ->log('consent_granted');
    }
}
```

### 3. Job Queue
```php
namespace Modules\Gdpr\Jobs;

class ProcessDataExport implements ShouldQueue
{
    public function __construct(
        private readonly User $user,
        private readonly string $format
    ) {}

    public function handle(ExportService $service): void
    {
        $service->exportUserData($this->user, $this->format);
    }
}
```

## Pattern Utilizzati

### 1. Repository Pattern
- Separazione della logica di accesso ai dati
- Interfacce standardizzate per le operazioni CRUD
- Facilitazione dei test unitari

### 2. Service Layer
- Incapsulamento della logica di business
- Coordinamento tra repository e altri servizi
- Gestione delle transazioni

### 3. Factory Pattern
- Creazione standardizzata di oggetti
- Supporto per i test
- Generazione dati di esempio

### 4. Observer Pattern
- Gestione eventi GDPR
- Notifiche asincrone
- Audit logging

## Integrazione con Altri Moduli

### 1. User Module
```php
use Modules\Gdpr\Traits\HasGdprConsent;

class User extends XotBaseUser
{
    use HasGdprConsent;
}
```

### 2. Activity Module
```php
use Modules\Gdpr\Traits\LogsGdprActivity;

class GdprActivity extends Activity
{
    use LogsGdprActivity;
}
```

### 3. Notify Module
```php
use Modules\Gdpr\Events\ConsentExpiring;

class ConsentExpirationNotification extends Notification
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Consenso in scadenza')
            ->line('Il tuo consenso sta per scadere.');
=======
## Performance

### 1. Caching
- Cache consensi attivi
- Cache configurazioni
- Cache report

### 2. Queue
- Backup in background
- Notifiche asincrone
- Elaborazione batch

### 3. Database
- Indici ottimizzati
- Query ottimizzate
- Partizionamento dati

## Sicurezza

### 1. Validazione
```php
class StoreConsentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'type' => ['required', 'string', 'in:cookie,privacy,marketing'],
            'status' => ['required', 'boolean'],
            'version' => ['required', 'string']
        ];
>>>>>>> 60290b2 (.)
    }
}
```

<<<<<<< HEAD
## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Architettura User](../User/docs/architecture.md)
- [Architettura Activity](../Activity/docs/architecture.md)
- [Architettura Xot](../Xot/docs/architecture.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Implementazione](./implementation.md)
- [Configurazione](./configuration.md)
- [Security](./security.md) 
=======
### 2. Cifratura
- Dati sensibili cifrati
- Backup cifrati
- Comunicazioni sicure

### 3. Autorizzazione
- Ruoli granulari
- Permessi specifici
- Audit log

>>>>>>> 60290b2 (.)
## Estensibilità

### 1. Eventi
```php
interface ConsentEvents
{
    const CREATED = 'consent.created';
    const UPDATED = 'consent.updated';
    const DELETED = 'consent.deleted';
}
```

### 2. Middleware
```php
class GdprMiddleware
{
    public function handle($request, Closure $next)
    {
        // Logica personalizzabile
        return $next($request);
    }
}
```

## Collegamenti
- [README](../README.md)
- [Sviluppo](development.md)
- [Pacchetti](packages.md)
- [Roadmap](roadmap.md) 
<<<<<<< HEAD

## Collegamenti tra versioni di architecture.md
* [architecture.md](docs/tecnico/filament/architecture.md)
* [architecture.md](docs/rules/architecture.md)
* [architecture.md](laravel/Modules/Gdpr/docs/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/frontoffice/architecture.md)
* [architecture.md](laravel/Modules/Cms/docs/architecture.md)
* [architecture.md](laravel/Themes/One/docs/roadmap/inspiration/architecture.md)

=======
>>>>>>> 60290b2 (.)
