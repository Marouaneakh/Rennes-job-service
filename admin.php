<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Job Applications</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; padding: 40px; background-color: #f5f5f5; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th, td { padding: 16px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #000; color: #fff; }
        tr:hover { background-color: #f9f9f9; }
        h1 { margin-bottom: 24px; }
        .no-data { padding: 20px; background: white; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>Company Job Applications</h1>
    
    <?php
    $file = 'submissions.json';
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true);
        
        if (!empty($data)) {
            echo '<table>';
            echo '<thead><tr><th>Date</th><th>Name</th><th>Last Name</th><th>Job</th><th>Work Link</th><th>Description</th></tr></thead>';
            echo '<tbody>';
            
            // Reverse array to show newest first
            $data = array_reverse($data);
            
            foreach ($data as $entry) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($entry['timestamp'] ?? 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars($entry['name']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['lastname']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['job']) . '</td>';
                echo '<td><a href="' . htmlspecialchars($entry['workLink']) . '" target="_blank">View Link</a></td>';
                echo '<td>' . htmlspecialchars($entry['description']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="no-data">No applications received yet.</div>';
        }
    } else {
        echo '<div class="no-data">No submissions file found yet. (Submit a form first!)</div>';
        echo '<p style="text-align:center; color:#666; margin-top:10px;">Expected location: ' . htmlspecialchars(getcwd() . DIRECTORY_SEPARATOR . $file) . '</p>';
    }
    ?>

    <h1 style="margin-top: 60px;">Student Applications</h1>
    <?php
    $studentFile = 'students.json';
    if (file_exists($studentFile)) {
        $studentData = json_decode(file_get_contents($studentFile), true);
        
        if (!empty($studentData)) {
            echo '<table>';
            echo '<thead><tr><th>Date</th><th>Name</th><th>Last Name</th><th>Description</th><th>CV</th></tr></thead>';
            echo '<tbody>';
            $studentData = array_reverse($studentData);
            foreach ($studentData as $entry) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($entry['timestamp'] ?? 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars($entry['name']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['lastname']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['description']) . '</td>';
                $cvLink = !empty($entry['cv']) ? '<a href="' . htmlspecialchars($entry['cv']) . '" target="_blank">Download CV</a>' : 'No CV';
                echo '<td>' . $cvLink . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="no-data">No student applications received yet.</div>';
        }
    } else {
        echo '<div class="no-data">No student submissions file found yet.</div>';
    }
    ?>

    <h1 style="margin-top: 60px;">Problem Reports</h1>
    <?php
    $reportFile = 'reports.json';
    if (file_exists($reportFile)) {
        $reportData = json_decode(file_get_contents($reportFile), true);
        
        if (!empty($reportData)) {
            echo '<table>';
            echo '<thead><tr><th>Date</th><th>Email</th><th>Description</th></tr></thead>';
            echo '<tbody>';
            $reportData = array_reverse($reportData);
            foreach ($reportData as $entry) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($entry['timestamp'] ?? 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars($entry['email']) . '</td>';
                echo '<td>' . htmlspecialchars($entry['description']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="no-data">No reports received yet.</div>';
        }
    } else {
        echo '<div class="no-data">No reports file found yet.</div>';
    }
    ?>
</body>
</html>