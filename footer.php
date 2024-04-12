  <!-- Main Footer -->
  <footer class="main-footer">
    Copyright &copy; 2024<?php if (date('Y')!="2024") echo "-".date('Y'); ?> <strong>404error</a>. Készült a <strong><?=SITE_NAME; ?></strong> számára.
   
  </footer>

<script>
  function Loader(url, element)
  {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (element != null) {
          var res = this.responseText;
          document.getElementById(element).innerHTML = res;
        } 
    }
    };
    xhttp.open("GET", url, true);
    xhttp.send();
  }
</script>