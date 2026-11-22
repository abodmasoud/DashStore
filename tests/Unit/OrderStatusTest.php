<?php

namespace Tests\Unit;

use App\Enums\OrderStatus;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    public function test_pending_order_can_be_processed_or_cancelled(): void
    {
        $this->assertTrue(OrderStatus::Pending->canTransitionTo(OrderStatus::Processing));
        $this->assertTrue(OrderStatus::Pending->canTransitionTo(OrderStatus::Cancelled));
        $this->assertFalse(OrderStatus::Pending->canTransitionTo(OrderStatus::Delivered));
    }

    public function test_final_statuses_cannot_change(): void
    {
        $this->assertSame([], OrderStatus::Delivered->nextStatuses());
        $this->assertSame([], OrderStatus::Cancelled->nextStatuses());
    }

    public function test_shipped_order_cannot_be_cancelled(): void
    {
        $this->assertFalse(OrderStatus::Shipped->canTransitionTo(OrderStatus::Cancelled));
    }
}
