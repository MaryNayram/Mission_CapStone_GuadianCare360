<?php

function insert_task($conn, $data){
	// Ensure status is included and due_date is sanitized
	$data[3] = ($data[3] === '0000-00-00') ? null : $data[3];
	$sql = "INSERT INTO tasks (title, description, assigned_to, due_date, status) VALUES (?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function get_all_tasks($conn){
	$sql = "SELECT * FROM tasks ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function get_all_tasks_due_today($conn){
	$sql = "SELECT * FROM tasks WHERE due_date = CURDATE() AND status != 'completed' ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function count_tasks_due_today($conn){
	$sql = "SELECT COUNT(*) FROM tasks WHERE due_date = CURDATE() AND status != 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function get_all_tasks_overdue($conn){
	$sql = "SELECT * FROM tasks WHERE due_date < CURDATE() AND status != 'completed' ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function count_tasks_overdue($conn){
	$sql = "SELECT COUNT(*) FROM tasks WHERE due_date < CURDATE() AND status != 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function get_all_tasks_NoDeadline($conn){
	$sql = "SELECT * FROM tasks WHERE status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00') ORDER BY id DESC";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll();
}

function count_tasks_NoDeadline($conn){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00')";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function delete_task($conn, $data){
	$sql = "DELETE FROM tasks WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function get_task_by_id($conn, $id){
	$sql = "SELECT * FROM tasks WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetch();
}

function count_tasks($conn){
	$sql = "SELECT COUNT(*) FROM tasks";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function update_task($conn, $data){
	$data[3] = ($data[3] === '0000-00-00') ? null : $data[3];
	$sql = "UPDATE tasks SET title = ?, description = ?, assigned_to = ?, due_date = ? WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function update_task_status($conn, $data){
	$sql = "UPDATE tasks SET status = ? WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute($data);
}

function get_all_tasks_by_id($conn, $id){
	$sql = "SELECT * FROM tasks WHERE assigned_to = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchAll();
}

function count_pending_tasks($conn){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status = 'pending'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function count_in_progress_tasks($conn){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status = 'in_progress'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function count_completed_tasks($conn){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status = 'completed'";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function count_my_tasks($conn, $id){
	$sql = "SELECT COUNT(*) FROM tasks WHERE assigned_to = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchColumn();
}

function count_my_tasks_overdue($conn, $id){
	$sql = "SELECT COUNT(*) FROM tasks WHERE due_date < CURDATE() AND status != 'completed' AND assigned_to = ? AND due_date != '0000-00-00'";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchColumn();
}

function count_my_tasks_NoDeadline($conn, $id){
	$sql = "SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND status != 'completed' AND (due_date IS NULL OR due_date = '0000-00-00')";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchColumn();
}

function count_my_pending_tasks($conn, $id){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status = 'pending' AND assigned_to = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchColumn();
}

function count_my_in_progress_tasks($conn, $id){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status = 'in_progress' AND assigned_to = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchColumn();
}

function count_my_completed_tasks($conn, $id){
	$sql = "SELECT COUNT(*) FROM tasks WHERE status = 'completed' AND assigned_to = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);
	return $stmt->fetchColumn();
}