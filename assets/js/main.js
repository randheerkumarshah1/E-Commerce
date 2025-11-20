function openTab(evt, tabName){
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for(i=0;i<tabcontent.length;i++) tabcontent[i].style.display="none";
    tablinks = document.getElementsByClassName("tab-link");
    for(i=0;i<tablinks.length;i++) tablinks[i].classList.remove("active");
    document.getElementById(tabName).style.display="block";
    evt.currentTarget.classList.add("active");
  }
  
  function applyCoupon(){
      const code = document.getElementById('coupon_code').value;
      fetch('apply_coupon.php?code='+code)
      .then(res=>res.json())
      .then(data=>{
          if(data.success){
              document.getElementById('discount').innerText = '-$'+data.discount;
              document.getElementById('total').innerText = '$'+data.total;
              alert('Coupon applied successfully!');
          } else {
              alert(data.message);
          }
      });
  }
  