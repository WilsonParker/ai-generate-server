<?php

namespace App\Listeners;

class StockImageGenerateListener extends ImageGenerateListener
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'ai-generate-stock-image-generate';

}
