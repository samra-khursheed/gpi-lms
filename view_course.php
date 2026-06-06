<?php
$conn = mysqli_connect("localhost", "root", "", "lms_db"); 

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    
    $query = "SELECT * FROM lms_courses WHERE id = '$course_id'";
    $result = mysqli_query($conn, $query);
    $course = mysqli_fetch_assoc($result);
    
    if (!$course) {
        die("Course not found in database!");
    }
} else {
    die("No course selected!");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course['course_title']; ?> - LMS</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM+Sans', sans-serif; background-color: #f8fafc; margin: 0; padding: 0; color: #0a0f2c; }
        .course-container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .back-btn { display: inline-block; text-decoration: none; color: #1a56db; font-weight: 600; margin-bottom: 20px; font-size: 14px; }
        .course-header { margin-bottom: 30px; }
        .course-header h1 { font-family: 'Syne', sans-serif; font-size: 32px; margin: 0 0 10px 0; color: #0a0f2c; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .badge-inter { background: #eff6ff; color: #1a56db; }
        .badge-adv { background: #fef2f2; color: #ef4444; }
        .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); background: #000; }
        .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }
        .course-desc { margin-top: 25px; line-height: 1.7; color: #475569; font-size: 16px; background: white; padding: 25px; border-radius: 14px; border: 1px solid #e2e8f0; }
        .course-desc h3 { margin-top: 0; font-family: 'Syne', sans-serif; color: #0a0f2c; }
    </style>
</head>
<body>

<div class="course-container">
    <a href="student_dashboard.php" class="back-btn">← Back to Dashboard</a>
    
    <div class="course-header">
        <h1><?php echo $course['course_title']; ?> (<?php echo $course['course_code']; ?>)</h1>
        <!-- Dynamic Level Badge -->
        <?php if($course['course_level'] == 'Advanced'): ?>
            <span class="badge badge-adv">Advanced</span>
        <?php else: ?>
            <span class="badge badge-inter">Intermediate</span>
        <?php endif; ?>
    </div>

    <!-- Video Player Screen -->
    <div class="video-wrapper">
        <?php if(!empty($course['video_url'])): ?>
            <iframe src="<?php echo $course['video_url']; ?>" allowfullscreen></iframe>
        <?php else: ?>
            <div style="color: white; text-align: center; padding-top: 20%; font-weight: 500;">No Video Available for this course yet.</div>
        <?php endif; ?>
    </div>

    <!-- Description -->
    <div class="course-desc">
        <h3>Course Description</h3>
        <p><?php echo $course['course_description']; ?></p>
    </div>
</div>

</body>
</html>