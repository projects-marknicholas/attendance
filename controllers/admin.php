<?php
class AdminController {

  public function course() {
    global $conn;
    
    $response = array();

    $course_id = 'CRS-' . rand(000000, 999999);
    $course = $_POST['course'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Check if any of the required fields are empty
    if (empty($course_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Course ID is required.';
      echo json_encode($response);
      return;
    }

    if (empty($course)) {
      $response['status'] = 'error';
      $response['message'] = 'Course is required.';
      echo json_encode($response);
      return;
    }

    if (empty($description)) {
      $response['status'] = 'error';
      $response['message'] = 'Description is required.';
      echo json_encode($response);
      return;
    }

    // Check for duplicate course name
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM course WHERE course = ?");
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
      $response['status'] = 'error';
      $response['message'] = 'Course with the same name already exists.';
      echo json_encode($response);
      return;
    }

    // Prepare an SQL statement to insert the data
    $stmt = $conn->prepare("INSERT INTO course (course_id, course, description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $course_id, $course, $description);
    
    if ($stmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Course inserted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to insert course.';
    }

    echo json_encode($response);
    $stmt->close();
  }

  public function subject() {
    global $conn;
    
    $response = array();

    $subject_id = 'SUB-' . rand(000000, 999999);
    $subject_code = $_POST['subject_code'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $subject_unit = $_POST['subject_unit'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Check if any of the required fields are empty
    if (empty($subject_code)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject Code is required.';
      echo json_encode($response);
      return;
    }

    if (empty($subject)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject is required.';
      echo json_encode($response);
      return;
    }

    if (empty($subject_unit)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject Unit is required.';
      echo json_encode($response);
      return;
    }

    // Check for duplicate subject code
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM subject WHERE subject_code = ?");
    $stmt->bind_param("s", $subject_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
      $response['status'] = 'error';
      $response['message'] = 'Subject with the same code already exists.';
      echo json_encode($response);
      return;
    }

    // Prepare an SQL statement to insert the data
    $stmt = $conn->prepare("INSERT INTO subject (subject_id, subject_code, subject, subject_unit, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $subject_id, $subject_code, $subject, $subject_unit, $description);
    
    if ($stmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Subject inserted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to insert subject.';
    }

    echo json_encode($response);
    $stmt->close();
  }

  public function faculty() {
    global $conn;
    
    $response = array();

    $faculty_id = 'FAC-' . rand(000000, 999999);
    $id_no = $_POST['id_no'] ?? '';
    $name = $_POST['name'] ?? '';

    // Check if any of the required fields are empty
    if (empty($faculty_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID is required.';
      echo json_encode($response);
      return;
    }

    if (empty($id_no)) {
      $response['status'] = 'error';
      $response['message'] = 'ID No. is required.';
      echo json_encode($response);
      return;
    }

    if (empty($name)) {
      $response['status'] = 'error';
      $response['message'] = 'Name is required.';
      echo json_encode($response);
      return;
    }

    // Check for duplicate faculty code
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM faculty WHERE id_no = ?");
    $stmt->bind_param("s", $id_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
      $response['status'] = 'error';
      $response['message'] = $id_no . ' already exists.';
      echo json_encode($response);
      return;
    }

    // Prepare an SQL statement to insert the data
    $stmt = $conn->prepare("INSERT INTO faculty (faculty_id, id_no, name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $faculty_id, $id_no, $name);
    
    if ($stmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Faculty inserted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to insert faculty.';
    }

    echo json_encode($response);
    $stmt->close();
  }

  public function class() {
    global $conn;
    
    $response = array();

    $class_id = $_POST['class_id'] ?? '';
    $subject_code = $_POST['subject_code'] ?? '';
    $faculty_id = $_POST['faculty_id'] ?? '';

    // Check if any of the required fields are empty
    if (empty($class_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Class ID is required.';
      echo json_encode($response);
      return;
    }

    if (empty($subject_code)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject code is required.';
      echo json_encode($response);
      return;
    }

    if (empty($faculty_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID is required.';
      echo json_encode($response);
      return;
    }

    // Validate class_id format
    $valid_class_ids = array(
      '1-A', '1-B', '1-C', '1-D',
      '2-A', '2-B', '2-C', '2-D',
      '3-A', '3-B', '3-C', '3-D',
      '4-A', '4-B', '4-C', '4-D'
    );

    if (!in_array($class_id, $valid_class_ids)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid class ID format. Valid formats are 1-A to 4-D.';
      echo json_encode($response);
      return;
    }

    // Check if subject_code exists in subject table
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM subject WHERE subject_code = ?");
    $stmt->bind_param("s", $subject_code);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    if ($row['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Subject ID ' . $subject_code . ' does not exist.';
      echo json_encode($response);
      return;
    }

    // Check if id_no exists in faculty table
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM faculty WHERE id_no = ?");
    $stmt->bind_param("s", $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $row = $result->fetch_assoc();
    if ($row['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID ' . $faculty_id . ' does not exist.';
      echo json_encode($response);
      return;
    }

    // Prepare an SQL statement to insert the data into class table
    $stmt = $conn->prepare("INSERT INTO class (class_id, subject_code, faculty_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $class_id, $subject_code, $faculty_id);
    
    if ($stmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Class inserted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to insert class.';
    }

    echo json_encode($response);
    $stmt->close();
  }

  public function students() {
    global $conn;
    
    $response = array();
  
    // Get input data
    $student_id = $_POST['student_id'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $course = $_POST['course'] ?? '';
    $year_level = $_POST['year_level'] ?? '';
    $class_id = $_POST['class_id'] ?? '';
  
    // Check if any of the required fields are empty
    if (empty($student_id) || empty($first_name) || empty($last_name) || empty($course) || empty($year_level) || empty($class_id)) {
      $response['status'] = 'error';
      $response['message'] = 'All fields are required.';
      echo json_encode($response);
      return;
    }
  
    // Validate course against course table
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM course WHERE course = ?");
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
  
    $row = $result->fetch_assoc();
    if ($row['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Course ' . $course . ' does not exist.';
      echo json_encode($response);
      return;
    }
  
    // Validate class_id
    $valid_class_ids = array(
      '1-A', '1-B', '1-C', '1-D',
      '2-A', '2-B', '2-C', '2-D',
      '3-A', '3-B', '3-C', '3-D',
      '4-A', '4-B', '4-C', '4-D'
    );
  
    if (!in_array($class_id, $valid_class_ids)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid class ID. Valid class IDs are 1-A to 4-D.';
      echo json_encode($response);
      return;
    }
  
    // Validate year_level
    $valid_year_levels = array('1', '2', '3', '4');
  
    if (!in_array($year_level, $valid_year_levels)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid year level. Valid year levels are 1 to 4.';
      echo json_encode($response);
      return;
    }
  
    // Check if student_id already exists
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
      $response['status'] = 'error';
      $response['message'] = 'Student ID ' . $student_id . ' already exists.';
      echo json_encode($response);
      return;
    }
    $stmt->close();
  
    // Check if image file already exists in uploads folder
    $upload_dir = dirname(__FILE__) . '/../uploads/students/';
    $file_name = $student_id . '-' . $first_name . '-' . $last_name;
    $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $file_path = $upload_dir . $file_name . '.' . $file_extension;
    $file_data = $file_name . '.' . $file_extension;
  
    if (file_exists($file_path)) {
      $response['status'] = 'error';
      $response['message'] = 'Image file already exists.';
      echo json_encode($response);
      return;
    }
  
    // Handle image upload
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to upload image.';
      echo json_encode($response);
      return;
    }
  
    // Move uploaded file to destination
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to move uploaded file.';
      echo json_encode($response);
      return;
    }
  
    // Prepare an SQL statement to insert the data into students table
    $stmt = $conn->prepare("INSERT INTO students (image, student_id, first_name, last_name, course, year_level, class_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $file_data, $student_id, $first_name, $last_name, $course, $year_level, $class_id);
    
    if ($stmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Student inserted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to insert student.';
    }
  
    echo json_encode($response);
    $stmt->close();
  }  

  public function attendance() {
    global $conn;
    
    $response = array();
    
    // Get the raw POST data
    $input = file_get_contents('php://input');
    $attendanceData = json_decode($input, true);
    
    // Check if the input data is valid
    if (json_last_error() !== JSON_ERROR_NONE) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid JSON format.';
      echo json_encode($response);
      return;
    }
  
    // Check if the attendanceData is an array and not empty
    if (!is_array($attendanceData) || empty($attendanceData)) {
      $response['status'] = 'error';
      $response['message'] = 'Attendance data is required.';
      echo json_encode($response);
      return;
    }
  
    // Prepare the SQL statements for validation
    $checkCourseStmt = $conn->prepare("SELECT COUNT(*) as count FROM course WHERE course_id = ?");
    if (!$checkCourseStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare course validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkSubjectStmt = $conn->prepare("SELECT COUNT(*) as count FROM subject WHERE subject_id = ? OR subject_code = ?");
    if (!$checkSubjectStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare subject validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  
    $checkStudentStmt = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE student_id = ?");
    if (!$checkStudentStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare student validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    date_default_timezone_set('Asia/Manila');
    $currentDateTime = date('Y-m-d H:i:s');
    
    // Prepare the SQL statement to insert the data
    $insertStmt = $conn->prepare("INSERT INTO attendance (attendance_id, course_id, course, subject_id, subject_code, student_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$insertStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare insert statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }

    
    $attendance_id = 'AID-' . rand(000000, 999999);
  
    foreach ($attendanceData as $attendance) {
      $course_id = $attendance['course_id'] ?? '';
      $course = $attendance['course'] ?? '';
      $subject_id = $attendance['subject_id'] ?? '';
      $subject_code = $attendance['subject_code'] ?? '';
      $student_id = $attendance['student_id'] ?? '';
  
      // Check if any of the required fields are empty
      if (empty($course_id) || (empty($course) && empty($attendance['course_code'])) || empty($subject_id) || empty($subject_code) || empty($student_id)) {
        $response['status'] = 'error';
        $response['message'] = 'Course ID, Course or Course Code, Subject ID, and Student ID are required for each attendance entry.';
        echo json_encode($response);
        return;
      }
  
      // Validate course_id
      $checkCourseStmt->bind_param("s", $course_id);
      $checkCourseStmt->execute();
      $courseResult = $checkCourseStmt->get_result();
      $courseRow = $courseResult->fetch_assoc();
  
      if ($courseRow['count'] == 0) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid Course ID.';
        echo json_encode($response);
        return;
      }
  
      // Validate subject_id and subject_code
      $checkSubjectStmt->bind_param("ss", $subject_id, $subject_code);
      $checkSubjectStmt->execute();
      $subjectResult = $checkSubjectStmt->get_result();
      $subjectRow = $subjectResult->fetch_assoc();
  
      if ($subjectRow['count'] == 0) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid Subject ID or Subject Code.';
        echo json_encode($response);
        return;
      }
  
      // Validate student_id
      $checkStudentStmt->bind_param("s", $student_id);
      $checkStudentStmt->execute();
      $studentResult = $checkStudentStmt->get_result();
      $studentRow = $studentResult->fetch_assoc();
  
      if ($studentRow['count'] == 0) {
        $response['status'] = 'error';
        $response['message'] = 'Invalid Student ID.';
        echo json_encode($response);
        return;
      }
  
      // Bind the parameters
      $insertStmt->bind_param("sssssss", $attendance_id, $course_id, $course, $subject_id, $subject_code, $student_id, $currentDateTime);
  
      // Execute the statement and check for errors
      if (!$insertStmt->execute()) {
        $response['status'] = 'error';
        $response['message'] = 'Failed to insert attendance data.';
        echo json_encode($response);
        $insertStmt->close();
        return;
      }
    }
  
    $response['status'] = 'success';
    $response['message'] = 'Attendance data inserted successfully.';
    
    echo json_encode($response);
    $checkCourseStmt->close();
    $checkSubjectStmt->close();
    $checkStudentStmt->close();
    $insertStmt->close();
  }           

  public function fetch_course() {
    global $conn;
  
    $response = array();
  
    // Prepare an SQL statement to fetch all courses
    $stmt = $conn->prepare("SELECT course_id, course, description, created_at FROM course ORDER BY created_at DESC");
  
    // Execute the statement
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      
      // Check if any courses are found
      if ($result->num_rows > 0) {
        $courses = array();
        
        // Fetch each course and add it to the courses array
        while ($row = $result->fetch_assoc()) {
          $courses[] = $row;
        }
        
        $response['status'] = 'success';
        $response['data'] = $courses;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'No courses found.';
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch courses.';
    }
  
    // Send the response in JSON format
    echo json_encode($response);
  
    $stmt->close();
  }

  public function fetch_subject() {
    global $conn;
  
    $response = array();
  
    // Prepare an SQL statement to fetch all subjects
    $stmt = $conn->prepare("SELECT subject_id, subject_code, subject, subject_unit, description, created_at FROM subject ORDER BY created_at DESC");
  
    // Execute the statement
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      
      // Check if any subject are found
      if ($result->num_rows > 0) {
        $subject = array();
        
        // Fetch each subject and add it to the subject array
        while ($row = $result->fetch_assoc()) {
          $subject[] = $row;
        }
        
        $response['status'] = 'success';
        $response['data'] = $subject;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'No subject found.';
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch subject.';
    }
  
    // Send the response in JSON format
    echo json_encode($response);
  
    $stmt->close();
  }
  
  public function fetch_all_subject() {
    global $conn;
  
    $response = array();
  
    // Prepare an SQL statement to fetch all subjects
    $stmt = $conn->prepare("SELECT subject_id, subject_code, subject FROM subject ORDER BY subject");
  
    // Execute the statement
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      
      // Check if any subject are found
      if ($result->num_rows > 0) {
        $subject = array();
        
        // Fetch each subject and add it to the subject array
        while ($row = $result->fetch_assoc()) {
          $subject[] = $row;
        }
        
        $response['status'] = 'success';
        $response['data'] = $subject;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'No subject found.';
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch subject.';
    }
  
    // Send the response in JSON format
    echo json_encode($response);
  
    $stmt->close();
  }
  
  public function fetch_subject_id() {
    global $conn;
  
    $response = array();
    
    $subject_code = $_GET['subject_code'] ?? ''; // Access subject_code from GET parameters
  
    // Prepare an SQL statement to fetch subjects based on subject_code
    $stmt = $conn->prepare("SELECT subject_id FROM subject WHERE subject_code = ?");
  
    // Bind parameter for subject_code
    $stmt->bind_param("s", $subject_code);
  
    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        // Check if any subjects are found
        if ($result->num_rows > 0) {
            $subjects = array();
            
            // Fetch each subject and add it to the subjects array
            while ($row = $result->fetch_assoc()) {
                $subjects[] = $row;
            }
            
            $response['status'] = 'success';
            $response['data'] = $subjects;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No subjects found.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to fetch subjects.';
    }
  
    // Send the response in JSON format
    echo json_encode($response);
  
    $stmt->close();
  }

  public function fetch_faculty() {
    global $conn;
  
    $response = array();
  
    // Prepare an SQL statement to fetch all faculty
    $stmt = $conn->prepare("SELECT faculty_id, id_no, name, created_at FROM faculty ORDER BY name");
  
    // Execute the statement
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      
      // Check if any faculty are found
      if ($result->num_rows > 0) {
        $faculty = array();
        
        // Fetch each faculty and add it to the faculty array
        while ($row = $result->fetch_assoc()) {
          $faculty[] = $row;
        }
        
        $response['status'] = 'success';
        $response['data'] = $faculty;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'No faculty found.';
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch faculty.';
    }
  
    // Send the response in JSON format
    echo json_encode($response);
  
    $stmt->close();
  }

  public function fetch_class() {
    global $conn;

    $response = array();

    // Prepare an SQL statement to fetch all classes
    $stmt = $conn->prepare("SELECT class_id, subject_code, faculty_id, created_at FROM class");

    // Execute the statement
    if ($stmt->execute()) {
      $result = $stmt->get_result();

      // Check if any classes are found
      if ($result->num_rows > 0) {
        $classes = array();

        // Fetch each class and add it to the classes array
        while ($row = $result->fetch_assoc()) {
          $class = array(
            'class_id' => $row['class_id'],
            'subject_code' => $row['subject_code'],
            'id_no' => $row['faculty_id'],
            'created_at' => $row['created_at'],
            'subject' => '',
            'name' => ''  // Initialize the 'name' field
          );

          // Fetch subject details
          $subject_stmt = $conn->prepare("SELECT subject FROM subject WHERE subject_code = ?");
          $subject_stmt->bind_param("s", $row['subject_code']);
          if ($subject_stmt->execute()) {
            $subject_result = $subject_stmt->get_result();
            if ($subject_result->num_rows > 0) {
              $subject_row = $subject_result->fetch_assoc();
              $class['subject'] = $subject_row['subject'];
            }
          }
          $subject_stmt->close();

          // Fetch faculty details
          $faculty_stmt = $conn->prepare("SELECT name FROM faculty WHERE id_no = ?");
          $faculty_stmt->bind_param("s", $row['faculty_id']); // Assuming faculty_id is stored as a string (varchar) in the database
          if ($faculty_stmt->execute()) {
            $faculty_result = $faculty_stmt->get_result();
            if ($faculty_result->num_rows > 0) {
              $faculty_row = $faculty_result->fetch_assoc();
              $class['name'] = $faculty_row['name']; // Assign faculty name to 'name' field
            }
          }
          $faculty_stmt->close();

          $classes[] = $class;
        }

        $response['status'] = 'success';
        $response['data'] = $classes;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'No classes found.';
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch classes.';
    }

    // Send the response in JSON format
    echo json_encode($response);

    $stmt->close();
  }

  public function fetch_students() {
    global $conn;
  
    $response = array();
  
    // Prepare an SQL statement to fetch all students
    $stmt = $conn->prepare("SELECT student_id, image, first_name, last_name, course, year_level, class_id, created_at FROM students ORDER BY created_at DESC");
  
    // Execute the statement
    if ($stmt->execute()) {
      $result = $stmt->get_result();
  
      // Check if any students are found
      if ($result->num_rows > 0) {
        $students = array();
  
        // Fetch each student and add it to the students array
        while ($row = $result->fetch_assoc()) {
          // Fetch course_id for the current student's course
          $course = $row['course'];
          $course_id = null;
  
          // Prepare an SQL statement to fetch course_id based on course name
          $stmt_course = $conn->prepare("SELECT course_id FROM course WHERE course = ?");
          $stmt_course->bind_param("s", $course);
  
          // Execute the course statement
          $stmt_course->execute();
          $stmt_course->bind_result($course_id);
          $stmt_course->fetch();
  
          // Close the course statement
          $stmt_course->close();
  
          // Add course_id to the row
          $row['course_id'] = $course_id;
  
          $students[] = $row;
        }
  
        $response['status'] = 'success';
        $response['data'] = $students;
      } else {
        $response['status'] = 'error';
        $response['message'] = 'No students found.';
      }
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch students.';
    }
  
    // Send the response in JSON format
    echo json_encode($response);
  
    $stmt->close();
  }

  public function fetch_attendance() {
    global $conn;
  
    $response = array();
  
    // Prepare the SQL statement to fetch attendance data with related subject information
    $query = "SELECT a.attendance_id, a.subject_id, a.subject_code, a.course_id, a.course, a.student_id, s.subject, a.created_at
              FROM attendance a
              LEFT JOIN subject s ON a.subject_id = s.subject_id GROUP BY attendance_id ORDER BY created_at DESC";
  
    $result = $conn->query($query);
  
    if (!$result) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to fetch attendance data: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  
    $attendanceData = array();
    while ($row = $result->fetch_assoc()) {
      // Construct each attendance entry
      $attendanceEntry = array(
        'attendance_id' => $row['attendance_id'],
        'subject_id' => $row['subject_id'],
        'subject_code' => $row['subject_code'],
        'subject' => $row['subject'],
        'course_id' => $row['course_id'],
        'course' => $row['course'],
        'student_id' => $row['student_id'],
        'created_at' => $row['created_at']
      );
      $attendanceData[] = $attendanceEntry;
    }
  
    $response['status'] = 'success';
    $response['data'] = $attendanceData;
    echo json_encode($response);
  }  

  public function fetch_view_attendance() {
    global $conn;

    $response = array();

    $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
    $subject_code = isset($_GET['subject_code']) ? $_GET['subject_code'] : '';
    $attendance_id = isset($_GET['attendance_id']) ? $_GET['attendance_id'] : '';

    // Check if any of the required fields are empty
    if (empty($subject_id) || empty($subject_code) || empty($attendance_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject ID, Subject code, and Attendance ID are required.';
      echo json_encode($response);
      return;
    }

    // Prepare the SQL statement to fetch attendance details including student names
    $query = "SELECT a.student_id, CONCAT(s.first_name, ' ', s.last_name) AS student_name, s.course,
					 a.attendance_id, a.created_at
			  FROM attendance a
			  INNER JOIN students s ON a.student_id = s.student_id
			  WHERE a.subject_id = ? AND a.subject_code = ? AND a.attendance_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($query);
    if (!$stmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare query: ' . $conn->error;
      echo json_encode($response);
      return;
    }

    $stmt->bind_param("sss", $subject_id, $subject_code, $attendance_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to execute query: ' . $stmt->error;
      echo json_encode($response);
      return;
    }

    $attendanceData = array();
    while ($row = $result->fetch_assoc()) {
      // Construct each attendance entry
      $attendanceEntry = array(
        'student_id' => $row['student_id'],
        'student_name' => $row['student_name'],
        'course' => $row['course'],
        'created_at' => $row['created_at'],
        'attendance_id' => $row['attendance_id']
      );
      $attendanceData[] = $attendanceEntry;
    }

    if (empty($attendanceData)) {
      $response['status'] = 'error';
      $response['message'] = 'No attendance records found for the provided criteria.';
    } else {
      $response['status'] = 'success';
      $response['data'] = $attendanceData;
    }

    echo json_encode($response);

    // Close statement and connection
    $stmt->close();
  }

  public function put_course() {
    global $conn;
  
    $response = array();
  
    // Retrieve course_id from query parameter
    $course_id = $_GET['course_id'] ?? '';
  
    // Check if course_id is empty
    if (empty($course_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Course ID is required.';
      echo json_encode($response);
      return;
    }
  
    // Retrieve course and description from form data
    $course = $_POST['course'] ?? '';
    $description = $_POST['description'] ?? '';
  
    // Check if any of the required fields are empty
    if (empty($course)) {
      $response['status'] = 'error';
      $response['message'] = 'Course is required.';
      echo json_encode($response);
      return;
    }
  
    if (empty($description)) {
      $response['status'] = 'error';
      $response['message'] = 'Description is required.';
      echo json_encode($response);
      return;
    }
  
    // Check if the course ID exists in the database
    $checkCourseStmt = $conn->prepare("SELECT COUNT(*) as count FROM course WHERE course_id = ?");
    if (!$checkCourseStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare course validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  
    $checkCourseStmt->bind_param("s", $course_id);
    $checkCourseStmt->execute();
    $courseResult = $checkCourseStmt->get_result();
    $courseRow = $courseResult->fetch_assoc();
  
    $checkCourseStmt->close();
  
    if ($courseRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Course ID does not exist.';
      echo json_encode($response);
      return;
    }
  
    // Prepare an SQL statement to update the course
    $updateStmt = $conn->prepare("UPDATE course SET course = ?, description = ? WHERE course_id = ?");
    if (!$updateStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare update statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  
    $updateStmt->bind_param("sss", $course, $description, $course_id);
  
    if ($updateStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Course updated successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to update course.';
    }
  
    echo json_encode($response);
    $updateStmt->close();
  }  

  public function put_subject() {
    global $conn;
    
    $response = array();
    
    // Retrieve subject_id from query parameter
    $subject_id = $_GET['subject_id'] ?? '';
    
    // Check if subject_id is empty
    if (empty($subject_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject ID is required.';
      echo json_encode($response);
      return;
    }

    // Check if the subject_id exists in the database
    $checkSubjectStmt = $conn->prepare("SELECT COUNT(*) as count FROM subject WHERE subject_id = ?");
    if (!$checkSubjectStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare subject validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkSubjectStmt->bind_param("s", $subject_id);
    $checkSubjectStmt->execute();
    $subjectResult = $checkSubjectStmt->get_result();
    $subjectRow = $subjectResult->fetch_assoc();
    
    $checkSubjectStmt->close();
    
    if ($subjectRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Subject ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Retrieve subject_code, subject, subject_unit, and description from form data
    $subject_code = $_POST['subject_code'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $subject_unit = $_POST['subject_unit'] ?? '';
    $description = $_POST['description'] ?? '';
    
    // Check if subject_code is empty
    if (empty($subject_code)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject code is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if subject is empty
    if (empty($subject)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if subject_unit is empty
    if (empty($subject_unit)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject unit is required.';
      echo json_encode($response);
      return;
    }
    
    // Prepare an SQL statement to update the subject
    $updateStmt = $conn->prepare("UPDATE subject SET subject_code = ?, subject = ?, subject_unit = ?, description = ? WHERE subject_id = ?");
    if (!$updateStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare update statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $updateStmt->bind_param("sssss", $subject_code, $subject, $subject_unit, $description, $subject_id);
    
    if ($updateStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Subject updated successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to update subject.';
    }
    
    echo json_encode($response);
    $updateStmt->close();
  }  

  public function put_faculty() {
    global $conn;
  
    $response = array();
  
    // Retrieve faculty_id from query parameter
    $faculty_id = $_GET['faculty_id'] ?? '';
  
    // Check if course_id is empty
    if (empty($faculty_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID is required.';
      echo json_encode($response);
      return;
    }
  
    // Retrieve id_no and name from form data
    $id_no = $_POST['id_no'] ?? '';
    $name = $_POST['name'] ?? '';
  
    // Check if any of the required fields are empty
    if (empty($id_no)) {
      $response['status'] = 'error';
      $response['message'] = 'ID No. is required.';
      echo json_encode($response);
      return;
    }
  
    if (empty($name)) {
      $response['status'] = 'error';
      $response['message'] = 'Name is required.';
      echo json_encode($response);
      return;
    }
  
    // Check if the faculty ID exists in the database
    $checkFacultyStmt = $conn->prepare("SELECT COUNT(*) as count FROM faculty WHERE faculty_id = ?");
    if (!$checkFacultyStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare faculty validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  
    $checkFacultyStmt->bind_param("s", $faculty_id);
    $checkFacultyStmt->execute();
    $facultyResult = $checkFacultyStmt->get_result();
    $facultyRow = $facultyResult->fetch_assoc();
  
    $checkFacultyStmt->close();
  
    if ($facultyRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID does not exist.';
      echo json_encode($response);
      return;
    }
  
    // Prepare an SQL statement to update the faculty
    $updateStmt = $conn->prepare("UPDATE faculty SET id_no = ?, name = ? WHERE faculty_id = ?");
    if (!$updateStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare update statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
  
    $updateStmt->bind_param("sss", $id_no, $name, $faculty_id);
  
    if ($updateStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Faculty updated successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to update faculty.';
    }
  
    echo json_encode($response);
    $updateStmt->close();
  }

  public function put_students() {
    global $conn;
    
    $response = array();
    
    // Retrieve student_id from query parameter
    $student_id = $_GET['student_id'] ?? '';
    
    // Check if student_id is empty
    if (empty($student_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Student ID is required.';
      echo json_encode($response);
      return;
    }

    // Check if the student ID exists in the database
    $checkStudentStmt = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE student_id = ?");
    if (!$checkStudentStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare student validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkStudentStmt->bind_param("s", $student_id);
    $checkStudentStmt->execute();
    $studentResult = $checkStudentStmt->get_result();
    $studentRow = $studentResult->fetch_assoc();
    
    $checkStudentStmt->close();
    
    if ($studentRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Student ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Retrieve first_name, last_name, course, year_level, and class from form data
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $course = $_POST['course'] ?? '';
    $year_level = $_POST['year_level'] ?? '';
    $class = $_POST['class'] ?? '';
    
    // Check if any of the required fields are empty
    if (empty($first_name)) {
      $response['status'] = 'error';
      $response['message'] = 'First Name is required.';
      echo json_encode($response);
      return;
    }
    
    if (empty($last_name)) {
      $response['status'] = 'error';
      $response['message'] = 'Last Name is required.';
      echo json_encode($response);
      return;
    }
    
    if (empty($course)) {
      $response['status'] = 'error';
      $response['message'] = 'Course is required.';
      echo json_encode($response);
      return;
    }
    
    if (empty($year_level)) {
      $response['status'] = 'error';
      $response['message'] = 'Year Level is required.';
      echo json_encode($response);
      return;
    }
    
    if (empty($class)) {
      $response['status'] = 'error';
      $response['message'] = 'Class is required.';
      echo json_encode($response);
      return;
    }
    
    // Validate course against valid courses in the database
    $stmt = $conn->prepare("SELECT course FROM course");
    if (!$stmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare course validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $validCourses = array();
    while ($row = $result->fetch_assoc()) {
      $validCourses[] = $row['course'];
    }
    
    $stmt->close();
    
    if (!in_array($course, $validCourses)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid Course. Accepted courses are: ' . implode(', ', $validCourses);
      echo json_encode($response);
      return;
    }
    
    // Validate year_level
    if (!in_array($year_level, ['1', '2', '3', '4'])) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid Year Level. Accepted values are: 1, 2, 3, 4';
      echo json_encode($response);
      return;
    }
    
    // Validate class
    $validClasses = ['1-A', '1-B', '1-C', '1-D', '2-A', '2-B', '2-C', '2-D', '3-A', '3-B', '3-C', '3-D', '4-A', '4-B', '4-C', '4-D'];
    if (!in_array($class, $validClasses)) {
      $response['status'] = 'error';
      $response['message'] = 'Invalid Class. Accepted classes are: ' . implode(', ', $validClasses);
      echo json_encode($response);
      return;
    }
    
    // Prepare an SQL statement to update the student
    $updateStmt = $conn->prepare("UPDATE students SET first_name = ?, last_name = ?, course = ?, year_level = ?, class_id = ? WHERE student_id = ?");
    if (!$updateStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare update statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $updateStmt->bind_param("ssssss", $first_name, $last_name, $course, $year_level, $class, $student_id);
    
    if ($updateStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Student updated successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to update student.';
    }
    
    echo json_encode($response);
    $updateStmt->close();
  }   

  public function delete_course() {
    global $conn;
    
    $response = array();
    
    // Retrieve course_id from query parameter
    $course_id = $_GET['course_id'] ?? '';
    
    // Check if course_id is empty
    if (empty($course_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Course ID is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if the course_id exists in the database
    $checkCourseStmt = $conn->prepare("SELECT COUNT(*) as count FROM course WHERE course_id = ?");
    if (!$checkCourseStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare course validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkCourseStmt->bind_param("s", $course_id);
    $checkCourseStmt->execute();
    $courseResult = $checkCourseStmt->get_result();
    $courseRow = $courseResult->fetch_assoc();
    
    $checkCourseStmt->close();
    
    if ($courseRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Course ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Prepare SQL statement to delete course
    $deleteStmt = $conn->prepare("DELETE FROM course WHERE course_id = ?");
    if (!$deleteStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare delete statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $deleteStmt->bind_param("s", $course_id);
    
    if ($deleteStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Course deleted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete course.';
    }
    
    echo json_encode($response);
    $deleteStmt->close();
  }

  public function delete_subject() {
    global $conn;
    
    $response = array();
    
    // Retrieve subject_id from query parameter
    $subject_id = $_GET['subject_id'] ?? '';
    
    // Check if subject_id is empty
    if (empty($subject_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject ID is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if the subject_id exists in the database
    $checkSubjectStmt = $conn->prepare("SELECT COUNT(*) as count FROM subject WHERE subject_id = ?");
    if (!$checkSubjectStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare subject validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkSubjectStmt->bind_param("s", $subject_id);
    $checkSubjectStmt->execute();
    $subjectResult = $checkSubjectStmt->get_result();
    $subjectRow = $subjectResult->fetch_assoc();
    
    $checkSubjectStmt->close();
    
    if ($subjectRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Subject ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Prepare SQL statement to delete subject
    $deleteStmt = $conn->prepare("DELETE FROM subject WHERE subject_id = ?");
    if (!$deleteStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare delete statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $deleteStmt->bind_param("s", $subject_id);
    
    if ($deleteStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Subject deleted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete subject.';
    }
    
    echo json_encode($response);
    $deleteStmt->close();
  }  

  public function delete_faculty() {
    global $conn;
    
    $response = array();
    
    // Retrieve faculty_id from query parameter
    $faculty_id = $_GET['faculty_id'] ?? '';
    
    // Check if faculty_id is empty
    if (empty($faculty_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if the faculty_id exists in the database
    $checkFacultyStmt = $conn->prepare("SELECT COUNT(*) as count FROM faculty WHERE faculty_id = ?");
    if (!$checkFacultyStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare faculty validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkFacultyStmt->bind_param("s", $faculty_id);
    $checkFacultyStmt->execute();
    $facultyResult = $checkFacultyStmt->get_result();
    $facultyRow = $facultyResult->fetch_assoc();
    
    $checkFacultyStmt->close();
    
    if ($facultyRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Faculty ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Prepare SQL statement to delete faculty
    $deleteStmt = $conn->prepare("DELETE FROM faculty WHERE faculty_id = ?");
    if (!$deleteStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare delete statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $deleteStmt->bind_param("s", $faculty_id);
    
    if ($deleteStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Faculty deleted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete faculty.';
    }
    
    echo json_encode($response);
    $deleteStmt->close();
  } 
  
  public function delete_class() {
    global $conn;
    
    $response = array();
    
    // Retrieve subject_code from query parameter
    $subject_code = $_GET['subject_code'] ?? '';
    
    // Check if subject_code is empty
    if (empty($subject_code)) {
      $response['status'] = 'error';
      $response['message'] = 'Subject code is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if the subject_code exists in the database
    $checkSubjectStmt = $conn->prepare("SELECT COUNT(*) as count FROM class WHERE subject_code = ?");
    if (!$checkSubjectStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare subject validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkSubjectStmt->bind_param("s", $subject_code);
    $checkSubjectStmt->execute();
    $subjectResult = $checkSubjectStmt->get_result();
    $subjectRow = $subjectResult->fetch_assoc();
    
    $checkSubjectStmt->close();
    
    if ($subjectRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Subject code does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Prepare SQL statement to delete classes
    $deleteStmt = $conn->prepare("DELETE FROM class WHERE subject_code = ?");
    if (!$deleteStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare delete statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $deleteStmt->bind_param("s", $subject_code);
    
    if ($deleteStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Classes deleted successfully';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete classes for subject code: ' . $subject_code;
    }
    
    echo json_encode($response);
    $deleteStmt->close();
  }  

  public function delete_students() {
    global $conn;
    
    $response = array();
    
    // Retrieve student_id from query parameter
    $student_id = $_GET['student_id'] ?? '';
    
    // Check if student_id is empty
    if (empty($student_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Student ID is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if the student_id exists in the database
    $checkStudentStmt = $conn->prepare("SELECT COUNT(*) as count, image FROM students WHERE student_id = ?");
    if (!$checkStudentStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare student validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkStudentStmt->bind_param("s", $student_id);
    $checkStudentStmt->execute();
    $studentResult = $checkStudentStmt->get_result();
    $studentRow = $studentResult->fetch_assoc();
    
    $checkStudentStmt->close();
    
    if ($studentRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Student ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Delete student image file if it exists
    $imagePath = '../uploads/students/' . $studentRow['image'];
    if (file_exists($imagePath)) {
      unlink($imagePath);
    }
    
    // Prepare SQL statement to delete student
    $deleteStmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    if (!$deleteStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare delete statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $deleteStmt->bind_param("s", $student_id);
    
    if ($deleteStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Student deleted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete student.';
    }
    
    echo json_encode($response);
    $deleteStmt->close();
  }  

  public function delete_attendance() {
    global $conn;
    
    $response = array();
    
    // Retrieve attendance_id from query parameter
    $attendance_id = $_GET['attendance_id'] ?? '';
    
    // Check if attendance_id is empty
    if (empty($attendance_id)) {
      $response['status'] = 'error';
      $response['message'] = 'Attendance ID is required.';
      echo json_encode($response);
      return;
    }
    
    // Check if the attendance_id exists in the database
    $checkAttendanceStmt = $conn->prepare("SELECT COUNT(*) as count FROM attendance WHERE attendance_id = ?");
    if (!$checkAttendanceStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare attendance validation statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $checkAttendanceStmt->bind_param("s", $attendance_id);
    $checkAttendanceStmt->execute();
    $attendanceResult = $checkAttendanceStmt->get_result();
    $attendanceRow = $attendanceResult->fetch_assoc();
    
    $checkAttendanceStmt->close();
    
    if ($attendanceRow['count'] == 0) {
      $response['status'] = 'error';
      $response['message'] = 'Attendance ID does not exist.';
      echo json_encode($response);
      return;
    }
    
    // Prepare SQL statement to delete attendance
    $deleteStmt = $conn->prepare("DELETE FROM attendance WHERE attendance_id = ?");
    if (!$deleteStmt) {
      $response['status'] = 'error';
      $response['message'] = 'Failed to prepare delete statement: ' . $conn->error;
      echo json_encode($response);
      return;
    }
    
    $deleteStmt->bind_param("s", $attendance_id);
    
    if ($deleteStmt->execute()) {
      $response['status'] = 'success';
      $response['message'] = 'Attendance deleted successfully.';
    } else {
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete attendance.';
    }
    
    echo json_encode($response);
    $deleteStmt->close();
  }  
  
}
?>
