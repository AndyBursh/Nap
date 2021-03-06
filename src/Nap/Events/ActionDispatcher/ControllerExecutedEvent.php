<?php
namespace Nap\Events\ActionDispatcher;

use Nap\Events\ResultEvent;
use Nap\Response\ActionResult;

class ControllerExecutedEvent extends ResultEvent
{
    /**
     * @var string
     */
    private $mimeType;

    public function __construct(
        ActionResult $result,
        $mimeType
    ) {
        $this->setResult($result);
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }
}