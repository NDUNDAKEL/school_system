document.addEventListener('DOMContentLoaded', function () {
   const menuToggle = document.querySelector('.menu-toggle');
   const nav = document.querySelector('nav');
   // const body=document.querySelector('body');
    
   menuToggle.addEventListener('click', function () {
       nav.classList.toggle('show')})
   })
   
   // body.addEventListener('click',function(){
   // //
   // })
 //ACCESSING THE LINKS AND THEIR CONTENTS.
//1) departments.
const science=document.getElementById('science')
const languages=document.getElementById('languages')
const technicals=document.getElementById('technicals')
const Math=document.getElementById('Math')
//accessing news data
const data=document.getElementById('data');
const pass=document.getElementById('password');
//setting display to none.
science.style.display='none'
languages.style.display='none'
technicals.style.display='none'
Math.style.display='none'
pass.style.display='none'
data.style.display='none'
//clubs and activities
const Clubs=document.getElementById('Clubs')
const football=document.getElementById('football')
//const Rugby=document.getElementById('Rugby')
const hockey=document.getElementById('hockey')
//const TT=document.getElementById('TT')
//const basketball=document.getElementById('basketball')
//const badminton=document.getElementById('badminton')
//setting display to none.
Clubs.style.display='none'
football.style.display='none'
//Rugby.style.display='none'
hockey.style.display='none'
//TT.style.display='none'
//basketball.display='none'
//badminton.style.display='none'
const mess=document.getElementById('mess');
//administration
const Principal=document.getElementById('principal')
const Teachers=document.getElementById('Teachers')
const staffs=document.getElementById('staffs')
const Dprincipal=document.getElementById('Dprincipal')
//setting display to none.
Principal.style.display='none'
Teachers.style.display='none'
staffs.style.display='none'
Dprincipal.style.display='none'

//Non-Teaching staffs
const kitchen=document.getElementById('kitchen');
const security=document.getElementById('security');
const cleaners=document.getElementById('cleaners');
const drivers=document.getElementById('drivers');
//setting display to none.
kitchen.style.display='none'
security.style.display='none'
cleaners.style.display='none'
drivers.style.display='none'

 //getting the DOM elements
 //colors

 const color1=document.getElementById('color1');
 const color2=document.getElementById('color2');
 const color3=document.getElementById('color3');
 const color4=document.getElementById('color4');
 const color5=document.getElementById('color5');
 //setting date
const contents=document.getElementsByClassName('cont')

 //end of colors
 const dep=document.getElementById('departments');
 const News=document.getElementById('News');
 const Activities=document.getElementById('Activities');
 const Admin=document.getElementById('administration');
 const NonTS=document.getElementById('Non-teaching');  
//changing the display of the selected DOM elements
 dep.style.display='none';
 News.style.display='none';
 Activities.style.display='none';
 Admin.style.display='none';
 NonTS.style.display='none';
const content=document.getElementById('content');
 function showDepartments(){
    content.style.display='none'
    dep.style.display='block'
    pass.style.display='none'
    data.style.display='none'
    News.style.display='none'
    Activities.style.display='none';
    Admin.style.display='none';
    NonTS.style.display='none';
    staffs.style.display='none'
    Dprincipal.style.display='none'
    Principal.style.display='none'
    Teachers.style.display='none'
    science.style.display='block'
      languages.style.display='none'
      technicals.style.display='none'
      Math.style.display='none'
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='none'
      cleaners.style.display='none'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='none'
 }
 function showAdmin(){
     content.style.display='none'
     dep.style.display='none'
     News.style.display='none';
     Activities.style.display='none';
     Admin.style.display='block';
     NonTS.style.display='none';
     staffs.style.display='none'
     Dprincipal.style.display='none'
     pass.style.display='none'
   data.style.display='none'
     Principal.style.display='block'
     Teachers.style.display='none'
     science.style.display='none'
      languages.style.display='none'
      technicals.style.display='none'
      Math.style.display='none'
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='none'
      cleaners.style.display='none'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='none'
  }
  function showActivities(){
     content.style.display='none'
     dep.style.display='none'
     News.style.display='none';
     Activities.style.display='block';
     Admin.style.display='none';
     pass.style.display='none'
        data.style.display='none'
     NonTS.style.display='none';
     staffs.style.display='none'
     Dprincipal.style.display='none'
     Principal.style.display='none'
     Teachers.style.display='none'
     science.style.display='none'
      languages.style.display='none'
      technicals.style.display='none'
      Math.style.display='none'
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
      Clubs.style.display='block'
      //TT.style.display='none'
      //badminton.style.display='none'
      cleaners.style.display='none'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='none'
  } 
  function showNonTS(){
     content.style.display='none'
     dep.style.display='none'
     News.style.display='none';
     Activities.style.display='none';
     Admin.style.display='none';
     NonTS.style.display='block';
     staffs.style.display='none'
     pass.style.display='none'
        data.style.display='none'
     Dprincipal.style.display='none'
     Principal.style.display='none'
     Teachers.style.display='none'
     science.style.display='none'
      languages.style.display='none'
      technicals.style.display='none'
      Math.style.display='none'
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='none'
      cleaners.style.display='block'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='none'
  } 
  function showNews(){
     content.style.display='none'
     dep.style.display='none'
     News.style.display='block';
     Activities.style.display='none';
     Admin.style.display='none';
     pass.style.display='none'
     data.style.display='block'
     NonTS.style.display='none';
     staffs.style.display='none'
     Dprincipal.style.display='none'
     Principal.style.display='none'
     Teachers.style.display='none'
     science.style.display='none'
      languages.style.display='none'
      technicals.style.display='none'
      Math.style.display='none'
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='none'
     
      cleaners.style.display='none'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='none'
  }
  function showColor1(){
     color1.style.color="white"
     color2.style.color="orange"
     color3.style.color="orange"
     color4.style.color="orange"
     color5.style.color="orange"
  }
  function showColor2(){
     color2.style.color="white"
     color1.style.color="orange"
     color3.style.color="orange"
     color4.style.color="orange"
     color5.style.color="orange"
  }
  function showColor3(){
     color3.style.color="white"
     color1.style.color="orange"
     color2.style.color="orange"
     color4.style.color="orange"
     color5.style.color="orange"
  }
  function showColor4(){
     color4.style.color="white"
     color3.style.color="orange"
     color2.style.color="orange"
     color5.style.color="orange"
  }
  function showColor5(){
     color5.style.color="white"
     color1.style.color="orange"
     color3.style.color="orange"
     color4.style.color="orange"
     color2.style.color="orange"
  } 
  //functions for the various links in the various categories.
  //admin
  function principal(){
   Principal.style.display='block'
   Dprincipal.style.display='none'
  
   Teachers.style.display='none'
   staffs.style.display='none'
  // console.log('hello my friend console')
  }  
  function deputy(){
   Dprincipal.style.display='block'
   Principal.style.display='none'
  
   Teachers.style.display='none'
   staffs.style.display='none'

  } 
  function teachers(){
     Dprincipal.style.display='none'
     Principal.style.display='none'
    
     Teachers.style.display='block'
     staffs.style.display='none'
    }  
    function staff(){
     staffs.style.display='block'
     Dprincipal.style.display='none'
     Principal.style.display='none'
    
     Teachers.style.display='none'
    }
    //departments
    function sciences(){
      science.style.display='block'
      languages.style.display='none'
     
      technicals.style.display='none'
      Math.style.display='none'
     }
     function language(){
      science.style.display='none'
      languages.style.display='block'
      technicals.style.display='none'
     
      Math.style.display='none'
     }
     function technical(){
      science.style.display='none'
      languages.style.display='none'
     
      technicals.style.display='block'
      Math.style.display='none'
     }
     function math(){
      science.style.display='none'
      languages.style.display='none'
      technicals.style.display='none'
     
      Math.style.display='block'
     }
     //clubs and activities
     function clubs(){
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
     
      Clubs.style.display='block'
      //TT.style.display='none'
      //badminton.style.display='none'
     }
     function Football(){
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='block'
     
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='none'
     }
     function Hockey(){
      //Rugby.style.display='none'
      hockey.style.display='block'
      football.style.display='none'
      Clubs.style.display='none'
     
      //TT.style.display='none'
      //badminton.style.display='none'
     }
     function rugby(){
      //Rugby.style.display='block'
      hockey.style.display='none'
      football.style.display='none'
     
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='none'
     }
     function Tt(){
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
     
      Clubs.style.display='none'
     // TT.style.display='block'
      //badminton.style.display='none'
     }
     function Badminton(){
      //Rugby.style.display='none'
      hockey.style.display='none'
      football.style.display='none'
      Clubs.style.display='none'
      //TT.style.display='none'
      //badminton.style.display='block'
     }
     //Non-ts
     function showWashrooms(){
      cleaners.style.display='block'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='none'
     }
     function showSecurity(){
      cleaners.style.display='none'
      security.style.display='block'
      kitchen.style.display='none'
      drivers.style.display='none'
     }
     function showKitchen(){
      cleaners.style.display='none'
      security.style.display='none'
      kitchen.style.display='block'
      drivers.style.display='none'
     }
     function showDrivers(){
      cleaners.style.display='none'
      security.style.display='none'
      kitchen.style.display='none'
      drivers.style.display='block'
     }
  //    const link=document.getElementById('links')
  //    link.addEventListener('click',function(event){
  //   event.target.style.color='red'
  //    })
 //for uploading files inside
 function showData(){
   data.style.display='block'
    pass.style.display='none'
 }
 function showpassword(){
   pass.style.display='block'
   data.style.display='none'
 }
 document.onreadystatechange = function () {
   var state = document.readyState;
   if (state == 'interactive') {
     document.getElementById('loader').style.display = "block";
   } else if (state == 'complete') {
     setTimeout(function () {
       document.getElementById('loader').style.display = "none";
     }, 1000); // You can adjust the delay as needed
   }
 };
 //emoji code
//  <script src="https://cdn.jsdelivr.net/npm/emoji-button@4.6.1/dist/emoji-button.min.js"></script>
//  document.addEventListener('DOMContentLoaded',()=>{
//    const buttonEmoji=document.createElement('button');
//    buttonEmoji.type='button';
//    buttonEmoji.textContent='😃';
//    buttonEmoji.style.marginLeft='10px';
//    document.getElementById('formemoji').insertBefore(buttonEmoji,document.getElementById('formemoji').childNodes[2]);
//    const picker=new EmojiButton();
//    button.addEventListener('click',()=>{
//       picker.togglePicker('button')
//    })
//    picker.on('emoji',emoji=>{
//       const commentBox=document.getElementById('comment');
//       commentBox.value +=emoji;
//    })
//  })