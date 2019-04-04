
  <nav class="navbar navbar-jdih">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="container">
          <ul class="nav navbar-nav">
				{!! $menu1 !!}
          </ul>
          <div class="navbar-form navbar-right boxSearch" role="search">
<gcse:searchbox-only resultsUrl="/cse"></gcse:searchbox-only>          
          </div>
        </div>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  <!--/.navbar-jdih-->