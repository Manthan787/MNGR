(function(){
  $(document).ready(function() {
      var path = window.location.pathname.split('/')[1];
      var capitalized_path = path.substr(0,1).toUpperCase() + path.substr(1);
      if(!path)
        $('ul.nav.navbar-nav.navbar-right > li#Home').addClass("active");
      else
        $('ul.nav.navbar-nav.navbar-right > li#'+capitalized_path).addClass("active");
  })
})()
