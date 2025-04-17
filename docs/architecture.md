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
{
    protected $fillable = [
        'user_id',
        'type',
        'status',
        'version',
        'ip_address'
    ];

    protected $casts = [
        'status' => 'boolean',
        'metadata' => 'array'
    ];
}
```

#### Services
```php
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
    }
}
```

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
    }
}
```

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
        ];
    }
}
```

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
    }
}
```

### 2. Cifratura
- Dati sensibili cifrati
- Backup cifrati
- Comunicazioni sicure

### 3. Autorizzazione
- Ruoli granulari
- Permessi specifici
- Audit log

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
