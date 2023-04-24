<?php

namespace Modules\Media\Exceptions;

use Exception;

class CouldNotAddUpload extends Exception
{
    public static function uuidAlreadyExists():self
    {
        return new static("The given uuid is being used for an existing media item.");
    }
}
