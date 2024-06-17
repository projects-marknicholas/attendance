<?php
class AuthController {
  // login
  public function login() {
    global $conn;
  
    $response = array();
  
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
  
    if (empty($username)) {
      $response['status'] = 'error';
      $response['message'] = 'Username is required.';
      echo json_encode($response);
      return;
    }
  
    if (empty($password)) {
      $response['status'] = 'error';
      $response['message'] = 'Password is required.';
      echo json_encode($response);
      return;
    }
  
    // Retrieve user from database by username
    $stmt = $conn->prepare("SELECT user_id, full_name, username, password, created_at FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
  
    if($result->num_rows == 0){
      $response['status'] = 'error';
      $response['message'] = 'User not found.';
      echo json_encode($response);
      return;
    }
  
    $user = $result->fetch_assoc();
  
    // Verify password
    if(!password_verify($password, $user['password'])){
      $response['status'] = 'error';
      $response['message'] = 'Invalid username or password.';
      echo json_encode($response);
    }
    else {
      unset($user['password']);
      $response['status'] = 'success';
      $response['message'] = 'Login successful.';
      $response['user'] = $user;
      echo json_encode($response);
    }
  }
}
?>
