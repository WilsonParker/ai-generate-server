<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_time_is_collect(): void
    {
        $start = now();
        $end = $start->clone()->addMinutes(10);
        dump($start->format('Y-m-d H:i:s'));
        dump($end->format('Y-m-d H:i:s'));
        $this->assertTrue(now()->lessThan($end));
    }

    public function test_json_is_correct(): void
    {
        $s['ADetailer']['args'] = [
            true,
            "ad_model" => "face_yolov8n.pt",
        ];
        dump(json_encode($s));
        dump(null ? "{}" : json_decode(null, true));
        dump(json_decode('{"ADetailer":{"args":{"0":"true","ad_model":"face_yolov8n.pt"}}}', true));
    }
}
