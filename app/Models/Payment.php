<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'Amount',
        'BankCode',
        'BankTranNo',
        'CardType',
        'OrderInfo',
        'PayDate',
        'ResponseCode',
        'TmnCode',
        'TransactionNo',
        'TransactionStatus',
        'TxnRef',
        'SecureHash',
    ];

    const UNPAID = 1;
    const PAID = 2;
 

}
