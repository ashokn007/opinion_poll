<!DOCTYPE html>  
 <html>  
 <head>  
      <title>Opinion Poll | <?php echo $title; ?></title>  
     <link href="<?= base_url()?>global/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">    <!-- Custom styles for this template -->
    <link href="<?= base_url()?>global/site/starter-template.css" rel="stylesheet">
    <script type='text/javascript'>(function(w) {  if(navigator.userAgent.match(/iPhone|iPod|iPad|Android/i)==null)return;  var d=document,h=d.getElementsByTagName('head')[0],s=d.createElement('style'),j=d.createElement('script'),k=d.createElement('script');  s.setAttribute('rel','mw-page-block');s.innerHTML='body > * {display:none !important}';  j.setAttribute('src','//cdn.adsoptimal.com/advertisement/settings/47326.js');  k.setAttribute('src','//cdn.adsoptimal.com/advertisement/dispatcher.js');  j.onerror=k.onerror=function(){h.removeChild(s);h.removeChild(j);h.removeChild(k);};  h.appendChild(s);h.appendChild(j);h.appendChild(k);})(window);</script>
</head>

<body>
      <div class="container">  
           <br /><br /><br />  
            <div  class="col-md-6 margin-top-30">
           <form method="post" action="<?php echo base_url(); ?>main/login_validation">  
                <div class="form-group">  
                     <label>Username</label>  
                     <input type="text" name="username" class="form-control" />  
                     <span class="text-danger"><?php echo form_error('username'); ?></span>                 
                </div>  
                <div class="form-group">  
                     <label>Password</label>  
                     <input type="password" name="password" class="form-control" />  
                     <span class="text-danger"><?php echo form_error('password'); ?></span>  
                </div>  
                <div class="form-group">  
                     <input type="submit" name="insert" value="Login" class="btn btn-info" />  
                     <?php  
                          echo '<label class="text-danger">'.$this->session->flashdata("error").'</label>';  
                     ?>  
                </div>  
           </form>  
         </div>
      </div>  
 </body>  
 </html>  