<?php

class PayrollCalculator {
    private $basicIncome;
    private $allowances;
    private $taxBands;
    private $loanDeduction;

    /**
     * Constructor for the PayrollCalculator
     * 
     * @param float $basicIncome The employee's basic salary
     * @param float $allowances The total sum of all allowances (risk, shift, responsibility)
     * @param array $taxBands Array of associative arrays from the tax_bands table
     * @param float $loanDeduction Any monthly loan deduction to be subtracted from Net Pay
     */
    public function __construct($basicIncome, $allowances, $taxBands, $loanDeduction = 0.00) {
        $this->basicIncome = (float) $basicIncome;
        $this->allowances = (float) $allowances;
        $this->taxBands = $taxBands;
        $this->loanDeduction = (float) $loanDeduction;
    }

    /**
     * Gross Salary: Basic Income + Allowances
     */
    public function getGrossSalary() {
        return $this->basicIncome + $this->allowances;
    }

    /**
     * Employee SSNIT: 5.5% of the Basic Income (Deducted from Employee)
     */
    public function getSSNIT() {
        return $this->basicIncome * 0.055;
    }

    /**
     * Employer SSNIT: 13% of the Basic Income (Paid by the Company)
     */
    public function getEmployerSSNIT() {
        return $this->basicIncome * 0.13;
    }

    /**
     * Total SSNIT Remittance: 18.5% of the Basic Income (Sent to SSNIT)
     */
    public function getTotalSSNITRemittance() {
        return $this->getSSNIT() + $this->getEmployerSSNIT();
    }

    /**
     * Chargeable Income: Gross Salary - Employee SSNIT
     */
    public function getChargeableIncome() {
        return $this->getGrossSalary() - $this->getSSNIT();
    }

    /**
     * PAYE Tax: Loops through progressive tax bands
     */
    public function getPAYE() {
        $remainingIncome = $this->getChargeableIncome();
        $totalPaye = 0.00;

        foreach ($this->taxBands as $band) {
            $limit = $band['limit_amount'];
            $rate = $band['rate_percentage'] / 100;

            // If the limit is NULL, it means "Exceeding" / "The rest of the income"
            if ($limit === null || $remainingIncome <= $limit) {
                // Tax whatever is left at this band's rate and stop
                $totalPaye += ($remainingIncome * $rate);
                break;
            } else {
                // Tax the maximum limit of this band at this band's rate
                $totalPaye += ($limit * $rate);
                // Subtract the taxed limit from the remaining income
                $remainingIncome -= $limit;
            }
        }

        return round($totalPaye, 2);
    }

    /**
     * Net Pay: Gross Salary - SSNIT - PAYE - Loan Deductions
     */
    public function getNetPay() {
        $gross = $this->getGrossSalary();
        $ssnit = $this->getSSNIT();
        $paye = $this->getPAYE();
        
        $net = $gross - $ssnit - $paye - $this->loanDeduction;
        return round($net, 2);
    }

    /**
     * Returns a full breakdown array for the View to use (e.g., the Payslip)
     */
    public function getFullBreakdown() {
        return [
            'basic_income' => round($this->basicIncome, 2),
            'allowances' => round($this->allowances, 2),
            'gross_salary' => round($this->getGrossSalary(), 2),
            'ssnit' => round($this->getSSNIT(), 2),
            'employer_ssnit' => round($this->getEmployerSSNIT(), 2),
            'total_ssnit' => round($this->getTotalSSNITRemittance(), 2),
            'chargeable_income' => round($this->getChargeableIncome(), 2),
            'paye' => $this->getPAYE(),
            'loan_deduction' => round($this->loanDeduction, 2),
            'net_pay' => $this->getNetPay()
        ];
    }
}
?>
