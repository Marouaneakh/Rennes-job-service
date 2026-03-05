<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $formType = $_POST['form_type'] ?? 'company';

  if ($formType === 'student') {
      // --- Handle Student Submission ---
      $name = $_POST["name"] ?? '';
      $lastname = $_POST["lastname"] ?? '';
      $description = $_POST["description"] ?? '';
      
      // Handle File Upload
      $cvPath = '';
      if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
          $uploadDir = 'uploads/';
          // Create directory if it doesn't exist
          if (!is_dir($uploadDir)) {
              mkdir($uploadDir, 0777, true);
          }
          
          $fileName = time() . '_' . basename($_FILES['cv']['name']);
          $targetFilePath = $uploadDir . $fileName;
          
          if (move_uploaded_file($_FILES['cv']['tmp_name'], $targetFilePath)) {
              $cvPath = $targetFilePath;
          } else {
              echo json_encode(["status" => "error", "message" => "Failed to upload file."]);
              exit;
          }
      }

      $newEntry = [
          "timestamp" => date("Y-m-d H:i:s"),
          "name" => $name,
          "lastname" => $lastname,
          "description" => $description,
          "cv" => $cvPath
      ];

      $file = 'students.json';
      $currentData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
      $currentData[] = $newEntry;

      if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
          echo json_encode(["status" => "success", "message" => "Student information saved successfully."]);
      } else {
          echo json_encode(["status" => "error", "message" => "Failed to save student file."]);
      }

  } elseif ($formType === 'report') {
      // --- Handle Report Submission ---
      $email = $_POST["email"] ?? '';
      $description = $_POST["description"] ?? '';

      $newEntry = [
          "timestamp" => date("Y-m-d H:i:s"),
          "email" => $email,
          "description" => $description
      ];

      $file = 'reports.json';
      $currentData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
      $currentData[] = $newEntry;

      if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
          echo json_encode(["status" => "success", "message" => "Report submitted successfully."]);
      } else {
          echo json_encode(["status" => "error", "message" => "Failed to save report."]);
      }

  } elseif ($formType === 'signup') {
      // --- Handle Sign Up (Save User) ---
      $name = $_POST["name"] ?? '';
      $email = $_POST["email"] ?? '';
      $password = $_POST["password"] ?? ''; // In a real app, hash this!

      $newEntry = [
          "timestamp" => date("Y-m-d H:i:s"),
          "name" => $name,
          "email" => $email,
          "password" => $password 
      ];

      $file = 'users.json';
      $currentData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
      $currentData[] = $newEntry;

      if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
          echo json_encode(["status" => "success", "message" => "Account created successfully."]);
      } else {
          echo json_encode(["status" => "error", "message" => "Failed to create account."]);
      }

  } elseif ($formType === 'login') {
      // --- Handle Login (Simulation) ---
      // In a real app, you would verify credentials here.
      echo json_encode(["status" => "success", "message" => "Logged in successfully."]);

  } else {
      // --- Handle Company Submission (Existing) ---
      $name = $_POST["name"] ?? '';
      $lastname = $_POST["lastname"] ?? '';
      $job = $_POST["job"] ?? '';
      $description = $_POST["description"] ?? '';
      
      // Handle File Upload for Company
      $workInfoPath = '';
      if (isset($_FILES['workInfo']) && $_FILES['workInfo']['error'] == 0) {
          $uploadDir = 'uploads/';
          // Create directory if it doesn't exist
          if (!is_dir($uploadDir)) {
              mkdir($uploadDir, 0777, true);
          }
          
          $fileName = time() . '_company_' . basename($_FILES['workInfo']['name']);
          $targetFilePath = $uploadDir . $fileName;
          
          if (move_uploaded_file($_FILES['workInfo']['tmp_name'], $targetFilePath)) {
              $workInfoPath = $targetFilePath;
          }
      }

      $newEntry = [
          "timestamp" => date("Y-m-d H:i:s"),
          "workInfo" => $workInfoPath,
          "name" => $name,
          "lastname" => $lastname,
          "job" => $job,
          "description" => $description
      ];

      $file = 'submissions.json';
      $currentData = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
      $currentData[] = $newEntry;

      if (file_put_contents($file, json_encode($currentData, JSON_PRETTY_PRINT))) {
          echo json_encode(["status" => "success", "message" => "Information saved successfully."]);
      } else {
          echo json_encode(["status" => "error", "message" => "Failed to save file. Check folder permissions."]);
      }
  }
}
?>