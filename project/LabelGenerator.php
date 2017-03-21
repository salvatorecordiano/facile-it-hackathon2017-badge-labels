<?php

declare(strict_types=1);

/**
 * Class LabelGenerator
 */
class LabelGenerator
{
    /** @var array */
    private $attendees;
    
    /** @var FPDF */
    private $pdf;
    
    /**
     * LabelGenerator constructor.
     * @param array $attendees
     */
    public function __construct(array $attendees)
    {
        $this->attendees = $attendees;
        $this->pdf = new \FPDF('L', 'mm', [90, 38]);
    }

    /**
     * @param $text
     * @param int|null $lenght
     * @return string
     */
    private function convertText($text, int $lenght = null): string
    {
        $convertedText = $text ?? '';
        if($lenght && strlen($convertedText) > $lenght) {
            $convertedText = substr($convertedText, 0, $lenght);
        }

        return iconv('UTF-8', 'windows-1252', $convertedText);
    }

    public function generate()
    {
        $this->pdf->SetAutoPageBreak(false);

        foreach ($this->attendees as $attendee) {
            $this->addAttendee($attendee);
        }

        $this->pdf->Output('F', 'labels.pdf');
    }

    public function addAttendee($attendee)
    {
        $this->pdf->AddPage();

        $this->pdf->SetFont('Arial','B', 10);
        $this->pdf->SetXY(2, 0.5);
        $this->pdf->MultiCell(88, 8, $this->convertText('#FacileHack'), 0, 'L', false);

        $this->pdf->SetFont('Arial','', 8);
        $this->pdf->SetXY(2, 4.5);
        $this->pdf->MultiCell(88, 6, $this->convertText('25-26 Marzo 2017'), 0, 'L', false);

        $this->pdf->Image('logo_engineering.png', 81, 2.5, 6.5);

        $this->pdf->Line(3, 9, 87, 9);

        $this->pdf->SetFont('Arial','B', 21);
        $this->pdf->SetXY(2, 12.5);
        $this->pdf->MultiCell(86, 8, $this->convertText(sprintf('%s %s', $attendee['firstname'], $attendee['lastname'])), 0, 'L', false);

        // $this->pdf->SetFont('Arial','', 21);   
        // $this->pdf->SetXY(2, 20.5);
        // $this->pdf->MultiCell(86, 8, $this->convertText('Giuria'), 0, 'L', false);
        // $this->pdf->MultiCell(86, 8, $this->convertText('HR Specialist'), 0, 'L', false);

        $this->pdf->Line(3, 32, 87, 32);
        $this->pdf->SetFont('Arial','', 7);
        $this->pdf->SetXY(2, 33);
        $this->pdf->MultiCell(86, 2, $this->convertText('SSID: Talent_Garden_Events'), 0, 'L', false);
        $this->pdf->SetXY(2, 33);
        $this->pdf->MultiCell(86, 2, $this->convertText('Password: Innovazione2015'), 0, 'R', false);
    }
}
