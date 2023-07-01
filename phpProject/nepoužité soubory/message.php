<?php
// Path: phpProject\nepoužité soubory\message.php

require_once 'C:\xampp\htdocs\mpdf-master\src\Strict.php';
require_once 'C:\xampp\htdocs\mpdf-master\src\Mpdf.php';
require_once 'C:\xampp\htdocs\mpdf-master\src\FpdiTrait.php';

// Connect to your database and retrieve data from SQL
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'first_db';

// Create a new PDO instance
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retrieve data from the database using SQL query
$stmt = $pdo->query('SELECT * FROM pupils');
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Create an instance of mPDF
$mpdf = new Mpdf();


// Generate the PDF content using HTML
$html = '<h1>Generated PDF from SQL Data</h1>';
$html .= '<table>';
$html .= '<tr><th>ID</th><th>firstname</th><th>lastname</th></tr>';
foreach ($data as $row) {
    $html .= '<tr>';
    $html .= '<td>' . $row['id'] . '</td>';
    $html .= '<td>' . $row['firstname'] . '</td>';
    $html .= '<td>' . $row['lastname'] . '</td>';
    $html .= '</tr>';
}
$html .= '</table>';

// Add the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the user for download
$mpdf->Output('output.pdf', 'D');
?>

