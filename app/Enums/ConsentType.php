<?php

declare(strict_types=1);

namespace Modules\Gdpr\Enums;

<<<<<<< HEAD
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
=======
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use Filament\Support\Contracts\HasIcon;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasColor;
>>>>>>> 618564f (.)
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Filament\Traits\TransTrait;

/**
 * Enum ConsentType
<<<<<<< HEAD
 *
 * Defines all available consent types in the application.
 * Each consent type must have a corresponding translation key in the language files.
 */
enum ConsentType: string implements HasColor, HasIcon, HasLabel
{
=======
 * 
 * Defines all available consent types in the application.
 * Each consent type must have a corresponding translation key in the language files.
 */
enum ConsentType: string implements HasLabel, HasIcon, HasColor
{

>>>>>>> 618564f (.)
    use TransTrait;
    // Marketing communications
    case MARKETING_EMAIL = 'marketing_email';
    case MARKETING_SMS = 'marketing_sms';
    case MARKETING_PHONE = 'marketing_phone';
<<<<<<< HEAD

=======
    
>>>>>>> 618564f (.)
    // Privacy and data processing
    case PRIVACY_POLICY = 'privacy_policy';
    case COOKIES = 'cookies';
    case ANALYTICS = 'analytics';
    case PERSONALIZATION = 'personalization';
<<<<<<< HEAD

    // Data sharing
    case THIRD_PARTY_SHARING = 'third_party_sharing';
    case DATA_TRANSFER = 'data_transfer';

    // Account related
    case TERMS_AND_CONDITIONS = 'terms_and_conditions';
    case AGE_VERIFICATION = 'age_verification';

=======
    
    // Data sharing
    case THIRD_PARTY_SHARING = 'third_party_sharing';
    case DATA_TRANSFER = 'data_transfer';
    
    // Account related
    case TERMS_AND_CONDITIONS = 'terms_and_conditions';
    case AGE_VERIFICATION = 'age_verification';
    
>>>>>>> 618564f (.)
    // Special consents
    case RESEARCH = 'research';
    case PROFILING = 'profiling';
    case AUTOMATED_DECISION_MAKING = 'automated_decision_making';

    public function getLabel(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value.'.label');
=======
        return $this->transClass(self::class,$this->value.'.label');
>>>>>>> 618564f (.)
    }

    public function getColor(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value.'.color');
=======
        return $this->transClass(self::class,$this->value.'.color');

>>>>>>> 618564f (.)
    }

    public function getIcon(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value.'.icon');
=======
        return $this->transClass(self::class,$this->value.'.icon');
>>>>>>> 618564f (.)
    }

    public function getDescription(): string
    {
<<<<<<< HEAD
        return $this->transClass(self::class, $this->value.'.description');
=======
        return $this->transClass(self::class,$this->value.'.description');
>>>>>>> 618564f (.)
    }

    /**
     * Check if this consent type is required for using the service.
<<<<<<< HEAD
=======
     * 
     * @return bool
>>>>>>> 618564f (.)
     */
    public function isRequired(): bool
    {
        return in_array($this, [
            self::PRIVACY_POLICY,
            self::TERMS_AND_CONDITIONS,
            self::AGE_VERIFICATION,
        ]);
    }

    /**
     * Get all required consent types.
<<<<<<< HEAD
     *
=======
     * 
>>>>>>> 618564f (.)
     * @return array<string>
     */
    public static function getRequiredConsentTypes(): array
    {
        return array_map(
            fn (self $type) => $type->value,
            array_filter(self::cases(), fn (self $type) => $type->isRequired())
        );
    }

    /**
     * Get all optional consent types.
<<<<<<< HEAD
     *
=======
     * 
>>>>>>> 618564f (.)
     * @return array<string>
     */
    public static function getOptionalConsentTypes(): array
    {
        return array_map(
            fn (self $type) => $type->value,
<<<<<<< HEAD
            array_filter(self::cases(), fn (self $type) => ! $type->isRequired())
=======
            array_filter(self::cases(), fn (self $type) => !$type->isRequired())
>>>>>>> 618564f (.)
        );
    }

    /*
     * Get consent types grouped by category.
<<<<<<< HEAD
     *
     * @return array<string, array<string, string>>

=======
     * 
     * @return array<string, array<string, string>>
     
>>>>>>> 618564f (.)
    public static function groupedByCategory(): array
    {
        return [
            'marketing' => [
                self::MARKETING_EMAIL->value => self::MARKETING_EMAIL->label(),
                self::MARKETING_SMS->value => self::MARKETING_SMS->label(),
                self::MARKETING_PHONE->value => self::MARKETING_PHONE->label(),
            ],
            'privacy' => [
                self::PRIVACY_POLICY->value => self::PRIVACY_POLICY->label(),
                self::COOKIES->value => self::COOKIES->label(),
                self::ANALYTICS->value => self::ANALYTICS->label(),
                self::PERSONALIZATION->value => self::PERSONALIZATION->label(),
            ],
            'data_sharing' => [
                self::THIRD_PARTY_SHARING->value => self::THIRD_PARTY_SHARING->label(),
                self::DATA_TRANSFER->value => self::DATA_TRANSFER->label(),
            ],
            'account' => [
                self::TERMS_AND_CONDITIONS->value => self::TERMS_AND_CONDITIONS->label(),
                self::AGE_VERIFICATION->value => self::AGE_VERIFICATION->label(),
            ],
            'special' => [
                self::RESEARCH->value => self::RESEARCH->label(),
                self::PROFILING->value => self::PROFILING->label(),
                self::AUTOMATED_DECISION_MAKING->value => self::AUTOMATED_DECISION_MAKING->label(),
            ],
        ];
    }
<<<<<<< HEAD
        */
=======
    */
    
>>>>>>> 618564f (.)
}
