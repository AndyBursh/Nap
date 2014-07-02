<?php
namespace Nap\Test\Uri\Stubs\ParamScheme;

use \Nap\Test\Uri\Stubs\Param;

class SingleSelfOptionalParam extends SingleParam
{
    public function __construct()
    {
        parent::__construct(new Param("id", false, false, "\d+", "id"));
    }
}
