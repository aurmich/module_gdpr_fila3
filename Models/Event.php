<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;

use function Safe\json_encode;

/**
 * Modules\Gdpr\Models\Event.
 *
 * @property string                            $id
 * @property string|null                       $treatment_id
 * @property string|null                       $consent_id
 * @property string                            $subject_id
 * @property string                            $ip
 * @property string                            $action
 * @property string                            $payload
 * @property Carbon|null                       $created_at
 * @property Carbon|null                       $updated_at
 * @property \Modules\Gdpr\Models\Consent|null $consent
 *
 * @method static \Modules\Gdpr\Database\Factories\EventFactory factory($count = null, $state = [])
<<<<<<< HEAD
 * @method static Builder|Event                                 newModelQuery()
 * @method static Builder|Event                                 newQuery()
 * @method static Builder|Event                                 query()
 * @method static Builder|Event                                 whereAction($value)
 * @method static Builder|Event                                 whereConsentId($value)
 * @method static Builder|Event                                 whereCreatedAt($value)
 * @method static Builder|Event                                 whereId($value)
 * @method static Builder|Event                                 whereIp($value)
 * @method static Builder|Event                                 wherePayload($value)
 * @method static Builder|Event                                 whereSubjectId($value)
 * @method static Builder|Event                                 whereTreatmentId($value)
 * @method static Builder|Event                                 whereUpdatedAt($value)
=======
 * @method static \Illuminate\Database\Eloquent\Builder|Event   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereConsentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event   whereUpdatedAt($value)
>>>>>>> d30cea3b2a52d203c5eee30e0726ce13b536d139
 *
 * @mixin \Eloquent
 */
class Event extends BaseModel
{
    use HasUuids;

    // protected $table = 'event';

    public $fillable = [
        'id',
        'action',
        'treatment_id',
        'consent_id',
        'subject_id',
        'payload',
    ];

    public function consent(): BelongsTo
    {
        return $this->belongsTo(Consent::class);
    }

    public function setPayloadAttribute(?string $value): void
    {
        $this->attributes['payload'] = Crypt::encrypt(json_encode($value, JSON_THROW_ON_ERROR));
    }

    public function setIpAttribute(?string $value): void
    {
        $this->attributes['ip'] = Crypt::encrypt($value);
    }
}
