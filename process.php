<?php
$db=mysqli_connect('localhost','sumtech3d_internship_user','V85Vo5ZFuJNB','sumtech3d_internship');
$boundary = md5("random");
$reply_to='intership@sumtechonline.com';
$to='intership@sumtechonline.com';

if(isset($_POST['action']))
{
	$action=$_POST['action'];

	if($action=='register')
	{
	    $response = array();
	    

	    $name=mysqli_real_escape_string($db,$_POST['name']);
		$email=mysqli_real_escape_string($db,$_POST['email']);
		$dob=$_POST['dob'];
		$gender=mysqli_real_escape_string($db,$_POST['gender']);
		$mobile=mysqli_real_escape_string($db,$_POST['mobile']);
		$address=mysqli_real_escape_string($db,$_POST['address']);
		$category=mysqli_real_escape_string($db,$_POST['category']);
		$job=mysqli_real_escape_string($db,$_POST['job']);
		$file_name = $_FILES["file"]["name"];
        $file_tmp_name = $_FILES["file"]["tmp_name"];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];
        
        $ext=pathinfo($file_name, PATHINFO_EXTENSION);
        $new_file_name=$name.'.'.$ext;
        $upload_path='resumes/'.$new_file_name;
        
        if (strtolower($file_type) != "application/pdf" && strtolower($file_type) != "application/doc" && strtolower($file_type)!= "application/docx") 
            {    
              echo 'Invalid File Type! Only PDF,DOCX,DOC are allowed';
              exit();
            }
        
       if (move_uploaded_file($file_tmp_name, $upload_path)) 
       {     
        $query="INSERT INTO `register`(`name`, `email`, `dob`, `gender`, `mobile`, `address`, `internship_category`, `job_type`, `resume`) VALUES ('$name','$email','$dob','$gender','$mobile','$address','$category','$job','$new_file_name')"; 
        $result=mysqli_query($db,$query);
          if($result)
          {
                $message = '
        		<html>
        		<head>
        		<title>Contact Enquiry Details</title>
        		<style>
                #customers {
                  font-family: Arial, Helvetica, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
                }
                
                #customers td, #customers th {
                  border: 1px solid #ddd;
                  padding: 8px;
                }
                
                #customers tr:nth-child(even){background-color: #0b5ed7;}
                
                #customers tr:hover {background-color: #ddd;}
                
                #customers th {
                  padding-top: 12px;
                  padding-bottom: 12px;
                  text-align: left;
                  background-color: #04AA6D;
                  color: white;
                }
                </style>
        		</head>
        		<body>
        		<p>All the details of the enquiry are listed below :</p>
        		<table id="customers">
        		<tr>
        		<th>Name</th>
        		<td>'.$name.'</td>
        		</tr>
        		<tr>
        		<th>Email</th>
        		<td>'.$email.'</td>
        		</tr>
        		<tr>
        		<th>Date Of Birth</th>
        		<td>'.$dob.'</td>
        		</tr>
        		<tr>
        		<th>Gender</th>
        		<td>'.$gender.'</td>
        		</tr>
        		<tr>
        		<th>Job Applying For</th>
        		<td>'.$job.'</td>
        		</tr>
        		<tr>
        		<th>Mobile</th>
        		<td>'.$mobile.'</td>
        		</tr>
        		<tr>
        		<th>Address</th>
        		<td>'.$address.'</td>
        		</tr>
        		<tr>
        		<th>Internship Category</th>
        		<td>'.$category.'</td>
        		</tr>
        		</table>
        		</body>
        		</html>
        		';    
                
                $handle = fopen($file_tmp_name, "r"); // set the file handle only for reading the file
                $file_content = fread($handle, $file_size); // reading the file
                fclose($handle);
                $encoded_content = chunk_split(base64_encode($file_content));
                
                $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
                $headers .= "From:".$email."\r\n"; // Sender Email
                $headers .= "Reply-To: ".$reply_to."\r\n"; // Email address to reach back
                $headers .= "Content-Type: multipart/mixed;"; // Defining Content-Type
                $headers .= "boundary = $boundary\r\n"; //Defining the Boundary
        
                $body = "--$boundary\r\n";
                $body .= "Content-Type: text/html; charset=UTF-8\r\n";
                $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
                $body .= chunk_split(base64_encode($message));
               
                $body .= "--$boundary\r\n";
                $body .="Content-Type: $file_type; name=".$file_name."\r\n";
                $body .="Content-Disposition: attachment; filename=".$file_name."\r\n";
                $body .="Content-Transfer-Encoding: base64\r\n";
                $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
                $body .= $encoded_content; // Attaching the encoded file with email
                
                 $sentMailResult = mail($to, $subject, $body, $headers);  
                 
        	      if($sentMailResult)
                  {
                    $response['status'] = 'success';
                  }
                  else
                  {
                    $response['status'] = 'Error Occured! Please Try Again';
                  }
                  
                  
                  
          }
          else
          {
              $response['status'] = 'mysqli error occured!';
          }
       }
       else
       {
           $response['status'] = 'file not uploaded';
       }
       
       echo json_encode($response);
       exit;
	}    
}	
?>