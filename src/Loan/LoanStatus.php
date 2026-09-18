<?php

namespace App\Loan;

enum LoanStatus: string
{
    case Pending  = 'pending';
    case Active   = 'active';
    case Returned = 'returned';
    case Overdue  = 'overdue';
}
