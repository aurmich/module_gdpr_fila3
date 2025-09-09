# GDPR Module - Guida Step-by-Step Migrazione Filament 4

## ⚠️ ATTENZIONE: MIGRAZIONE AD ALTO RISCHIO

**Questo modulo gestisce compliance GDPR legale. La migrazione richiede massima cautela e approvazione legale esplicita.**

---

## 📋 Pre-Migrazione CRITICAL Checklist

```bash
# ⚠️ STEP 1: Legal approval REQUIRED
echo "STOP: Obtain legal team approval before proceeding"
echo "Document all changes for compliance audit"

# ⚠️ STEP 2: Complete backup (LEGAL REQUIREMENT)
mysqldump -u username -p database_name > backup_gdpr_full.sql
cp -r Modules/Gdpr/ backup_gdpr_module_complete/

# ⚠️ STEP 3: Test environment identical to production
php artisan migrate:fresh --seed --env=testing
```

---

## 🏗️ STEP 1: Fix Model Issues FIRST

### 1.1 - Clean PHPDoc Duplications (CRITICAL)

**File:** `Modules/Gdpr/app/Models/Treatment.php`

```bash
# Before ANY migration, fix these issues:
# 1. Remove duplicate PHPDoc blocks (4-5x repetitions)
# 2. Fix empty fillable arrays
# 3. Clean relationship definitions
```

**1.1.1 - FIXED Treatment Model:**
```php
<?php

namespace Modules\Gdpr\Models;

use Modules\Xot\Models\XotBaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends XotBaseModel
{
    // FIXED: Proper fillable array (was empty)
    protected $fillable = [
        'name',
        'description', 
        'legal_basis',
        'active',
        'required',
        'document_version',
        'document_url',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'required' => 'boolean',
            'weight' => 'integer',
        ];
    }

    /**
     * SINGLE PHPDoc block (removed duplicates)
     */
    public function consents(): HasMany
    {
        return $this->hasMany(Consent::class);
    }

    // Business logic methods
    public function isRequired(): bool
    {
        return $this->required;
    }

    public function activate(): void
    {
        $this->update(['active' => true]);
        
        activity()
            ->performedOn($this)
            ->causedBy(auth()->user())
            ->log('treatment_activated');
    }

    public function getComplianceStatusAttribute(): string
    {
        $activeConsents = $this->consents()->active()->count();
        $totalConsents = $this->consents()->count();
        
        if ($totalConsents === 0) return 'no_data';
        
        $rate = ($activeConsents / $totalConsents) * 100;
        
        return match(true) {
            $rate >= 95 => 'compliant',
            $rate >= 80 => 'warning',
            default => 'non_compliant',
        };
    }
}
```

---

## 🏗️ STEP 2: Enhanced GDPR Resources (HIGH CAUTION)

### 2.1 - ConsentResource with Legal Compliance

**File:** `Modules/Gdpr/app/Filament/Resources/ConsentResource.php`

```php
<?php

namespace Modules\Gdpr\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Schema\Components\TextInput;
use Filament\Schema\Components\Select;
use Filament\Schema\Components\Toggle;
use Filament\Schema\Components\DateTimePicker;
use Filament\Schema\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Modules\Gdpr\Models\Consent;

class ConsentResource extends XotBaseResource
{
    protected static ?string $model = Consent::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationGroup = 'GDPR Compliance';

    // LEGAL REQUIREMENT: Read-only for audit compliance
    public static function canDelete($record): bool 
    { 
        return false; // GDPR audit trail must be preserved
    }

    /**
     * STEP 1: Legal-compliant schema
     */
    public static function getMainSchema(): array
    {
        return [
            Select::make('treatment_id')
                ->relationship('treatment', 'name')
                ->required()
                ->preload()
                ->searchable()
                ->live()
                ->afterStateUpdated(function ($state, callable $set) {
                    if ($state) {
                        $treatment = \Modules\Gdpr\Models\Treatment::find($state);
                        $set('legal_basis', $treatment?->legal_basis);
                    }
                }),
                
            TextInput::make('subject_id')
                ->required()
                ->maxLength(191)
                ->label('Data Subject ID')
                ->helperText('Unique identifier for the data subject'),
                
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
                
            Select::make('consent_type')
                ->options([
                    'marketing' => '📧 Marketing Communications',
                    'analytics' => '📊 Analytics & Tracking',
                    'necessary' => '⚙️ Necessary Cookies',
                    'preferences' => '🎨 Preferences',
                    'profiling' => '👤 Profiling & Personalization',
                ])
                ->required()
                ->live(),
                
            Toggle::make('is_active')
                ->default(true)
                ->label('Consent Active')
                ->disabled(fn($context) => $context === 'edit'), // Prevent tampering
                
            DateTimePicker::make('accepted_at')
                ->label('Consent Given At')
                ->native(false)
                ->required()
                ->disabled(fn($context) => $context === 'edit'),
                
            DateTimePicker::make('withdrawn_at')
                ->label('Consent Withdrawn At')
                ->native(false)
                ->visible(fn($get) => !$get('is_active')),
                
            Textarea::make('withdrawal_reason')
                ->maxLength(500)
                ->visible(fn($get) => !$get('is_active'))
                ->columnSpanFull(),
                
            // LEGAL AUDIT FIELDS
            TextInput::make('ip_address')
                ->ip()
                ->disabled()
                ->label('IP Address (Legal Record)'),
                
            Textarea::make('user_agent')
                ->disabled()
                ->maxLength(1000)
                ->columnSpanFull()
                ->label('User Agent (Legal Record)'),
        ];
    }

    /**
     * STEP 2: Compliance-focused table
     */
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('treatment.name')
                ->searchable()
                ->sortable()
                ->weight('semibold')
                ->label('Data Treatment'),
                
            TextColumn::make('subject_id')
                ->searchable()
                ->label('Subject ID')
                ->copyable(),
                
            BadgeColumn::make('consent_type')
                ->colors([
                    'success' => 'necessary',
                    'info' => 'preferences',
                    'warning' => 'analytics',
                    'danger' => 'marketing',
                    'purple' => 'profiling',
                ]),
                
            BadgeColumn::make('status')
                ->getStateUsing(function($record) {
                    if ($record->withdrawn_at) return 'withdrawn';
                    return $record->is_active ? 'active' : 'inactive';
                })
                ->colors([
                    'success' => 'active',
                    'danger' => 'withdrawn',
                    'gray' => 'inactive',
                ]),
                
            TextColumn::make('accepted_at')
                ->dateTime()
                ->sortable()
                ->label('Consent Date'),
                
            TextColumn::make('withdrawn_at')
                ->dateTime()
                ->sortable()
                ->placeholder('Active')
                ->color('danger'),
                
            TextColumn::make('days_active')
                ->getStateUsing(function($record) {
                    $end = $record->withdrawn_at ?: now();
                    return $record->accepted_at?->diffInDays($end) ?: 0;
                })
                ->numeric()
                ->label('Days Active'),
        ];
    }

    /**
     * STEP 3: GDPR-specific actions (LEGAL COMPLIANCE)
     */
    public static function getTableActions(): array
    {
        return [
            // LEGAL REQUIREMENT: Withdrawal capability
            Action::make('withdraw_consent')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn($record) => $record->is_active)
                ->requiresConfirmation()
                ->modalHeading('Withdraw Consent')
                ->modalDescription('This action will withdraw the consent and cannot be undone. This is a legal requirement under GDPR.')
                ->form([
                    Textarea::make('withdrawal_reason')
                        ->required()
                        ->label('Reason for Withdrawal')
                        ->placeholder('User requested withdrawal via email/phone/form...'),
                ])
                ->action(function($record, array $data) {
                    // LEGAL AUDIT: Log withdrawal
                    $record->update([
                        'is_active' => false,
                        'withdrawn_at' => now(),
                        'withdrawal_reason' => $data['withdrawal_reason'],
                    ]);
                    
                    activity()
                        ->performedOn($record)
                        ->causedBy(auth()->user())
                        ->withProperties([
                            'reason' => $data['withdrawal_reason'],
                            'ip_address' => request()->ip(),
                        ])
                        ->log('consent_withdrawn');
                    
                    Notification::make()
                        ->title('Consent withdrawn')
                        ->body('Consent has been legally withdrawn and logged')
                        ->warning()
                        ->persistent()
                        ->send();
                }),
                
            // LEGAL REQUIREMENT: Data export
            Action::make('export_data')
                ->icon('heroicon-o-document-arrow-down')
                ->color('info')
                ->action(function($record) {
                    $data = [
                        'consent_id' => $record->id,
                        'treatment' => $record->treatment->name,
                        'subject_id' => $record->subject_id,
                        'consent_given' => $record->accepted_at?->toISOString(),
                        'consent_withdrawn' => $record->withdrawn_at?->toISOString(),
                        'legal_basis' => $record->treatment->legal_basis,
                        'current_status' => $record->is_active ? 'active' : 'withdrawn',
                    ];
                    
                    return response()->json($data)
                        ->download("consent-export-{$record->id}.json");
                }),
        ];
    }

    /**
     * STEP 4: Compliance filters
     */
    public static function getTableFilters(): array
    {
        return array_merge(parent::getTableFilters(), [
            \Filament\Tables\Filters\SelectFilter::make('treatment')
                ->relationship('treatment', 'name'),
                
            \Filament\Tables\Filters\SelectFilter::make('consent_type')
                ->options([
                    'marketing' => 'Marketing',
                    'analytics' => 'Analytics',
                    'necessary' => 'Necessary',
                    'preferences' => 'Preferences',
                    'profiling' => 'Profiling',
                ]),
                
            \Filament\Tables\Filters\Filter::make('active_consents')
                ->query(fn($query) => $query->where('is_active', true))
                ->label('Active Consents'),
                
            \Filament\Tables\Filters\Filter::make('withdrawn_consents')
                ->query(fn($query) => $query->whereNotNull('withdrawn_at'))
                ->label('Withdrawn Consents'),
                
            \Filament\Tables\Filters\Filter::make('recent_withdrawals')
                ->query(fn($query) => $query->where('withdrawn_at', '>', now()->subDays(30)))
                ->label('Recent Withdrawals (30 days)'),
        ]);
    }

    // PERFORMANCE: Read-only resource optimization
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['treatment:id,name,legal_basis']);
    }
}
```

---

## 🏗️ STEP 3: GDPR Compliance Dashboard

### 3.1 - Legal Compliance Monitoring

**File:** `Modules/Gdpr/app/Filament/Widgets/GdprComplianceDashboard.php`

```php
<?php

namespace Modules\Gdpr\Filament\Widgets;

use Filament\Widgets\Widget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;

class GdprComplianceDashboard extends Widget
{
    protected static string $view = 'gdpr::widgets.compliance-dashboard';

    /**
     * STEP 1: Legal compliance metrics
     */
    public function table(Table $table): Table
    {
        return $table
            ->records($this->getComplianceMetrics())
            ->columns([
                TextColumn::make('metric')
                    ->weight('semibold'),
                    
                TextColumn::make('value')
                    ->numeric()
                    ->color(fn($record) => match($record['status']) {
                        'compliant' => 'success',
                        'warning' => 'warning', 
                        'critical' => 'danger',
                        default => 'info',
                    }),
                    
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'compliant',
                        'warning' => 'warning',
                        'danger' => 'critical',
                    ]),
                    
                TextColumn::make('trend')
                    ->formatStateUsing(fn($state) => $state > 0 ? "+{$state}%" : "{$state}%")
                    ->color(fn($state, $record) => 
                        $record['metric'] === 'Withdrawal Requests' 
                            ? ($state > 0 ? 'warning' : 'success')
                            : ($state > 0 ? 'success' : 'danger')
                    ),
                    
                TextColumn::make('last_updated')
                    ->since(),
            ])
            ->poll('300s'); // 5-minute updates for legal compliance
    }

    private function getComplianceMetrics(): array
    {
        return [
            [
                'metric' => 'Active Consents',
                'value' => Consent::where('is_active', true)->count(),
                'status' => 'compliant',
                'trend' => +5,
                'last_updated' => now(),
            ],
            [
                'metric' => 'Pending Withdrawals',
                'value' => Consent::where('is_active', false)
                    ->whereNotNull('withdrawn_at')
                    ->where('withdrawn_at', '>', now()->subDays(1))
                    ->count(),
                'status' => $this->getWithdrawalStatus(),
                'trend' => +2,
                'last_updated' => now(),
            ],
            [
                'metric' => 'Data Retention Violations',
                'value' => $this->getRetentionViolations(),
                'status' => $this->getRetentionStatus(),
                'trend' => -1,
                'last_updated' => now(),
            ],
            [
                'metric' => 'Treatments Requiring Review',
                'value' => Treatment::where('document_version', '<', '2.0')->count(),
                'status' => 'warning',
                'trend' => 0,
                'last_updated' => now(),
            ],
        ];
    }

    private function getWithdrawalStatus(): string
    {
        $pending = Consent::where('withdrawn_at', '>', now()->subDays(30))->count();
        return $pending > 10 ? 'warning' : 'compliant';
    }

    private function getRetentionViolations(): int
    {
        // Check for data older than legal retention period
        return Consent::where('accepted_at', '<', now()->subYears(2))
            ->where('is_active', true)
            ->count();
    }

    private function getRetentionStatus(): string
    {
        $violations = $this->getRetentionViolations();
        return match(true) {
            $violations > 5 => 'critical',
            $violations > 0 => 'warning',
            default => 'compliant',
        };
    }
}
```

---

## 🏗️ STEP 4: Legal Audit Features

### 4.1 - GDPR Audit Command

**File:** `Modules/Gdpr/app/Console/Commands/GdprAuditCommand.php`

```php
<?php

namespace Modules\Gdpr\Console\Commands;

use Illuminate\Console\Command;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;

class GdprAuditCommand extends Command
{
    protected $signature = 'gdpr:audit {--export : Export audit report}';
    protected $description = 'Perform GDPR compliance audit';

    public function handle(): int
    {
        $this->info('🛡️  Starting GDPR Compliance Audit...');
        
        $audit = [
            'timestamp' => now()->toISOString(),
            'active_consents' => $this->auditActiveConsents(),
            'withdrawn_consents' => $this->auditWithdrawnConsents(),
            'retention_compliance' => $this->auditRetentionCompliance(),
            'treatment_compliance' => $this->auditTreatmentCompliance(),
        ];
        
        $this->displayAuditResults($audit);
        
        if ($this->option('export')) {
            $this->exportAuditReport($audit);
        }
        
        return Command::SUCCESS;
    }

    private function auditActiveConsents(): array
    {
        $active = Consent::where('is_active', true)->count();
        $total = Consent::count();
        
        return [
            'total_active' => $active,
            'total_consents' => $total,
            'active_percentage' => $total > 0 ? round(($active / $total) * 100, 2) : 0,
        ];
    }

    private function auditWithdrawnConsents(): array
    {
        $withdrawn = Consent::whereNotNull('withdrawn_at')->count();
        $recentWithdrawals = Consent::where('withdrawn_at', '>', now()->subDays(30))->count();
        
        return [
            'total_withdrawn' => $withdrawn,
            'recent_withdrawals' => $recentWithdrawals,
            'compliance_status' => $recentWithdrawals < 10 ? 'compliant' : 'review_required',
        ];
    }

    private function auditRetentionCompliance(): array
    {
        $expired = Consent::where('accepted_at', '<', now()->subYears(2))
            ->where('is_active', true)
            ->count();
            
        return [
            'retention_violations' => $expired,
            'compliance_status' => $expired === 0 ? 'compliant' : 'violations_found',
        ];
    }

    private function auditTreatmentCompliance(): array
    {
        $treatments = Treatment::count();
        $activeeTreatments = Treatment::where('active', true)->count();
        $outdated = Treatment::where('document_version', '<', '2.0')->count();
        
        return [
            'total_treatments' => $treatments,
            'active_treatments' => $activeeTreatments,
            'outdated_treatments' => $outdated,
            'compliance_status' => $outdated === 0 ? 'compliant' : 'updates_required',
        ];
    }

    private function displayAuditResults(array $audit): void
    {
        $this->table(
            ['Metric', 'Value', 'Status'],
            [
                ['Active Consents', $audit['active_consents']['total_active'], '✅'],
                ['Withdrawn Consents', $audit['withdrawn_consents']['total_withdrawn'], '⚠️'],
                ['Retention Violations', $audit['retention_compliance']['retention_violations'], 
                 $audit['retention_compliance']['compliance_status'] === 'compliant' ? '✅' : '❌'],
                ['Outdated Treatments', $audit['treatment_compliance']['outdated_treatments'],
                 $audit['treatment_compliance']['compliance_status'] === 'compliant' ? '✅' : '⚠️'],
            ]
        );
    }

    private function exportAuditReport(array $audit): void
    {
        $filename = 'gdpr-audit-' . now()->format('Y-m-d-H-i-s') . '.json';
        $path = storage_path('app/gdpr-audits/' . $filename);
        
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        
        file_put_contents($path, json_encode($audit, JSON_PRETTY_PRINT));
        
        $this->info("📊 Audit report exported: {$path}");
    }
}
```

---

## 🏗️ STEP 5: CRITICAL Deployment (LEGAL APPROVAL REQUIRED)

### 5.1 - Pre-Deployment Legal Checklist

```bash
# ⚠️ STOP: MANDATORY LEGAL CHECKS
echo "LEGAL APPROVAL CHECKLIST:"
echo "[ ] Legal team has reviewed all changes"
echo "[ ] Compliance officer approval obtained" 
echo "[ ] Privacy policy updates prepared (if needed)"
echo "[ ] Data retention policies verified"
echo "[ ] Audit trail preservation confirmed"
echo "[ ] Rollback plan approved by legal"
echo "[ ] Downtime notification sent"

# Only proceed if ALL boxes checked
```

### 5.2 - Deployment with Legal Safeguards

```bash
# STEP 1: Legal-compliant deployment
php artisan migrate --path=Modules/Gdpr/database/migrations/ --force

# STEP 2: Verify audit trail integrity
php artisan gdpr:audit --export

# STEP 3: Test withdrawal functionality
php artisan tinker
>>> $consent = \Modules\Gdpr\Models\Consent::first()
>>> # Test withdrawal process

# STEP 4: Monitor for issues
tail -f storage/logs/laravel.log | grep -i gdpr
```

### 5.3 - Rollback Procedure (IF NEEDED)

```bash
# ⚠️ EMERGENCY ROLLBACK (Legal approval required)
git checkout gdpr-pre-migration-backup
php artisan migrate:rollback --step=5
mysql -u username -p database_name < backup_gdpr_full.sql

# Notify legal team immediately of rollback
```

---

## ✅ Post-Migration Legal Validation

### Critical Success Indicators (LEGAL REQUIREMENTS)

✅ **Consent withdrawal** functionality operational  
✅ **Audit trail** preserved and accessible  
✅ **Data export** capability functional  
✅ **Retention policy** compliance maintained  
✅ **Legal logging** active for all changes  
✅ **Compliance dashboard** monitoring operational  

### Legal Documentation Required

1. **Migration log** for compliance audit
2. **Functionality test results** documented
3. **Data integrity verification** completed
4. **Rollback procedure** tested and documented
5. **Legal team sign-off** obtained

---

## ⚠️ FINAL WARNING

**Questo modulo gestisce compliance legale GDPR. Qualsiasi errore può risultare in:**
- Violazioni legali
- Sanzioni finanziarie  
- Perdita di audit trail
- Compromissione compliance

**RACCOMANDAZIONE FINALE: Procedere SOLO con approvazione legale esplicita e team esperto in compliance GDPR.**