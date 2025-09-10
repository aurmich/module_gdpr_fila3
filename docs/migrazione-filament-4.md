# GDPR Module - Migrazione a Filament 4

## Panoramica GDPR e Filament 4
Il modulo GDPR è **CRITICO** per compliance legale. La migrazione a Filament 4 deve essere gestita con **massima attenzione** per non compromettere funzionalità di compliance.

## 🔄 Modifiche Richieste per la Migrazione

### 1. ConsentResource - Schema Unificato
**Problemi attuali**: Model con PHPDoc duplicati massivi, fillable issues

**Prima (Filament 3 - Attuale):**
```php
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

public static function getFormSchema(): array
{
    return [
        'treatment_id' => Select::make('treatment_id')
            ->relationship('treatment', 'name')
            ->required(),
        'subject_id' => TextInput::make('subject_id')
            ->required()
            ->maxLength(191),
    ];
}
```

**Dopo (Filament 4 - Enhanced):**
```php
<?php

namespace Modules\Gdpr\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Schema\Schema;
use Filament\Schema\Components\Select;
use Filament\Schema\Components\TextInput;
use Filament\Schema\Components\Toggle;
use Filament\Schema\Components\DateTimePicker;
use Filament\Schema\Components\Section;
use Filament\Schema\Components\Textarea;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Modules\Gdpr\Models\Consent;

class ConsentResource extends Resource
{
    protected static ?string $model = Consent::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'GDPR Compliance';

    public static function schema(): Schema
    {
        return Schema::make([
            Section::make('Consent Information')->schema([
                Select::make('treatment_id')
                    ->relationship('treatment', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn ($state, callable $set) => 
                        $set('treatment_details', Treatment::find($state)?->description)),
                
                TextInput::make('subject_id')
                    ->required()
                    ->maxLength(191)
                    ->label('Data Subject ID'),
                    
                Select::make('user_type')
                    ->options([
                        'App\\Models\\User' => 'Registered User',
                        'App\\Models\\Customer' => 'Customer',
                        'guest' => 'Guest User',
                    ])
                    ->required(),
                    
                TextInput::make('user_id')
                    ->numeric()
                    ->required()
                    ->label('User ID'),
            ]),
            
            Section::make('Consent Details')->schema([
                Select::make('type')
                    ->options([
                        'marketing' => 'Marketing Communications',
                        'analytics' => 'Analytics & Tracking',
                        'necessary' => 'Necessary Cookies',
                        'preferences' => 'Preferences',
                        'profiling' => 'Profiling & Personalization',
                    ])
                    ->required(),
                    
                Toggle::make('is_active')
                    ->default(true)
                    ->label('Consent Active'),
                    
                DateTimePicker::make('accepted_at')
                    ->label('Consent Given At')
                    ->native(false),
                    
                DateTimePicker::make('withdrawn_at')
                    ->label('Consent Withdrawn At')
                    ->native(false),
                    
                Textarea::make('withdrawal_reason')
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]),
            
            Section::make('Audit Trail')->schema([
                TextInput::make('ip_address')
                    ->ip()
                    ->label('IP Address'),
                    
                Textarea::make('user_agent')
                    ->maxLength(1000)
                    ->columnSpanFull(),
                    
                Textarea::make('consent_context')
                    ->label('Context Information')
                    ->maxLength(1000)
                    ->columnSpanFull(),
            ])->visibleOn(['view', 'edit']),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('treatment.name')
                    ->searchable()
                    ->sortable()
                    ->label('Data Treatment'),
                    
                TextColumn::make('subject_id')
                    ->searchable()
                    ->label('Subject'),
                    
                BadgeColumn::make('type')
                    ->colors([
                        'success' => 'necessary',
                        'warning' => 'analytics',
                        'danger' => 'marketing',
                        'info' => 'preferences',
                        'purple' => 'profiling',
                    ]),
                    
                ToggleColumn::make('is_active')
                    ->disabled(), // Read-only for audit
                    
                TextColumn::make('accepted_at')
                    ->dateTime()
                    ->sortable(),
                    
                TextColumn::make('withdrawn_at')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Active'),
                    
                TextColumn::make('ip_address')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                // GDPR-specific actions
                Action::make('withdraw_consent')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->is_active)
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('withdrawal_reason')
                            ->required()
                            ->label('Reason for withdrawal'),
                    ])
                    ->action(function ($record, $data) {
                        $record->withdraw($data['withdrawal_reason']);
                    }),
                    
                Action::make('data_export')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(fn ($record) => $this->exportUserData($record)),
            ])
            ->filters([
                SelectFilter::make('treatment')
                    ->relationship('treatment', 'name'),
                    
                SelectFilter::make('type'),
                
                Filter::make('active_consents')
                    ->query(fn ($query) => $query->where('is_active', true)),
                    
                Filter::make('withdrawn_consents')
                    ->query(fn ($query) => $query->whereNotNull('withdrawn_at')),
            ]);
    }
}
```

### 2. TreatmentResource con Schema Unificato
**Fix per fillable vuoti e PHPDoc duplicati:**

```php
<?php

namespace Modules\Gdpr\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Schema\Schema;
use Filament\Schema\Components\TextInput;
use Filament\Schema\Components\Textarea;
use Filament\Schema\Components\Toggle;
use Filament\Schema\Components\Section;
use Filament\Schema\Components\FileUpload;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Modules\Gdpr\Models\Treatment;

class TreatmentResource extends Resource
{
    protected static ?string $model = Treatment::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'GDPR Compliance';

    public static function schema(): Schema
    {
        return Schema::make([
            Section::make('Treatment Details')->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    
                Textarea::make('description')
                    ->required()
                    ->maxLength(2000)
                    ->columnSpanFull(),
                    
                TextInput::make('legal_basis')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., Article 6(1)(a) GDPR - Consent'),
            ]),
            
            Section::make('Configuration')->schema([
                Toggle::make('active')
                    ->default(true),
                    
                Toggle::make('required')
                    ->default(false)
                    ->label('Required for Service'),
                    
                TextInput::make('weight')
                    ->numeric()
                    ->default(0)
                    ->label('Display Order'),
            ]),
            
            Section::make('Documentation')->schema([
                TextInput::make('document_version')
                    ->maxLength(50)
                    ->label('Version'),
                    
                TextInput::make('document_url')
                    ->url()
                    ->maxLength(500)
                    ->label('Privacy Policy URL'),
                    
                FileUpload::make('legal_documents')
                    ->multiple()
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('gdpr/treatments'),
            ]),
        ]);
    }
}
```

### 3. Nested Resources per Data Subject
**Filament 4 feature per gestire consensi nel contesto del subject:**

```php
// Data Subject -> Consents relationship
php artisan make:filament-resource Consent --nested=DataSubject

class DataSubjectConsentResource extends Resource
{
    protected static ?string $parentResource = DataSubjectResource::class;
    protected static string $relationship = 'consents';
    
    public static function getParentRelationship(): string 
    {
        return 'consents';
    }
    
    // URL: /admin/data-subjects/123/consents
}
```

### 4. GDPR Dashboard con Static Data
**Nuovo in Filament 4** - Compliance metrics senza Model:

```php
class GdprComplianceWidget extends Widget
{
    public function table(Table $table): Table
    {
        $metrics = $this->getComplianceMetrics();
        
        return $table
            ->records($metrics)
            ->columns([
                TextColumn::make('metric')
                    ->label('GDPR Metric'),
                TextColumn::make('value')
                    ->numeric()
                    ->color(fn ($record) => $record['status'] === 'compliant' ? 'success' : 'danger'),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('last_updated')
                    ->dateTime(),
            ]);
    }
    
    private function getComplianceMetrics(): array
    {
        return [
            [
                'metric' => 'Active Consents',
                'value' => Consent::active()->count(),
                'status' => 'compliant',
                'last_updated' => now(),
            ],
            [
                'metric' => 'Pending Withdrawals',
                'value' => ConsentWithdrawal::pending()->count(),
                'status' => $this->checkWithdrawalCompliance(),
                'last_updated' => now(),
            ],
            [
                'metric' => 'Data Retention Violations',
                'value' => $this->getRetentionViolations(),
                'status' => $this->checkRetentionCompliance(),
                'last_updated' => now(),
            ],
        ];
    }
}
```

## 🚀 Vantaggi della Migrazione GDPR

### 1. Enhanced Compliance Features
**MFA per proteggere dati sensibili:**
```php
// GDPR panel con security massima
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('gdpr')
        ->path('/gdpr-admin')
        ->authGuard('gdpr_admin')
        ->mfa([
            TwoFactor::class,
            EmailVerification::class,
        ])
        ->middleware(['gdpr.audit', 'ip.whitelist']);
}
```

### 2. Real-time Compliance Monitoring
- **Live consent status updates**
- **Automatic violation detection**  
- **Real-time audit logging**

### 3. Enhanced Data Subject Rights
```php
// Right to be Forgotten implementation
Action::make('forget_user')
    ->icon('heroicon-o-trash')
    ->color('danger')
    ->requiresConfirmation()
    ->form([
        Checkbox::make('confirm_legal_review')
            ->required()
            ->label('Confirmed legal review completed'),
    ])
    ->action(function ($record, $data) {
        app(GdprForgetService::class)->forgetUser($record);
    });
```

### 4. Automated Compliance Reports
**Static table data per report automatici:**
```php
// Monthly compliance report
public function getComplianceReport(): array
{
    return [
        'consent_requests' => ConsentRequest::thisMonth()->count(),
        'withdrawal_requests' => ConsentWithdrawal::thisMonth()->count(),
        'data_export_requests' => DataExportRequest::thisMonth()->count(),
        'deletion_requests' => DeletionRequest::thisMonth()->count(),
        'breach_incidents' => BreachIncident::thisMonth()->count(),
    ];
}
```

## ⚠️ Svantaggi e Rischi CRITICI

### 1. Compliance Risk Durante Migrazione
```bash
# RISCHIO MASSIMO: Downtime compliance functionality
⚠️  Legal liability se GDPR functionality offline
⚠️  Audit trail interruption
⚠️  Data breach risk durante migration
```

### 2. Model PHPDoc Duplications
**Problema attuale che complica migrazione:**
```php
// Treatment.php ha 4-5x duplicazioni PHPDoc
// Necessario cleanup PRIMA della migrazione
// Risk: IDE confusion, parser errors
```

### 3. Fillable Arrays Vuoti
```php
// Current Treatment model:
protected $fillable = ['']; // ❌ BROKEN

// Must fix BEFORE migration:
protected $fillable = [
    'name', 'description', 'active', 'required',
    'document_version', 'document_url', 'weight'
];
```

### 4. Data Migration Complexity
```sql
-- GDPR data migration must be atomic
BEGIN TRANSACTION;
  -- Update consent structures
  -- Migrate treatment data  
  -- Update audit logs
  -- Verify data integrity
COMMIT;
```

## 🎯 Piano di Migrazione GDPR (HIGH RISK)

### Fase 0: Critical Preparation (2-3 giorni)
1. 🆘 **CRITICAL**: Backup completo database GDPR
2. 🆘 **CRITICAL**: Legal review timeline
3. 🆘 **CRITICAL**: Downtime communication plan
4. 🆘 **CRITICAL**: Rollback strategy preparata

### Fase 1: Model Fixes (1-2 giorni)
1. 🧹 Fix PHPDoc duplications massive
2. 🧹 Fix fillable array vuoti
3. 🧹 Clean model relationships
4. 🧹 Verify data integrity

### Fase 2: Filament 4 Migration (3-4 giorni)
1. 🔄 Schema unificato per ConsentResource
2. 🔄 Schema unificato per TreatmentResource  
3. 🔄 Implement nested resources
4. 🔄 MFA setup per pannello GDPR

### Fase 3: Compliance Verification (2-3 giorni)
1. ✅ Verify all GDPR functionality
2. ✅ Test consent workflows
3. ✅ Test data export/deletion
4. ✅ Audit trail integrity check

### Fase 4: Legal Compliance Review (1-2 giorni)
1. ⚖️ Legal team review
2. ⚖️ Compliance officer approval
3. ⚖️ Document changes for auditors
4. ⚖️ Update privacy policies if needed

## 📋 Checklist GDPR Migration (MANDATORY)

### Pre-Migration (CRITICAL)
- [ ] **✅ Legal team notification 1 week prior**
- [ ] **✅ Complete database backup**
- [ ] **✅ PHPDoc cleanup completed**
- [ ] **✅ Fillable arrays fixed**
- [ ] **✅ Rollback plan documented**
- [ ] **✅ Downtime window approved**

### During Migration
- [ ] **🔒 GDPR functionality offline flag**
- [ ] **📊 Monitor data integrity**
- [ ] **🚨 Real-time issue tracking**
- [ ] **⏰ Timeline adherence**

### Post-Migration (MANDATORY)  
- [ ] **✅ All consent workflows tested**
- [ ] **✅ Data export functionality verified**
- [ ] **✅ Deletion workflows tested**
- [ ] **✅ Audit trail continuity verified**
- [ ] **✅ Legal compliance sign-off**
- [ ] **✅ Update compliance documentation**

## 💡 Raccomandazioni per GDPR Module

### ⚠️ ALTA CAUTELA RACCOMANDATA

**Motivi per rimandare la migrazione:**
1. **Legal liability risk** troppo alto
2. **Compliance downtime** inaccettabile
3. **Model issues** devono essere risolti prima
4. **Team legal** deve essere coinvolto

### ✅ Procedere SOLO SE:

1. **Legal approval** esplicito ottenuto
2. **Maintenance window** di almeno 48h disponibile
3. **Model cleanup** completato prima
4. **Rollback plan** testato e approvato
5. **Compliance officer** presente durante migrazione

## 🕐 Timeline Stimato GDPR Module

**EXTENDED TIMELINE per compliance:**
- **Pre-migration cleanup**: 3-4 giorni
- **Legal review**: 2-3 giorni  
- **Migration execution**: 4-5 giorni
- **Compliance testing**: 3-4 giorni
- **Legal sign-off**: 1-2 giorni
- **Documentation update**: 1-2 giorni

**TOTALE: 14-20 giorni lavorativi**

## 🔮 Conclusioni GDPR Module

**⚠️ MIGRAZIONE AD ALTO RISCHIO ⚠️**

**Raccomandazione**: **RIMANDARE** la migrazione fino a quando:
1. ✅ Model issues corretti completamente
2. ✅ Legal team ha approvato timeline
3. ✅ Rollback strategy testata
4. ✅ Compliance testing framework pronto
5. ✅ Business può permettersi 48h downtime

**Alternative approach**: 
- Mantenere GDPR su Filament 3 stabile
- Migrare altri moduli prima
- Pianificare GDPR migration come progetto separato con risorse dedicate

**PRIORITÀ**: **Legal compliance > New features**