@font-face {
	font-family: Atarian;
	src: url('SF Atarian System.ttf');
}

@font-face {
	font-family: Atarian;
	font-weight: bold;
	src: url('SF Atarian System.ttf');
}

html{
  /* background: black url(/images/planet2.jpg) 0 80px no-repeat;  */
  background: black;
}


body {
  /* background: transparent url(/images/planet3.jpg) bottom right no-repeat; */
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 13px;
  color: white;
  margin:0;
  padding:0;
}

#ajax{
  display:none;
  position:fixed;
  height:100%;
  width:100%;
  background:rgba(0,0,0,0.8);
  z-index:9999;
  text-align:center;
}

#ajax img{
  display:block;
  position:absolute;
  left:50%;
  top:50%;
  margin-top:-15px;
  margin-left:-15px;
  z-index:999;
}

#background{
  height:auto;
  min-width:1024px;
  min-height:100%;
  width:100%;
  left:0;
  top:0;
  position:fixed;
  z-index:-1;
}

a {
  color: #9ce3ff;
  background-color: transparent;
  font-weight: normal;
  text-decoration:none;
}

a:hover{
  background-color: #163A65;
  color:white;
}

h1 {
  color: white;
  font-size: 16px;
  line-height:15px;
  font-weight: bold;
  margin-top:0;
}

table{
  border-collapse:collapse;
  border-spacing:0;
  width:100%;
}

table th{
  border-bottom: 2px solid #787878;
  background:#555556 url(/images/headingfade.gif) top left repeat-x;
  color:white;
  text-align:left;
  font-weight:bold;
}

td, th{
  padding:5px;
  font-size:12px;
  color:white;
}

td{
  background:#4e4e4e;
}

table tr:nth-child(2n) td{
  background:#454545;
}


label{
  display:block;
  float:left;
  width:150px;
  text-align: right;
  padding-right:10px;
  text-transform:capitalize;
}

input{
  background:black;
  color:white;
  border:1px solid #555;
}

#userbox{
  position:absolute;
  width:380px;
  height:60px;
  background: transparent url(/images/userbox.png) top left no-repeat;
  top:10px;
  right:10px;
  padding:10px;
  z-index:3;
}

#logo{
  position:absolute;
  width:380px;
  height:60px;
  top:20px;
  left:30px;
  z-index:3;
}

#logo h1{
  font-family: Play, Arial Black, sans-serif;
  font-size:45px;
  line-height:50px;
  color:#aaa;
  text-shadow:1px 1px 0 white;
}

#logo h1 span{
  color:white;
  text-shadow:1px 1px 0 black;
}

#logo h2{
  font-size:12px;
  color:#ccc;
  font-family: Play, Arial Black, sans-serif;
  float:right;
  font-weight:normal;
}

#userbox .avatar{
  float:right;
}

#container{
  width:950px;
  margin:0px auto;
  padding-top:100px;
}

#menu{
  margin:0;
  padding:0;
  height:38px;
  position:relative;
}

#menu li{
  margin:0;
  padding:0;
  list-style:none;
  display:block;
  float:left;
  margin-right:-22px;
  height:38px;
}

#menu li a{
  display:block;
  height:38px;
  width:152px;
  background:url(/images/home2.gif) top left no-repeat;
  text-indent:-999em;
}

#menu li.home{
  width:128px;
}

#menu li.planets{
  width:152px;
}

#menu li.fleets{
  width:152px;
}

#menu li.navigation{
  width:152px;
}

#menu li.research{
  width:152px;
}

#menu li.alliances{
  width:152px;
}


#menu li.home a{
  width:128px;
}

#menu li.planets a{
  width:152px;
  background:url(/images/planets.gif) top left no-repeat;
}

#menu li.fleets a{
  width:152px;
  background:url(/images/fleets.gif) top left no-repeat;
}

#menu li.navigation a{
  width:152px;
  background:url(/images/navigation.gif) top left no-repeat;
}

#menu li.research a{
  width:152px;
  background:url(/images/research.gif) top left no-repeat;
}

#menu li.alliances a{
  width:152px;
  background:url(/images/alliances.gif) top left no-repeat;
}

#menu li a:hover{
  background-position: -212px 0;
}


#menu li a.active{
  background-position: -424px 0;
  z-index:999;
  position:absolute;
}

.lower-content{

}

.content{
  background:#2C2C2C url(/images/head2back.gif) top left repeat-x;
  padding:10px;
  border:1px solid black;
  margin-bottom:10px;
}

.content h1{
  font-family:Play, 'Arial Black', sans-serif;
  text-transform:uppercase;
  text-shadow:1px 1px 0px black;
  margin-bottom:10px;
  height:20px;
}

.content h1 a{
  font-weight:bold;
}

.headbar{
  height:24px;
  padding:5px 10px;
}

.headbar p{
  margin:0;
  line-height:20px;
}

.menu{

}

.clear{
  clear:both;
}

.left{
  width:300px;
  float:left;
}

.right{
  width:590px;
  float:right;
}

.footer{
  text-align:center;
  height:24px;
  margin:0;
  margin-bottom:20px;
}
