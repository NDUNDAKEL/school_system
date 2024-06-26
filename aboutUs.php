<?php
$path="Database Operations/login1.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="aboutUs.css"/>
</head>
<body>
    <header>
      <div class="menu-toggle">&#9776;</div>
         <img src="makuenilogo.png" alt="school logo"> 
      <nav>
        <a id="color1" onclick="showAdmin(),showColor1()" href="#" >Administration</a>
        <a id="color2" onclick="showDepartments(),showColor2()" href="#">Departments</a>
        <a id="color3"onclick="showActivities(),showColor3()" href="#" >Sports and activities</a>
        <a id="color4" onclick="showNonTS(),showColor4()" href="#" >Non-teaching Staff</a>
        <a id="color5" onclick="showNews(),showColor5()" href="#" >News</a> 
        <a href="<?php echo $path; ?>" style="color:lightgreen; font-size:bolder">Login</a>
        </nav>
    </header>
    <main>
        <div id="content" style="overflow:scroll;">
           <img src="makuenistudents.jpeg" alt="school picture" style="height: auto; width:100%">
           <center>
       
           </center>
<p style='width:100% ;font-family:Times New Roman", Times, serif;'>Makueni Boys High school aims to inspire its students to find an attractive human role model in every path of life. The school challenges its students to aim for the highest possible level of achievement in all areas of school life: academic, spiritual (CU, YCS, SDA & Muslim), cultural and sporting. This emphasis on pursuit of excellence acknowledges the differing talents and abilities of individual students and does not demand the same outcome from all. We place great importance on developing intellectual curiosity by encouraging our students to question and search, explore and discover. We are always delighted when new families show an interest in becoming part of our school community. We welcome all new students and their parents as active participants in the life of the School and invite you to help us bring our vision closer to realisation.</p>
   </div>
         <div class="container" style='width:auto; position:static' id="administration">
               <div id="links" style='width:auto; position:relative;'>
                <a onclick='principal()' href="#">School Principal</a>
                <a onclick="deputy()" href="#">School Deputy Principals</a>
                <a onclick="teachers()" href="#">Teachers</a>
                <a onclick="staff()" href="#">Staff and Non Teaching Staff</a>
        </div>
        </div>
        <div class="content">
         <div id="adminDisplay">
            <p>Welcome to the Admin Content</p>
         </div>
            <div id="principal" style='margin-left:80px'>
          <center>
       <p>Makueni Boys School Principal</p>
           </center>
 
            </div>
            <div id="Dprincipal">
          
           <center>
           <p>Makueni Boys Deputy School Principal</p>
           </center>

            </div>
            <div id="Teachers">
            <center>
            <p>Makueni Boys Teachers</p>
           </center>
    
            </div>
            <div id="staffs">
            <center>
            <p>Makueni Boys School Staffs</p>
           </center>

            </div>
         </div>
        <div class="container" id="Non-teaching">
               <div id="links">
                <a onclick="showWashrooms()" href="#">Washrooms and Cleaners</a>
                <a onclick="showSecurity()" href="#">Security</a>
                <a onclick="showKitchen()" href="#">Kitchen</a>
                <a onclick="showDrivers()" href="#">Drivers</a>
            </div>
            </div>
        <div class="content">
         <div id="NonteachingDisplay">
         <center>
         <p>Makueni Boys School Non teaching staff</p>
           </center>
       </div>
           <div id="cleaners">
           <center>
           <p>Makueni Boys School Cleaners</p>
           </center>
 
           </div>
           <div id="security">
           <center>
           <p>Makueni Boys School Securuty</p>
           </center>

           </div>
           <div id="kitchen">
           <center>
           <p>Makueni Boys School Kitches</p>
           </center>

           </div>
           <div id="drivers">
           <center>
           <p>Makueni Boys School drivers</p>
           </center>

           </div>
         </div>
        <div class="container" id="Activities">
            <div id="links">
                <a onclick="clubs()" href="#">Clubs and societies</a>
                <a onclick="Football()" href="#">Football</a>
                <a onclick="Hockey()" href="#">Hockey</a>
                <!-- <a onclick="basketball()" href="#">BasketBall</a> -->
                <a onclick="rugby()" href="#">Rugby</a>
                <a onclick="Tt()" href="#">Table Tennis</a>
                <a onclick="Badminton()" href="#">Badminnton</a>
            </div>
            </div>
            <div class="content">
               <div id="ActivitiesDisplay">
               <center>
               <p>Makueni Boys School Activities Display</p>
           </center>

               </div>
            <div id="Clubs">
            <center>
            <p>Makueni Boys School Clubs</p>
           </center>

             </div>
             <div id="football">
             <center>
             <p>Makueni Boys School Football</p>
           </center>

             </div>
             <div id="hockey">
             <center>
             <p>Makueni Boys School Hockey</p>
           </center>

             </div>
             <!-- <div id="basketball">
                <p>This is our basketball team</p>
             </div> -->
             <div id="Rugby">
             <center>
             <p>Makueni Boys School Rugby</p>
           </center>

             </div>
             <div id="TT">
             <center>
             <p>Makueni Boys School Table Tennis</p>
           </center>

             </div>
             <div id="badminton">
             <center>
             <p>Makueni Boys School Badminton</p>
           </center>

             </div>
        </div>
        <div id="News">
       <h2 style='color:green;'> Makueni Boys beat academic giants in lower Eastern region<h2>
       <img src="news.jpeg" alt="school picture" style="height:60%; width:100%;">
       <p style='font-weight:normal'>Makueni Boys High School stunned traditional academic giants in the lower Eastern region after posting a performance index of 8.9 in last year’s Kenya Certificate of Secondary Education (KCSE) examination.

With an entry of 377 candidates, the 2023 class produced 14 A (plain), 67 A-, 79 B+, 64 B (plain), 67 B- and 53 C+, representing a 91.25 percent transition rate to the university.

Only 33 candidates fell short of qualifying for university. The class did not register any E, D- or D plain grade.</p><br>
<p style='font-weight:normal'>The candidates who scored straight As included Muema Kilonzo, Kiilu Muuo and Muunde Mutinda all with 83 points each. Mwithia Karimi, Eric Masila, Kennedy Mutava, Kasanga Mwendwa, Wambua Mwendwa and Solomon Gathogo scored A plain of 82 points each.

Ibrahim Konje, Kyalo Mutua, Mutunga Mutiso, Cleophas Ogamba and Kyale Muthama scored A plain of 81 points each.

“This is huge! We are excited with the results and I thank my entire teaching force, parents and support staff for being there for the candidates. For the class of 2023, I cannot describe my joy. I am a proud teacher. I am happy that the future of these students is bright,”said Mr Mutua.

However, the chief principal pointed out that the good results did not come easy.

“It was a cocktail of dedication, self-denial and discipline. We also covered the syllabus in good time to allow for an adequate period for revision. We are not resting until we clinch a mean grade of 10 points,” he added.

In Precious Blood Kilungu, the 2023 class climbed to a performance index of 8.2, up from 7.9 posted in the previous year. With an entry of 206 candidates, two students managed to score A plain while 13 scored A-, 28 B+, 48 B plain, 54 B- and 32 C+, translating to 86 percent transition to the university.</p>


        </div>
    </div>
        <div class="container" id="departments">
            <div id="links">
                <a onclick="sciences()" href="#">Science Department</a>
                <a onclick="language()"href="#">Languages Department</a>
                <a onclick="technical()" href="#">Technicals Department</a>
                <a onclick="math()"href="#">Math Department</a>
            </div>
            </div>
            <div class="content">
               <div id="DepartmentDisplay">
                  <p>This is the departments content</p>
               </div>
         <div id="science">
         <center>
          
           </center>
 
         </div>
         <div id="languages">
         <center>
          
           </center>
 
         </div>
         <div id="technicals">
         <center>
          
           </center>
 
         </div>
         <div id="Math">
         <center>
          
           </center>
 
        </div>
         </div>
    </main>
<footer>
<center>
   <p style="color: blue;">Makueni Boys High School</p>
    <h2><span>Like a tree knowledge grows</span></h2>
    <p style="color:white;">School Space &copy 2024</p>
</center>
</footer>
<script src="aboutUs.js"></script>
</body>
</html>