<?php
namespace App\Filters\V1;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoiceFilter extends ApiFilter{
    // $table->id();
    //         $table->integer('customer_id');
    //         $table->integer('amount');
    //         $table->string('status'); //billed, paid, void
    //         $table->datetime('billed_date');
    //         $table->datetime('paid_date')->nullable();
    //         $table->timestamps();

    protected $safeParams = [
        'customerId'=>['eq'],
        'amount'=>['eq','lt','gt','lte','gte'],
        'status'=>['eq','ne'],
        'billed_date'=>['eq','lt','gt','lte','gte'],
        'paid_date'=>['eq','lt','gt','lte','gte'],
    ];

    protected $columnMap = [
        'customerId' => 'customer_id',
        'billedDate' => 'billed_date',
        'paidDate' => 'paid_date',
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!='
    ];
}
