<?php

namespace Risan\LaraApiHttp;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

trait Validation
{
    public function validate(): array
    {
        $data = Validator::make(
            Request::all(), $this->rules(), $this->messages(), $this->customAttributes()
        )->validate();

        foreach ($this->inputMap() as $requestKey => $renameKey) {
            if (Arr::has($data, $requestKey)) {
                Arr::set($data, $renameKey, Arr::get($data, $requestKey));
                Arr::forget($data, $requestKey);
            }
        }

        return $this->transformInput($data);
    }

    public function authorize(string $ability, $arguments = [])
    {
        return Gate::authorize($ability, $arguments);
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function customAttributes(): array
    {
        return [];
    }

    public function inputMap(): array
    {
        return [];
    }

    public function transformInput(array $data): array
    {
        return $data;
    }
}
