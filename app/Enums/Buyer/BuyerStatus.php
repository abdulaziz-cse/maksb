<?php

namespace App\Enums\Buyer;

enum BuyerStatus: string
{
    case PENDING = 'buyerStatus-pending';

    case ACCEPTED = 'buyerStatus-accepted';

    case REJECTED = 'buyerStatus-rejected';
}
