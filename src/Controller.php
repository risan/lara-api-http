<?php

namespace Risan\LaraApiHttp;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use JsonResponses, Validation;
}
