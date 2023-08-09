<?php require_once('header.php');?>
 <title>Registration | Internship Opportunity By Sum Technologies & Hayaty Events</title>
  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
      </div>
    </section><!-- End Breadcrumbs -->
    <br><br>
     <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>INTERNSHIP REGISTRATION</h2>
        </div>
        <br>
        <div class="row">

          <div class="col-lg-6">
           <img src="assets/img/features-4.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 mt-4 mt-md-0">
            <form  method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label>Full Name</label>    
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name">
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                    <label>Email Address</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
                </div>
              </div>
              <br>
               <div class="row">
                <div class="col-md-6 form-group">
                    <label>Date Of Birth</label>
                  <input type="date" name="dob" class="form-control" id="dob" placeholder="Your Date Of Birth">
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                    <label>Gender</label>
                  <select class="form-control" name="gender" id="gender" placeholder="Select Gender">
                     <option value="">Select Gender</option> 
                     <option value="Male">Male</option>
                     <option value="Female">Female</option>
                     <option value="Other">Other</option>
                  </select>      
                </div>
              </div>
              
              
                
                <div class="form-group mt-3">
                <label>Mobile Number</label>    
                  <input type="tel" name="mobile" class="form-control" id="mobile" placeholder="Your Mobile Number">
                </div>

                <div class="form-group mt-3">
                <label>Address</label>    
                  <input type="text" class="form-control" name="address" id="address" placeholder="Your Address">
                </div>
                
                 <div class="form-group mt-3">
                <label>Internship Category</label>     
                  <select class="form-control" name="category" id="category" placeholder="Select Category">
                     <option value="">Select Internship Category</option> 
                     <option value="Information Technology">Information Technology</option>
                     <option value="Event Planning">Event Planning</option>
                  </select>
                </div>
                
                 <div class="form-group mt-3">
                     <label>Job Type</label>
                  <select class="form-control" name="job" id="job" placeholder="">
                     <option value="">Select Job You Are Applying For</option> 
                     <option value="Telesales">Telesales</option>
                     <option value="Marketing">Marketing</option>
                     <option value="Sales">Sales</option>
                     <option value="Social media">Social media</option>
                     <option value="Digital marketing">Digital marketing</option>
                     <option value="Content  writing">Content  writing</option>
                  </select> 
                </div>
              

              <div class="form-group mt-3">
                  <label>Resume</label>
                <input type="file" onchange="file_check(event)" class="form-control" id="resume" name="resume" placeholder="Upload Resume File">
                <small style="color: #3498db ">*Resume file types allowed : .pdf, .docx & Max file size:2 MB*</small>
              </div>
              <div class="my-3">
                <div class="loading">Loading...</div>
                <div class="error-message"></div>
                <div class="sent-message">Thank you! Enquiry Submitted Successfully.</div>
              </div>
              <div class="text-center"><button onclick="register(event)" class="btn btn-primary">Register</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->


  </main><!-- End #main -->
<?php require_once('footer.php');?>
<script type="text/javascript">
 function file_check(e)
 {
   e.preventDefault();  
   var resume=$('#resume').val();
   var ext = resume.split('.').pop(); 
   const fileSize =document.getElementById("resume").files.item(0).size;
   const fileMb = fileSize / 1024 ** 2;

   if(ext!="pdf" && ext!="docx" && ext!="doc")
   {
      $('.error-message').show();
      $('.error-message').html('Only PDF,DOCX,DOC are allowed!');
      return false;
   }
   else if(fileMb>2)
   {
      $('.error-message').show();
      $('.error-message').html('Max file size allowed: 2MB');
      return false; 
   }
   else
   {
      $('.error-message').hide();
      $('.error-message').html(''); 
   }
 }
 
  function register(e)
  {
    e.preventDefault();
    var name=$('#name').val();
    var email=$('#email').val();
    var dob=$('#dob').val();
    var gender=$('#gender').val();
    var mobile=$('#mobile').val();
    var address=$('#address').val();
    var category=$('#category').val(); 
    var job=$('#job').val(); 
    var resume=$('#resume').val();
    
    var resume_file=$('#resume')[0].files;

    if(name=='' || email=='' || dob=='' || gender=='' || job=='' || mobile=='' || address=='' || resume=='')
    {
      $('.error-message').show();
      $('.error-message').html('Fields are missing! Please fill them');
      return false;
    }  
    else
    {
       $('.error-message').hide();
       $('.error-message').html('');

    }
    
    let formData = new FormData();           
    formData.append("action", "register");
    formData.append("name", name);
    formData.append("email", email);
    formData.append("dob", dob);
    formData.append("gender", gender);
    formData.append("mobile", mobile);
    formData.append("address", address);
    formData.append("category", category);
    formData.append("job", job);
    formData.append("file", resume_file[0]);

    $('.loading').show();

    $.ajax({
      url: "process.php", 
      method:"POST",
      dataType: 'json',
      contentType: false,
      processData: false,
      cache : false,
      data : formData,
      success: function(result){
      if(result.status=='success')
      {
        $('.error-message').hide();
        $('.loading').hide();
        $('.sent-message').show();
         window.setTimeout(function(){
        $('.error-message').hide();
        $('.loading').hide();
        $('.sent-message').hide();
        $('#name').val('');
        $('#email').val('');
        $('#dob').val('');
        $('#gender').val('');
        $('#mobile').val('');
        $('#address').val('');
        $('#category').val('');
        $('#job').val('');
        $('#resume').val('');
         }, 2000); 

      }  
      else
      {
        $('.error-message').show();
        $('.loading').hide();
        $('.sent-message').hide();
        $('.error-message').html('Error Occured! Please Try Again');
        window.setTimeout(function(){
        $('.error-message').hide();
        $('.loading').hide();
        $('.sent-message').hide();
        $('#name').val('');
        $('#email').val('');
        $('#dob').val('');
        $('#gender').val('');
        $('#mobile').val('');
        $('#address').val('');
        $('#category').val('');
        $('#job').val('');
        $('#resume').val('');
         }, 2000); 
      } 
     }  
    }); 
  }
</script>