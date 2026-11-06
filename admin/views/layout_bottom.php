</main></div>
<script>
(function(){
  var side=document.getElementById('abmSide'),ov=document.getElementById('abmOv'),btn=document.getElementById('abmMenu');
  function tog(o){side.classList.toggle('abm-open',o);ov.classList.toggle('abm-open',o);}
  btn.addEventListener('click',function(){tog(!side.classList.contains('abm-open'));});ov.addEventListener('click',function(){tog(false);});
  var d=document.getElementById('abmDlg');
  if(d&&d.hasAttribute('data-auto')&&d.showModal)d.showModal();
  var s=document.getElementById('abmSearch');
  if(s)s.addEventListener('input',function(){var q=s.value.toLowerCase();document.querySelectorAll('#abmGrid .abm-card').forEach(function(c){c.style.display=c.textContent.toLowerCase().indexOf(q)>-1?'':'none';});});
})();
</script>
<script src="../assets/ui.js"></script>
</body></html>
