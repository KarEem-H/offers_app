<?php

namespace App\Exports;

use App\Models\{RiskLeadAnswer, Risk, RiskQuestion};
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\{
    ShouldAutoSize, WithStyles
};

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;

class RiskExport implements FromView, ShouldAutoSize, WithStyles
{

    protected $riskID, $countQuestions;

    public function __construct($riskID)
    {
        $this->riskID = $riskID;
    }

    public function view(): View
    {
        $riskID = $this->riskID;
        $risk = Risk::find($riskID);

        $sections = $risk->sections->pluck('id');
        $questions = RiskQuestion::whereIn('section_id', $sections)->get();
        $this->countQuestions = $questions->count();

        $leads = RiskLeadAnswer::where([
            ['risk_lead_answer.risk_id', $riskID],
        ])
        ->select(
            'leads.id',
            'leads.name',
            'leads.email',
            'leads.phone',
            'leads.age',
            'leads.gender',
            'leads.created_at',
        )
        ->leftJoin('leads', 'risk_lead_answer.lead_id', '=', 'leads.id')
        ->groupBy('leads.id')
        ->get();

        return view('exports.risk', [
            'leads' => $leads,
            'questions' => $questions,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $chars = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        ];

        $sheet
        ->mergeCells('A1:G1')
        ->getStyle('A1:G1')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_MEDIUMGRAY)
        ->getStartColor()
        ->setARGB('5597ca');

        $charIndex = 7 + $this->countQuestions - 1;

        $sheet
        ->mergeCells('H1:'.$chars[$charIndex].'1')
        ->getStyle('H1:'.$chars[$charIndex].'1')
        ->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_PATTERN_MEDIUMGRAY)
        ->getStartColor()
        ->setARGB('ff0000');
    }
}
