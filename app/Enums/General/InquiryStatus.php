<?php

namespace App\Enums\General;

enum InquiryStatus: string
{
    case NEW = 'inquiryStatus-new';
    case ACTIVE = 'inquiryStatus-active';
    case CLOSED = 'inquiryStatus-closed';
}