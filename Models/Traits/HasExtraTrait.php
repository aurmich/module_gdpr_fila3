<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Modules\Xot\Models\Extra;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Xot\Models\BaseExtra;

trait HasExtraTrait
{
    /**
     * Retrieves the morphed one-to-one relationship between the current model and the Extra model.
     */
    public function extra(): MorphOne
    {
<<<<<<< HEAD
        /** @var class-string<Model> */
=======
        /** @var class-string<Illuminate\Database\Eloquent\Model> */
>>>>>>> 48e3f0e (up)
        $extra_class = Str::of(static::class)
            ->before('\Models\\')
            ->append('\Models\Extra')
            ->toString();
        Assert::classExists($extra_class);
        Assert::isAOf($extra_class, Model::class, '['.__LINE__.']['.__FILE__.']['.$extra_class.']');
        // Assert::isInstanceOf($extra_class, BaseExtra::class, '['.__LINE__.']['.__FILE__.']['.$extra_class.']');

        return $this->morphOne($extra_class, 'model');
    }

    /**
     * @return mixed|null
     */
    public function getExtra(string $name)
    {
        $value = $this->extra?->extra_attributes->get($name);

        return $value;
    }

    /**
     * @param int|float|string|array|bool|null $value
     *
     * @return void
     */
    public function setExtra(string $name, $value)
    {
        $extra = $this->extra;
        if (null === $this->extra) {
            $extra = $this->extra()->firstOrCreate([], ['extra_attributes' => []]);
        }

        $extra?->extra_attributes->set($name, $value);
        $extra?->save();
    }
}
