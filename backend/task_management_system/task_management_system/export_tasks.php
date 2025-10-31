<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include "DB_connection.php";
include "app/Model/Task.php";

$format = $_GET['format'] ?? '';
$tasks = get_all_tasks($conn);

if ($format === 'excel') {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=tasks.xls");
    echo "Title\tDescription\tAssigned To\tDue Date\tStatus\n";
    foreach ($tasks as $task) {
        echo "{$task['title']}\t{$task['description']}\t{$task['assigned_to']}\t{$task['due_date']}\t{$task['status']}\n";
    }
    exit();
}

if ($format === 'pdf') {
    require('fpdf/fpdf.php'); // Make sure you have FPDF installed

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,'Task List',0,1,'C');

    $pdf->SetFont('Arial','',10);
    foreach ($tasks as $task) {
        $pdf->Cell(0,8,"{$task['title']} | {$task['description']} | {$task['assigned_to']} | {$task['due_date']} | {$task['status']}",0,1);
    }

    $pdf->Output('D', 'tasks.pdf');
    exit();
}

echo "Invalid format.";