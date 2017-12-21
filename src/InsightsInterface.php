<?php

declare(strict_types=1);

namespace Kerox\Messenger;

interface InsightsInterface
{
    public const ACTIVE_THREAD_UNIQUE = 'page_messages_active_threads_unique';
    public const BLOCKED_CONVERSATIONS_UNIQUE = 'page_messages_blocked_conversations_unique';
    public const REPORTED_CONVERSATIONS_UNIQUE = 'page_messages_reported_conversations_unique';
    public const REPORTED_CONVERSATIONS_BY_REPORT_TYPE_UNIQUE = 'page_messages_reported_conversations_by_report_type_unique';
    public const FEEDBACK_BY_ACTION_UNIQUE = 'page_messages_feedback_by_action_unique';
}
