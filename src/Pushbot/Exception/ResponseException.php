<?php

namespace M6\Pushbot\Exception;

use M6\Pushbot\Response;

class ResponseException extends \Exception
{
    public function getResponse() : Response
    {
        return new Response(
            $this->getCode(),
            $this->getMessage()
        );
    }
}
