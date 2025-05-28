<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MortgageApiController extends Controller
{
    public function calculate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0',
            'term_years' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $amount = $request->amount;
        $downPayment = $request->down_payment;
        $interestRate = $request->interest_rate;
        $years = $request->term_years;

        $loanAmount = $amount - $downPayment;
        $monthlyInterest = $interestRate / 12 / 100;
        $months = $years * 12;

        if ($monthlyInterest > 0) {
            $monthlyPayment = $loanAmount * $monthlyInterest * pow(1 + $monthlyInterest, $months) / (pow(1 + $monthlyInterest, $months) - 1);
        } else {
            $monthlyPayment = $loanAmount / $months;
        }

        $totalPayment = $monthlyPayment * $months;
        $totalInterest = $totalPayment - $loanAmount;

        return response()->json([
            'status' => true,
            'data' => [
                'loan_amount' => number_format($loanAmount, 2),
                'monthly_payment' => number_format($monthlyPayment, 2),
                'total_payment' => number_format($totalPayment, 2),
                'total_interest' => number_format($totalInterest, 2),
            ]
        ]);
    }
}
