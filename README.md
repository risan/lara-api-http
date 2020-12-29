# Lara API HTTP

An opinionated Laravel base controller for API project.

[![Latest Stable Version](https://poser.pugx.org/risan/lara-api-http/v)](https://packagist.org/packages/risan/lara-api-http) 
[![License](https://poser.pugx.org/risan/lara-api-http/license)](https://packagist.org/packages/risan/lara-api-http)

## Installation

This package requires you to use Laravel version 8. Install this package through Composer.

```bash
$ composer require risan/lara-api-http
```

## Usage

Use the provided base controller class for your [single action controller](https://laravel.com/docs/8.x/controllers#single-action-controllers):

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Risan\LaraApiHttp\Controller;

class TaskUpdate extends Controller
{
    public function __invoke(Task $task)
    {
        // Authorize user.
        $this->authorize('update', $task);

        // Validate request.
        $data = $this->validate();

        $task->fill($data);

        $task->save();

        // Return JSON response.
        return $this->jsonUpdated($task, 'Task is updated.');
    }

    public function rules(): array
    {
        return [
            'name' => 'string|required|max:100',
            'due_date' => 'date|required',
        ];
    }
}
```

## JSON Responses

The base controller uses the `Risan\LaraApiHttp\JsonResponses` trait that has several methods to create `Illuminate\Http\JsonResponse` instance with a certain structure.

```php
public function json($data = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse

// {"data": ...}
public function jsonData($data = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse

// {"message": "Ok", "data": ...}
public function jsonDataAndMessage($data = null, string $message = 'Ok', int $status = 200, array $headers = [], int $options = 0): JsonResponse

// {"message": "Resource is created.", "data": ...}
public function jsonCreated($data = null, string $message = 'Resource is created.', array $headers = [], int $options = 0): JsonResponse

// {"message": "Resource is created.", "data": ...}
public function jsonUpdated($data = null, string $message = 'Resource is updated.', array $headers = [], int $options = 0): JsonResponse

// {"message": "Resource is deleted.", "data": ...}
public function jsonDeleted($data = null, string $message = 'Resource is deleted.', array $headers = [], int $options = 0): JsonResponse
```

## Authorization

If you have [authorization policies](https://laravel.com/docs/8.x/authorization#creating-policies), you can use the `authorize` method to authorize the action. If the user is not authorized, the authorization exception will be thrown.

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Risan\LaraApiHttp\Controller;

class TaskDetail extends Controller
{
    public function __invoke(Task $task)
    {
        // Assuming you have a policy class for Task model.
        $this->authorize('view', $task);

        // Rest of the code...
    }
}
```

## Validation

Similar to [form request](https://laravel.com/docs/8.x/validation#form-request-validation), you have several methods to setup a validation for your request.

```php
<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Risan\LaraApiHttp\Controller;

class TaskCreate extends Controller
{
    public function __invoke()
    {
        // request: ["name" => "Take out trash", "due_date": "2020-12-30"]
        // $data: ["title" => "Take out trash", "due_date": "2020-12-30", "source" => "API"]
        $data = $this->validate();

        $task = new Task($data);

        $task->save();

        return $this->jsonCreate($task, 'Task is created.');
    }

    // Configure your validation rules here.
    public function rules(): array
    {
        return [
            'name' => 'string|required|max:100',
            'due_date' => 'date|requried',
        ];
    }

    // Configure custom error message.
    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
        ];
    }

    // Rename the validation attributes.
    public function customAttributes(): array
    {
        return [
            'due_date' => 'deadline',
        ];
    }

    // Rename the input data key.
    public function inputMap(): array
    {
        return [
            'name' => 'title',
        ];
    }

    // Transform the input data.
    public function transformInput(array $data): array
    {
        $data['source'] = 'API';

        return $data;
    }
}
```

## License

[MIT](https://github.com/risan/helpers/blob/master/LICENSE) © [Risan Bagja Pradana](https://risanb.com)