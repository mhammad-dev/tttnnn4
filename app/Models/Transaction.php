<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
            'identification_no', 
            'description',
            'policy_no',
            'status',
            'title',
            'initials',
            'client',
            'risk_amt_ex_vat',
            'comm_fee_ex_vat',
            'comm_fee_vat',
            'balance_brought_forward_ex_vat',
            'total_owed_ex_vat',
            'total_paid_ex_vat',
            'balance_carried_forward_ex_vat'
     ];
}