<br />
<br />
<br />
<br />
    <footer class="footer">
      <div class="container">
        <p class="text-muted">
        <br />
        This project is maintained by Takaaki Kurihara<br>
        Published with <a href="https://github.com/kuritaka/myfastdictionary" target="_blank">GitHub (https://github.com/kuritaka/myfastdictionary)</a><br>
        <br />
        </p>
      </div>
    </footer>

    <script>
    // Forced reload when the back button is pressed
    history.replaceState(null, document.getElementsByTagName('title')[0].innerHTML, null);
    window.addEventListener('popstate', function(e) {
      window.location.reload();
    });
    </script>
    
  </body>
</html>
