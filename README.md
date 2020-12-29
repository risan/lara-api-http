# Lara API HTTP

An opinionated Laravel base controller for API project.

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