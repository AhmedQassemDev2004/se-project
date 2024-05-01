<?php
// Include the TCPDF library
require_once 'F:\College material\Year 2\Second term\Software Eng\Project\TCPDF-main\tcpdf.php';

// Include the necessary files and initialize the UserService
require_once __DIR__."/../vendor/autoload.php";
require_once __DIR__."/../Utils/config.php";
use App\Services\UserService;

// Create an instance of the UserService
$userService = new UserService();

// Fetch the required data
$usersJoinedStatistics = $userService->getUsersJoinedStatistics();
$usersWithHighestReputations = $userService->getUsersWithHighestReputations();
$usersWithMostBadges = $userService->getUsersWithMostBadges();

// Create a new TCPDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Admin');
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Report');
$pdf->SetSubject('Report');
$pdf->SetKeywords('Report');

$header = 'Management Report';

// Set header content
$pdf->setPrintHeader(true);
$pdf->SetHeaderData('', 0, '', $header);

// Set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set margins
$pdf->SetMargins(15, 25, 15);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Header content
$header = '<table width="100%">
    <tr>
        <td align="left">Report Header</td>
        <td align="right">Date: ' . date('Y-m-d H:i:s') . '</td>
    </tr>
</table>';

// Set header content
$pdf->setPrintHeader(true);
$pdf->SetHeaderData('', 0, 'Report', $header);

// Footer content
$footer = '<table width="100%">
    <tr>
        <td align="left">Page ' . $pdf->getAliasNumPage() . ' of ' . $pdf->getAliasNbPages() . '</td>
        <td align="right">Report Footer</td>
    </tr>
</table>';

// Set footer content
$pdf->setPrintFooter(true);
$pdf->SetFooterData('', 0, '', $footer);

// Add content to the PDF
$pdf->Write(0, 'Users Joined:', '', 0, 'L');
$pdf->Ln();
$pdf->Write(0, '--------------------------------------------------------------', '', 0, 'L');
$pdf->Ln();

$pdf->Write(0, 'Last Day: ' . $usersJoinedStatistics['last_day'], '', 0, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Write(0, 'Last Week: ' . $usersJoinedStatistics['last_week'], '', 0, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Write(0, 'Last Month: ' . $usersJoinedStatistics['last_month'], '', 0, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->Write(0, 'Users with Highest Reputations:', '', 0, 'L');
$pdf->Ln();
$pdf->Write(0, '--------------------------------------------------------------', '', 0, 'L');
$pdf->Ln();

foreach ($usersWithHighestReputations as $user) {
    if (isset($user['username']) && isset($user['reputations'])) {
        $pdf->Write(0, $user['username'] . ' (Reputation: ' . $user['reputations'] . ')', '', 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
    }
}
$pdf->Ln();
$pdf->Ln();

$pdf->Write(0, 'Users with Most Badges:', '', 0, 'L');
$pdf->Ln();
$pdf->Write(0, '--------------------------------------------------------------', '', 0, 'L');
$pdf->Ln();

foreach ($usersWithMostBadges as $user) {
    if (isset($user['username']) && isset($user['badge_count'])) {
        $pdf->Write(0, $user['username'] . ' (Badges: ' . $user['badge_count'] . ')', '', 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
    }
}
$pdf->Ln();
$pdf->Ln();

// Close and output PDF document
$pdf->Output('report.pdf', 'D'); // D means force download

// Terminate script execution
exit;
?>
