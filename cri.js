document.addEventListener('DOMContentLoaded',()=>{
 const sidebar=document.querySelector('.sidebar'); const lock=document.querySelector('#lock-icon'); const open=document.querySelector('#sidebar-open'); const close=document.querySelector('#sidebar-close');
 if(!sidebar) return;
 lock?.addEventListener('click',()=>{sidebar.classList.toggle('locked');sidebar.classList.toggle('hoverable');lock.classList.toggle('bx-lock-open-alt');lock.classList.toggle('bx-lock-alt');});
 open?.addEventListener('click',()=>sidebar.classList.toggle('close')); close?.addEventListener('click',()=>sidebar.classList.toggle('close'));
});
