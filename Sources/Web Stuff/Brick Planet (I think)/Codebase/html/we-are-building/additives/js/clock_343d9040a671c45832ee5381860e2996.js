function getTimeRemaining(e){var n=Date.parse(e)-Date.parse(new Date),t=Math.floor(n/1e3%60),a=Math.floor(n/1e3/60%60),r=Math.floor(n/36e5%24);return{total:n,days:Math.floor(n/864e5),hours:r,minutes:a,seconds:t}}function initializeClock(e,n){function t(){var e=getTimeRemaining(n);r.innerHTML=e.days,i.innerHTML=("0"+e.hours).slice(-2),o.innerHTML=("0"+e.minutes).slice(-2),e.total<=0&&clearInterval(l)}var a=document.getElementById(e),r=a.querySelector(".days"),i=a.querySelector(".hours"),o=a.querySelector(".minutes");t();var l=setInterval(t,1e3)}var deadline=new Date("09/18/2017 12:00 UTC-0600");initializeClock("countdown",deadline);