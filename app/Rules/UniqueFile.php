<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Repository;
use App\Literal;

class UniqueFile implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isFile = $this->request->hasFile($attribute);
        $this->filename = $isFile ? $value->getClientOriginalName() : $value;
        return Repository::get($this->filename) === NULL;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    
    public function message()
    {
        return "File '{$this->filename}' already exists.";
    }
    
    private $filename;
    private $request;
}
