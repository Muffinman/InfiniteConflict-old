html{
  width:100%;
  height:100%;
  background: black url(/images/background.jpg) top right no-repeat;
}

body{
  width:100%;
  height:100%;
  background:none;
}

#login{
  position:relative;
  width:480px;
  height:280px;
  margin:0px auto;
  top:50%;
  margin-top:-150px;
  background:url(/images/login.png) top left no-repeat;
  padding:10px;
}

#login h1{
  font-family:Play, 'Arial Black', sans-serif;
  font-size:30px;
  height:35px;
  line-height:35px;
  margin-bottom:10px;
  text-transform:uppercase;
  text-shadow:0px 0px 20px #000;
}

#login .formdiv{
  padding:12px;
  position:relative;
  height:220px;
}

#login p{
  margin-bottom:10px;
  text-shadow:1px 1px 0px #000;
}

#login .login-box{
  margin-top:20px;
}

#login input{
  background:#191919;
  border:1px solid #555;
  color:white;
  border-radius:3px;
  padding:2px;
}

#login input[type=submit]{
  width:80px;
  margin-left:160px;
}

#login input:focus{
  border-color:white;
  background:black;
}

#login input[type=submit]:hover{
  background:black;
}

#login .form-options{
  width:456px;
  position:absolute;
  bottom:0;
  text-align:center;
}