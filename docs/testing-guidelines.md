# Gdpr Module - Testing Guidelines

## Testing Framework Requirements

### Environment Configuration
All tests MUST use `.env.testing` configuration:
```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=<nome progetto>_data_test
```

### Pest Framework Usage
All tests MUST be written in Pest format. Convert any PHPUnit tests to Pest syntax.

## Business Logic Test Coverage

### 1. GDPR Consent Tests

#### Core Consent Management
```php
<?php

declare(strict_types=1);

use Modules\Gdpr\Models\GdprConsent;
use Modules\User\Models\User;

describe('GDPR Consent Business Logic', function () {
    it('records consent with required metadata', function () {
        $user = User::factory()->create();
        
        $consent = GdprConsent::create([
            'user_id' => $user->id,
            'purpose' => 'marketing_emails',
            'consent_given' => true,
            'consent_date' => now(),
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0',
            'legal_basis' => 'consent',
        ]);

        expect($consent)
            ->toBeInstanceOf(GdprConsent::class)
            ->and($consent->user_id)->toBe($user->id)
            ->and($consent->purpose)->toBe('marketing_emails')
            ->and($consent->consent_given)->toBeTrue()
            ->and($consent->legal_basis)->toBe('consent');
    });

    it('allows consent withdrawal', function () {
        $consent = GdprConsent::factory()->create([
            'consent_given' => true,
        ]);

        $consent->withdraw();

        expect($consent->fresh()->consent_given)->toBeFalse()
            ->and($consent->fresh()->withdrawal_date)->not->toBeNull();
    });

    it('validates legal basis for processing', function () {
        $validBases = ['consent', 'contract', 'legal_obligation', 'vital_interests', 'public_task', 'legitimate_interests'];
        
        foreach ($validBases as $basis) {
            $consent = GdprConsent::factory()->create([
                'legal_basis' => $basis,
            ]);
            
            expect($consent->legal_basis)->toBe($basis);
        }
    });

    it('requires parental consent for minors', function () {
        $minor = User::factory()->create([
            'date_of_birth' => now()->subYears(14),
        ]);

        $consent = GdprConsent::factory()->create([
            'user_id' => $minor->id,
            'purpose' => 'service_provision',
        ]);

        expect($consent->requiresParentalConsent())->toBeTrue();
    });
});
```

### 2. Data Processing Record Tests

```php
describe('Data Processing Business Logic', function () {
    it('logs processing activities with purpose', function () {
        $user = User::factory()->create();
        
        $record = DataProcessingRecord::create([
            'user_id' => $user->id,
            'processing_purpose' => 'user_authentication',
            'data_categories' => ['email', 'password_hash'],
            'legal_basis' => 'contract',
            'retention_period' => '5 years',
            'processor' => 'internal',
        ]);

        expect($record->processing_purpose)->toBe('user_authentication')
            ->and($record->data_categories)->toBeArray()
            ->and($record->data_categories)->toContain('email')
            ->and($record->legal_basis)->toBe('contract');
    });

    it('enforces data retention periods', function () {
        $oldRecord = DataProcessingRecord::factory()->create([
            'created_at' => now()->subYears(6),
            'retention_period' => '5 years',
        ]);

        $recentRecord = DataProcessingRecord::factory()->create([
            'created_at' => now()->subYears(2),
            'retention_period' => '5 years',
        ]);

        $expiredRecords = DataProcessingRecord::getExpiredRecords();
        
        expect($expiredRecords)->toContain($oldRecord)
            ->and($expiredRecords)->not->toContain($recentRecord);
    });

    it('tracks international data transfers', function () {
        $transfer = DataProcessingRecord::factory()->create([
            'processing_purpose' => 'cloud_backup',
            'data_location' => 'US',
            'transfer_safeguards' => 'Standard Contractual Clauses',
            'third_country_transfer' => true,
        ]);

        expect($transfer->third_country_transfer)->toBeTrue()
            ->and($transfer->data_location)->toBe('US')
            ->and($transfer->transfer_safeguards)->toBe('Standard Contractual Clauses');
    });
});
```

### 3. Privacy Rights Tests

```php
describe('Privacy Rights Business Logic', function () {
    it('processes data access requests', function () {
        $user = User::factory()->create();
        
        $request = PrivacyRequest::create([
            'user_id' => $user->id,
            'request_type' => 'access',
            'status' => 'pending',
        ]);

        $data = $request->compileUserData();
        
        expect($data)->toBeArray()
            ->and($data)->toHaveKey('personal_data')
            ->and($data)->toHaveKey('processing_activities')
            ->and($data['personal_data'])->toContain($user->email);
    });

    it('processes erasure requests with exceptions', function () {
        $user = User::factory()->create();
        
        // Create data that cannot be erased (legal obligation)
        DataProcessingRecord::factory()->create([
            'user_id' => $user->id,
            'legal_basis' => 'legal_obligation',
            'processing_purpose' => 'tax_records',
        ]);

        $request = PrivacyRequest::create([
            'user_id' => $user->id,
            'request_type' => 'erasure',
        ]);

        $result = $request->processErasure();
        
        expect($result['status'])->toBe('partial')
            ->and($result['exceptions'])->toContain('tax_records');
    });

    it('exports data in portable format', function () {
        $user = User::factory()->create();
        
        $request = PrivacyRequest::create([
            'user_id' => $user->id,
            'request_type' => 'portability',
        ]);

        $export = $request->generateDataExport();
        
        expect($export)->toHaveKey('format')
            ->and($export['format'])->toBe('json')
            ->and($export)->toHaveKey('data')
            ->and($export['data'])->toBeArray();
    });

    it('honors objections to marketing', function () {
        $user = User::factory()->create();
        
        $request = PrivacyRequest::create([
            'user_id' => $user->id,
            'request_type' => 'objection',
            'objection_purpose' => 'marketing',
        ]);

        $request->processObjection();
        
        $marketingConsent = GdprConsent::where('user_id', $user->id)
            ->where('purpose', 'marketing_emails')
            ->first();
            
        expect($marketingConsent->consent_given)->toBeFalse();
    });
});
```

### 4. Cookie Consent Tests

```php
describe('Cookie Consent Business Logic', function () {
    it('categorizes cookies correctly', function () {
        $consent = CookieConsent::create([
            'user_session' => 'test_session',
            'necessary_cookies' => true,
            'functional_cookies' => true,
            'analytics_cookies' => false,
            'marketing_cookies' => false,
        ]);

        expect($consent->necessary_cookies)->toBeTrue()
            ->and($consent->analytics_cookies)->toBeFalse()
            ->and($consent->getConsentedCategories())->toContain('necessary')
            ->and($consent->getConsentedCategories())->not->toContain('analytics');
    });

    it('updates consent preferences', function () {
        $consent = CookieConsent::factory()->create([
            'analytics_cookies' => false,
        ]);

        $consent->updateConsent([
            'analytics_cookies' => true,
        ]);

        expect($consent->fresh()->analytics_cookies)->toBeTrue()
            ->and($consent->fresh()->updated_at)->toBeGreaterThan($consent->created_at);
    });

    it('expires consent after specified period', function () {
        $expiredConsent = CookieConsent::factory()->create([
            'created_at' => now()->subMonths(13), // 13 months old
        ]);

        $validConsent = CookieConsent::factory()->create([
            'created_at' => now()->subMonths(6), // 6 months old
        ]);

        expect($expiredConsent->isExpired())->toBeTrue()
            ->and($validConsent->isExpired())->toBeFalse();
    });
});
```

### 5. Compliance Monitoring Tests

```php
describe('Compliance Monitoring', function () {
    it('detects potential data breaches', function () {
        // Simulate unusual access pattern
        $user = User::factory()->create();
        
        // Multiple failed access attempts
        for ($i = 0; $i < 10; $i++) {
            DataProcessingRecord::factory()->create([
                'user_id' => $user->id,
                'processing_purpose' => 'failed_access_attempt',
                'created_at' => now()->subMinutes($i),
            ]);
        }

        $breach = BreachDetection::analyzeAccessPatterns($user->id);
        
        expect($breach['risk_level'])->toBe('high')
            ->and($breach['requires_notification'])->toBeTrue();
    });

    it('generates compliance reports', function () {
        // Create test data
        GdprConsent::factory()->count(50)->create();
        DataProcessingRecord::factory()->count(100)->create();
        PrivacyRequest::factory()->count(10)->create();

        $report = ComplianceReport::generate();
        
        expect($report)->toHaveKey('consent_overview')
            ->and($report)->toHaveKey('processing_activities')
            ->and($report)->toHaveKey('privacy_requests')
            ->and($report['consent_overview']['total'])->toBe(50);
    });

    it('validates data processing lawfulness', function () {
        $processing = DataProcessingRecord::factory()->create([
            'legal_basis' => 'consent',
            'processing_purpose' => 'marketing',
        ]);

        // Check if corresponding consent exists
        GdprConsent::factory()->create([
            'user_id' => $processing->user_id,
            'purpose' => 'marketing',
            'consent_given' => true,
        ]);

        $validation = ComplianceValidator::validateProcessing($processing);
        
        expect($validation['is_lawful'])->toBeTrue()
            ->and($validation['issues'])->toBeEmpty();
    });
});
```

## Integration Tests

### Frontend Integration
```php
describe('Frontend GDPR Integration', function () {
    it('displays cookie consent banner', function () {
        $response = $this->get('/');
        
        $response->assertStatus(200)
            ->assertSee('cookie-consent')
            ->assertSee('Accept All')
            ->assertSee('Manage Preferences');
    });

    it('processes consent form submission', function () {
        $response = $this->post('/gdpr/consent', [
            'necessary_cookies' => true,
            'analytics_cookies' => true,
            'marketing_cookies' => false,
        ]);

        $response->assertStatus(200);
        
        expect(CookieConsent::latest()->first())
            ->not->toBeNull()
            ->and(CookieConsent::latest()->first()->analytics_cookies)->toBeTrue();
    });

    it('handles privacy request submissions', function () {
        $user = User::factory()->create();
        
        $this->actingAs($user)
            ->post('/gdpr/privacy-request', [
                'request_type' => 'access',
                'description' => 'I want to see my data',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        expect(PrivacyRequest::where('user_id', $user->id)->exists())->toBeTrue();
    });
});
```

### Performance Tests
```php
describe('GDPR Performance', function () {
    it('handles large data exports efficiently', function () {
        $user = User::factory()->create();
        
        // Create large amount of test data
        DataProcessingRecord::factory()->count(1000)->create([
            'user_id' => $user->id,
        ]);

        $startTime = microtime(true);
        
        $request = PrivacyRequest::create([
            'user_id' => $user->id,
            'request_type' => 'portability',
        ]);
        
        $export = $request->generateDataExport();
        
        $duration = microtime(true) - $startTime;
        
        expect($duration)->toBeLessThan(5.0) // 5 seconds max
            ->and($export['data'])->toHaveCount(1000);
    });
});
```

## Quality Standards

### Test Requirements
- All tests use `declare(strict_types=1);`
- Descriptive test names explaining GDPR scenarios
- Complete setup and teardown
- Meaningful assertions covering compliance requirements
- Edge case coverage for legal scenarios

### Business Logic Focus
- Consent management workflows
- Data processing lawfulness
- Privacy rights implementation
- Compliance monitoring
- Breach detection and response

---

**Last Updated**: 2025-08-28
**Testing Framework**: Pest
**Environment**: .env.testing
