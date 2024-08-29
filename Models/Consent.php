<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * <<<<<<< HEAD
 * <<<<<<< HEAD
 * Modules\Gdpr\Models\Consent.
 *
 * =======
 * >>>>>>> origin/dev
 *
 * @property string                          $id
 * @property string                          $treatment_id
 * @property string                          $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *                                                         <<<<<<< HEAD
 * @property Treatment|null                  $treatment
 *                                                         =======
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 *                                                         =======
 * @property string                          $id
 * @property string                          $treatment_id
 * @property string                          $subject_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 *                                                         >>>>>>> 73bcf753ed2e2b5dcdf99b2cf1cf41c38ba83408
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 * @property Treatment|null                  $treatment
 *
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedBy($value)
 *
 * @property Treatment|null $treatment
 *                                     >>>>>>> origin/dev
 *
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 *                                                                                                    <<<<<<< HEAD
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent   whereUpdatedAt($value)
 *                                                                                                    <<<<<<< HEAD
 *
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null                     $deleted_by
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereUpdatedBy($value)
 *                                                                                       =======
 *                                                                                       =======
 * @method static \Illuminate\Database\Eloquent\Builder|Consent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereUpdatedAt($value)
 *                                                                                       >>>>>>> 73bcf753ed2e2b5dcdf99b2cf1cf41c38ba83408
 * @method static \Illuminate\Database\Eloquent\Builder|Consent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereTreatmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Consent whereUpdatedBy($value)
 *
 * @property \Modules\Idoteca\Models\Profile|null $creator
 * @property \Modules\Idoteca\Models\Profile|null $updater
 *                                                         >>>>>>> origin/dev
 *
 * @mixin \Eloquent
 */
class Consent extends BaseModel
{
    use HasUuids;

    // protected $table = 'consent';

    public $incrementing = false;

    public $fillable = ['subject_id', 'treatment_id'];

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }
}
