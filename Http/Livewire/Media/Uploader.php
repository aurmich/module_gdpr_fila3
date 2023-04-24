<?php

declare(strict_types=1);

namespace Modules\Media\Http\Livewire\Media;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Cms\Actions\GetViewAction;
use Modules\Media\Actions\ConvertLivewireUploadToMediaAction;

class Uploader extends Component
{
    use WithFileUploads {
        uploadErrored as protected uploadErroredTrait;
    }

    public string $rules;
    public string $name;
    public ?string $uuid;
    public bool $multiple;
    public bool $add;
    public ?string $uploadError;

    /** @var \Livewire\TemporaryUploadedFile|null */
    public $upload;

    public function mount(string $rules, string $name, bool $multiple = false, string $uuid = null, bool $add = false): void
    {
        $this->rules = $rules;
        $this->name = $name;
        $this->multiple = $multiple;
        $this->uuid = $uuid ?? (string) Str::uuid();
        $this->add = $add;
    }

    public function updatedUpload(): void
    {
        $uploadError = $this->getUploadError();

        if (! is_null($uploadError)) {
            $this->uploadError = $uploadError;

            if (! $this->add) {
                $this->emit("{$this->name}:uploadError", $this->uuid, $uploadError);
            }

            return;
        }

        $uploads = $this->multiple
            ? $this->upload
            : [$this->upload];
        if (is_iterable($uploads)) {
            foreach ($uploads as $upload) {
                if (null != $upload) {
                    $this->handleUpload($upload);
                }
            }
        }
    }

    protected function getUploadError(): ?string
    {
        $uploadError = null;

        $field = $this->multiple ? 'upload.*' : 'upload';

        try {
            $this->validate([
                $field => $this->rules,
            ], ["{$field}.mimes" => __('media::validation.type')]);
        } catch (ValidationException $validationException) {
            $uploadError = Arr::flatten($validationException->errors())[0];

            if ($this->add) {
                $this->emit("{$this->name}:showListErrorMessage", $uploadError);
            }
        }

        return $uploadError;
    }

    /**
     * @param \Livewire\TemporaryUploadedFile $upload
     */
    protected function handleUpload($upload): void
    {
        $media = (new ConvertLivewireUploadToMediaAction())->execute($upload);
        if (! property_exists($media, 'name')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        if (! property_exists($media, 'file_name')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        if (! property_exists($media, 'order_column')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        if (! property_exists($media, 'mime_type')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        if (! property_exists($media, 'size')) {
            throw new \Exception('['.__LINE__.']['.__FILE__.']');
        }
        $this->emit("{$this->name}:fileAdded", [
            'name' => $media->name,
            'fileName' => $media->file_name,
            'oldUuid' => $this->uuid,
            'uuid' => $media->uuid,
            'previewUrl' => $media->hasGeneratedConversion('preview') ? $media->getUrl('preview') : '',
            'order' => $media->order_column,
            'size' => $media->size,
            'mime_type' => $media->mime_type,
            'extension' => pathinfo($media->file_name, PATHINFO_EXTENSION),
        ]);
    }

    public function uploadErrored(string $name, string $errorsInJson, bool $isMultiple): void
    {
        try {
            $this->uploadErroredTrait($name, $errorsInJson, $isMultiple);
        } catch (ValidationException $exception) {
            $uploadError = str_replace('.0', '', $exception->validator->errors()->first());

            $this->add
                ? $this->emit("{$this->name}:showListErrorMessage", $uploadError)
                : $this->emit("{$this->name}:uploadError", $this->uuid, $exception->validator->errors()->first());
        }
    }

    public function render(): Renderable
    {
        /**
         * @phpstan-var view-string
         */
        $view = app(GetViewAction::class)->execute();

        $view_params = [
            'view' => $view,
        ];

        return view($view, $view_params);
    }
}
