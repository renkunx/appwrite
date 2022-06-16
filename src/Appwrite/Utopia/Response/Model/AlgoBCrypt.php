<?php

namespace Appwrite\Utopia\Response\Model;

use Appwrite\Utopia\Response;
use Appwrite\Utopia\Response\Model;

class AlgoBcrypt extends Model
{
    public function __construct()
    {
        // No options, because this can only be imported, and verifying doesnt require any configuration
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return 'AlgoBCrypt';
    }

    /**
     * Get Type
     *
     * @return string
     */
    public function getType(): string
    {
        return Response::MODEL_ALGO_BCRYPT;
    }
}