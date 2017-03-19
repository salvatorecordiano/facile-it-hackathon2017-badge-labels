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

//        $this->pdf->SetFont('Arial','B', 8);
//        $this->pdf->SetXY(0, 0);
//        $this->pdf->MultiCell(88, 8, $this->convertText('#FacileHack'), 0, 'R', false);
//
//        $this->pdf->SetFont('Arial','', 6);
//        $this->pdf->SetXY(0, 3.5);
//        $this->pdf->MultiCell(88, 6, $this->convertText('25-26 Marzo 2017'), 0, 'R', false);
//
//        $this->pdf->Image('logo_engineering.png', 3, 3, 18);

        $this->pdf->SetFont('Arial','B', 8);
        $this->pdf->SetXY(2, 0);
        $this->pdf->MultiCell(88, 8, $this->convertText('#FacileHack'), 0, 'L', false);

        $this->pdf->SetFont('Arial','', 6);
        $this->pdf->SetXY(2, 3.5);
        $this->pdf->MultiCell(88, 6, $this->convertText('25-26 Marzo 2017'), 0, 'L', false);

        $this->pdf->Image('logo_engineering.png', 69, 3, 18);

        $this->pdf->Line(3, 8, 87, 8);

        $this->pdf->SetFont('Arial','I', 11);
        $this->pdf->SetXY(2, 12);
        $this->pdf->Write(1, $this->convertText($attendee['firstname']));

        $this->pdf->SetXY(2, 16);
        $this->pdf->Write(1, $this->convertText($attendee['lastname']));

        $this->pdf->SetFont('Arial','', 11);
        $this->pdf->SetXY(2, 20);
        $this->pdf->Write(1, $this->convertText($attendee['title']));

        \PHPQRCode\QRcode::png($attendee['code'], 'qrcode.png', 'L', 8, 0);
        $this->pdf->Image('qrcode.png', 75, 10, 12);
        unlink('qrcode.png');

        $this->pdf->SetFont('Arial','', 4);
        $this->pdf->SetXY(2, 30);
        $this->pdf->MultiCell(86, 2, 'CODE#' . $attendee['code'], 0, 'R', false);

        $this->pdf->Line(3, 32, 87, 32);

        $this->pdf->SetXY(2, 33);
        $this->pdf->Write(1, $this->convertText('SSID: Facile'));
        $this->pdf->SetXY(2, 34.5);
        $this->pdf->Write(1, $this->convertText('Username: Hackathon'));
        $this->pdf->SetXY(2, 36);
        $this->pdf->Write(1, $this->convertText('Password: FacileFacile'));
    }
}
