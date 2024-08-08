<?php

namespace App\Events;

class StockImageGenerateRequestEvent extends ImageGenerateRequestEvent
{

    public $queue = 'ai-generate-stock-image-generate';

}
